-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Feb 23, 2026 at 10:27 AM
-- Server version: 9.1.0
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gestion_programmes`
--

DELIMITER $$
--
-- Procedures
--
DROP PROCEDURE IF EXISTS `calculer_moyenne_eleve`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `calculer_moyenne_eleve` (IN `p_id_eleve` INT, IN `p_trimestre` VARCHAR(10), IN `p_annee` VARCHAR(20))   BEGIN
    SELECT 
        e.id_eleve,
        e.nom,
        e.prenom,
        AVG(n.valeur) as moyenne_generale,
        COUNT(n.id_note) as nombre_notes,
        MIN(n.valeur) as note_minimale,
        MAX(n.valeur) as note_maximale
    FROM eleve e
    JOIN note n ON e.id_eleve = n.id_eleve
    JOIN examen ex ON n.id_examen = ex.id_examen
    WHERE e.id_eleve = p_id_eleve 
    AND ex.periode LIKE CONCAT('%', p_trimestre, '%')
    AND ex.annee_scolaire = p_annee
    GROUP BY e.id_eleve, e.nom, e.prenom;
END$$

DROP PROCEDURE IF EXISTS `inscrire_eleve`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `inscrire_eleve` (IN `p_nom` VARCHAR(100), IN `p_prenom` VARCHAR(100), IN `p_date_naissance` DATE, IN `p_sexe` ENUM('M','F'), IN `p_id_classe` INT, IN `p_id_tuteur` INT, IN `p_id_annee` INT)   BEGIN
    DECLARE v_matricule VARCHAR(50);
    DECLARE v_id_eleve INT;
    
    -- Générer un matricule unique
    SET v_matricule = CONCAT('ELE', YEAR(CURDATE()), LPAD(FLOOR(RAND() * 10000), 4, '0'));
    
    -- Insérer l'élève
    INSERT INTO eleve (matricule, nom, prenom, date_naissance, sexe, id_classe_actuelle, id_tuteur, date_inscription)
    VALUES (v_matricule, p_nom, p_prenom, p_date_naissance, p_sexe, p_id_classe, p_id_tuteur, CURDATE());
    
    -- Récupérer l'ID de l'élève inséré
    SET v_id_eleve = LAST_INSERT_ID();
    
    -- Créer l'inscription
    INSERT INTO inscription (id_eleve, id_classe, id_annee_scolaire, date_inscription, type, statut)
    VALUES (v_id_eleve, p_id_classe, p_id_annee, CURDATE(), 'nouveau', 'validee');
    
    -- Retourner le matricule et l'ID
    SELECT v_matricule AS matricule, v_id_eleve AS id_eleve;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `activite`
--

DROP TABLE IF EXISTS `activite`;
CREATE TABLE IF NOT EXISTS `activite` (
  `id_activite` int NOT NULL AUTO_INCREMENT,
  `id_lecon` int NOT NULL,
  `type` enum('glisser_deposer','qcm','association','completer') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `instruction` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id_activite`),
  KEY `id_lecon` (`id_lecon`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `activites`
--

DROP TABLE IF EXISTS `activites`;
CREATE TABLE IF NOT EXISTS `activites` (
  `id_activite` int NOT NULL AUTO_INCREMENT,
  `id_utilisateur` int NOT NULL,
  `nom_utilisateur` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `action` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `details` text COLLATE utf8mb4_unicode_ci,
  `date_activite` datetime NOT NULL,
  `statut` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT 'Succès',
  PRIMARY KEY (`id_activite`),
  KEY `id_utilisateur` (`id_utilisateur`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `activites`
--

INSERT INTO `activites` (`id_activite`, `id_utilisateur`, `nom_utilisateur`, `action`, `details`, `date_activite`, `statut`) VALUES
(1, 1, 'Admin System', 'Connexion', 'Connexion depuis 192.168.1.1', '2026-02-23 08:30:00', 'Succès'),
(2, 2, 'Mamadou Diop', 'Saisie note', 'Saisie des notes pour examen ID 1', '2026-02-22 14:15:00', 'Succès'),
(3, 7, 'Marie Ngoie', 'Consultation bulletin', 'Consultation du bulletin 1er trimestre', '2026-02-21 10:45:00', 'Succès');

-- --------------------------------------------------------

--
-- Table structure for table `administrateurs`
--

DROP TABLE IF EXISTS `administrateurs`;
CREATE TABLE IF NOT EXISTS `administrateurs` (
  `id_administrateur` int NOT NULL AUTO_INCREMENT,
  `id_utilisateur` int NOT NULL,
  `niveau_acces` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `departement` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_prise_fonction` date NOT NULL,
  `date_fin_fonction` date DEFAULT NULL,
  `permissions_speciales` json DEFAULT NULL,
  `dernier_audit` datetime DEFAULT NULL,
  `authentification_2facteurs` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id_administrateur`),
  KEY `id_utilisateur` (`id_utilisateur`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `administrateurs`
--

INSERT INTO `administrateurs` (`id_administrateur`, `id_utilisateur`, `niveau_acces`, `departement`, `date_prise_fonction`, `date_fin_fonction`, `permissions_speciales`, `dernier_audit`, `authentification_2facteurs`) VALUES
(1, 1, 'super_admin', 'Direction', '2024-01-01', NULL, '[\"all\"]', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `annee_scolaire`
--

DROP TABLE IF EXISTS `annee_scolaire`;
CREATE TABLE IF NOT EXISTS `annee_scolaire` (
  `id_annee` int NOT NULL AUTO_INCREMENT,
  `libelle` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_debut` date NOT NULL,
  `date_fin` date NOT NULL,
  `actif` tinyint(1) DEFAULT '0',
  `date_creation` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_annee`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `annee_scolaire`
--

INSERT INTO `annee_scolaire` (`id_annee`, `libelle`, `date_debut`, `date_fin`, `actif`, `date_creation`) VALUES
(1, '2023-2024', '2023-09-01', '2024-07-31', 0, '2026-02-23 10:22:38'),
(2, '2024-2025', '2024-09-01', '2025-07-31', 1, '2026-02-23 10:22:38'),
(3, '2025-2026', '2025-09-01', '2026-07-31', 0, '2026-02-23 10:22:38');

-- --------------------------------------------------------

--
-- Table structure for table `badges`
--

DROP TABLE IF EXISTS `badges`;
CREATE TABLE IF NOT EXISTS `badges` (
  `id_badge` int NOT NULL AUTO_INCREMENT,
  `nom_badge` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `condition_obtention` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id_badge`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `badges`
--

INSERT INTO `badges` (`id_badge`, `nom_badge`, `condition_obtention`) VALUES
(1, 'Mathématicien en herbe', 'Obtenir 100% à 5 exercices de mathématiques'),
(2, 'Petit écrivain', 'Rédiger 10 textes sans faute'),
(3, 'Assidu', 'Assister à tous les cours pendant un mois'),
(4, 'Premier de la classe', 'Obtenir la meilleure moyenne de la classe'),
(5, 'Bibliophile', 'Emprunter 10 livres à la bibliothèque');

-- --------------------------------------------------------

--
-- Table structure for table `badges_obtenus`
--

DROP TABLE IF EXISTS `badges_obtenus`;
CREATE TABLE IF NOT EXISTS `badges_obtenus` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_badge` int NOT NULL,
  `id_utilisateur` int NOT NULL,
  `date_obtention` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `id_badge` (`id_badge`),
  KEY `id_utilisateur` (`id_utilisateur`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bulletin`
--

DROP TABLE IF EXISTS `bulletin`;
CREATE TABLE IF NOT EXISTS `bulletin` (
  `id_bulletin` int NOT NULL AUTO_INCREMENT,
  `id_eleve` int NOT NULL,
  `id_classe` int NOT NULL,
  `trimestre` enum('1er','2ème','3ème') COLLATE utf8mb4_unicode_ci NOT NULL,
  `annee_scolaire` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `moyenne_generale` decimal(5,2) DEFAULT NULL,
  `rang` int DEFAULT NULL,
  `total_effectif` int DEFAULT NULL,
  `appreciation_generale` text COLLATE utf8mb4_unicode_ci,
  `date_emission` date DEFAULT NULL,
  `id_enseignant_principal` int DEFAULT NULL,
  PRIMARY KEY (`id_bulletin`),
  KEY `id_eleve` (`id_eleve`),
  KEY `id_classe` (`id_classe`),
  KEY `id_enseignant_principal` (`id_enseignant_principal`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bulletin`
--

INSERT INTO `bulletin` (`id_bulletin`, `id_eleve`, `id_classe`, `trimestre`, `annee_scolaire`, `moyenne_generale`, `rang`, `total_effectif`, `appreciation_generale`, `date_emission`, `id_enseignant_principal`) VALUES
(1, 1, 1, '1er', '2024-2025', 14.17, 2, 3, 'Bon trimestre, quelques lacunes à combler', '2024-12-20', NULL),
(2, 2, 1, '1er', '2024-2025', 10.33, 3, 3, 'Trimestre moyen, doit fournir plus d\'efforts', '2024-12-20', NULL),
(3, 3, 1, '1er', '2024-2025', 17.17, 1, 3, 'Excellent trimestre, félicitations', '2024-12-20', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `classe`
--

DROP TABLE IF EXISTS `classe`;
CREATE TABLE IF NOT EXISTS `classe` (
  `id_classe` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `niveau` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cycle` enum('primaire','secondaire','superieur') COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_option` int DEFAULT NULL,
  `id_section` int DEFAULT NULL,
  `capacite` int DEFAULT '30',
  `id_etablissement` int DEFAULT NULL,
  `annee_scolaire` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id_classe`),
  KEY `id_option` (`id_option`),
  KEY `id_section` (`id_section`),
  KEY `id_etablissement` (`id_etablissement`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `classe`
--

INSERT INTO `classe` (`id_classe`, `nom`, `niveau`, `cycle`, `id_option`, `id_section`, `capacite`, `id_etablissement`, `annee_scolaire`) VALUES
(1, '6ème A Scientifique', '6ème', 'secondaire', 1, 1, 35, 1, '2024-2025'),
(2, '6ème B Scientifique', '6ème', 'secondaire', 1, 1, 35, 1, '2024-2025'),
(3, '5ème Littéraire A', '5ème', 'secondaire', 3, 2, 30, 1, '2024-2025'),
(4, '4ème Commerciale', '4ème', 'secondaire', 4, 3, 40, 2, '2024-2025'),
(5, '6ème Technique', '6ème', 'secondaire', 5, 4, 30, 2, '2024-2025'),
(6, 'CM2 A', 'CM2', 'primaire', NULL, NULL, 30, 3, '2024-2025');

-- --------------------------------------------------------

--
-- Table structure for table `competences`
--

DROP TABLE IF EXISTS `competences`;
CREATE TABLE IF NOT EXISTS `competences` (
  `id_competence` int NOT NULL AUTO_INCREMENT,
  `nom_competence` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `niveau_difficulte` int DEFAULT NULL,
  `id_cours` int NOT NULL,
  PRIMARY KEY (`id_competence`),
  KEY `id_cours` (`id_cours`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `competences`
--

INSERT INTO `competences` (`id_competence`, `nom_competence`, `description`, `niveau_difficulte`, `id_cours`) VALUES
(1, 'Calcul mental', 'Effectuer des calculs simples mentalement', 2, 1),
(2, 'Résolution de problèmes', 'Résoudre des problèmes mathématiques simples', 3, 2),
(3, 'Expression écrite', 'Rédiger des phrases correctes', 2, 4);

-- --------------------------------------------------------

--
-- Table structure for table `contenu_cours`
--

DROP TABLE IF EXISTS `contenu_cours`;
CREATE TABLE IF NOT EXISTS `contenu_cours` (
  `id_contenu` int NOT NULL AUTO_INCREMENT,
  `id_cours` int NOT NULL,
  `titre_section` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contenu` text COLLATE utf8mb4_unicode_ci,
  `type_contenu` enum('texte','video','document','exercice','quiz') COLLATE utf8mb4_unicode_ci DEFAULT 'texte',
  `ordre` int DEFAULT '1',
  `date_creation` datetime DEFAULT CURRENT_TIMESTAMP,
  `date_modification` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_contenu`),
  KEY `id_cours` (`id_cours`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contenu_cours`
--

INSERT INTO `contenu_cours` (`id_contenu`, `id_cours`, `titre_section`, `contenu`, `type_contenu`, `ordre`, `date_creation`, `date_modification`) VALUES
(1, 1, 'Introduction', 'Les nombres naturels sont les nombres entiers positifs (0, 1, 2, 3...)', 'texte', 1, '2026-02-23 10:22:38', '2026-02-23 10:22:38'),
(2, 1, 'Propriétés', 'La commutativité : a + b = b + a, L\'associativité : (a + b) + c = a + (b + c)', 'texte', 2, '2026-02-23 10:22:38', '2026-02-23 10:22:38'),
(3, 2, 'Définition', 'Une fraction représente une partie d\'un tout. Exemple : 1/2 représente la moitié', 'texte', 1, '2026-02-23 10:22:38', '2026-02-23 10:22:38'),
(4, 2, 'Exercices pratiques', 'Calculez : 1/4 + 1/4 = ?', 'exercice', 2, '2026-02-23 10:22:38', '2026-02-23 10:22:38');

-- --------------------------------------------------------

--
-- Table structure for table `contenu_lecon`
--

DROP TABLE IF EXISTS `contenu_lecon`;
CREATE TABLE IF NOT EXISTS `contenu_lecon` (
  `id_contenu` int NOT NULL AUTO_INCREMENT,
  `id_lecon` int NOT NULL,
  `type` enum('texte','video','audio','image') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contenu` text COLLATE utf8mb4_unicode_ci,
  `ordre` int DEFAULT NULL,
  PRIMARY KEY (`id_contenu`),
  KEY `id_lecon` (`id_lecon`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cours`
--

DROP TABLE IF EXISTS `cours`;
CREATE TABLE IF NOT EXISTS `cours` (
  `id_cours` int NOT NULL AUTO_INCREMENT,
  `titre` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `ordre_progression` int DEFAULT NULL,
  `id_matiere` int NOT NULL,
  `id_programme` int NOT NULL,
  `id_classe` int DEFAULT NULL,
  `niveau_difficulte` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT 'Intermédiaire',
  `duree_estimee` int DEFAULT '60',
  `date_creation` datetime DEFAULT CURRENT_TIMESTAMP,
  `date_modification` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `statut` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT 'Actif',
  `type_cours` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT 'Mixte',
  `objectifs_apprentissage` text COLLATE utf8mb4_unicode_ci,
  `prerequis` text COLLATE utf8mb4_unicode_ci,
  `ressources_externes` text COLLATE utf8mb4_unicode_ci,
  `nb_vues` int DEFAULT '0',
  `visible` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id_cours`),
  KEY `id_matiere` (`id_matiere`),
  KEY `id_programme` (`id_programme`),
  KEY `id_classe` (`id_classe`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cours`
--

INSERT INTO `cours` (`id_cours`, `titre`, `description`, `ordre_progression`, `id_matiere`, `id_programme`, `id_classe`, `niveau_difficulte`, `duree_estimee`, `date_creation`, `date_modification`, `statut`, `type_cours`, `objectifs_apprentissage`, `prerequis`, `ressources_externes`, `nb_vues`, `visible`) VALUES
(1, 'Les nombres entiers', 'Introduction aux nombres entiers et opérations de base', 1, 1, 1, 1, 'Débutant', 120, '2026-02-23 10:22:38', '2026-02-23 10:22:38', 'Actif', 'Théorique', 'Maîtriser les opérations sur les nombres entiers', NULL, NULL, 0, 1),
(2, 'Les fractions', 'Comprendre et manipuler les fractions', 2, 1, 1, 1, 'Intermédiaire', 180, '2026-02-23 10:22:38', '2026-02-23 10:22:38', 'Actif', 'Mixte', 'Savoir utiliser les fractions dans des calculs', NULL, NULL, 0, 1),
(3, 'Géométrie de base', 'Points, droites, segments et angles', 3, 1, 1, 1, 'Débutant', 150, '2026-02-23 10:22:38', '2026-02-23 10:22:38', 'Actif', 'Théorique', 'Connaître les notions géométriques fondamentales', NULL, NULL, 0, 1),
(4, 'La phrase simple', 'Structure de la phrase et ponctuation', 1, 2, 2, 1, 'Débutant', 90, '2026-02-23 10:22:38', '2026-02-23 10:22:38', 'Actif', 'Théorique', 'Construire des phrases correctes', NULL, NULL, 0, 1),
(5, 'Conjugaison présent', 'Verbes du 1er et 2ème groupe au présent', 2, 2, 2, 1, 'Débutant', 120, '2026-02-23 10:22:38', '2026-02-23 10:22:38', 'Actif', 'Pratique', 'Conjuguer correctement au présent', NULL, NULL, 0, 1),
(6, 'Present simple', 'Le présent simple en anglais', 1, 3, 3, 1, 'Débutant', 90, '2026-02-23 10:22:38', '2026-02-23 10:22:38', 'Actif', 'Pratique', 'Utiliser le présent simple en anglais', NULL, NULL, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `cours_enseignants`
--

DROP TABLE IF EXISTS `cours_enseignants`;
CREATE TABLE IF NOT EXISTS `cours_enseignants` (
  `id_affectation` int NOT NULL AUTO_INCREMENT,
  `id_cours` int NOT NULL,
  `id_enseignant` int NOT NULL,
  `date_affectation` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `statut_affectation` enum('actif','inactif','terminé') COLLATE utf8mb4_unicode_ci DEFAULT 'actif',
  `annee_scolaire` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '2024-2025',
  `observations` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id_affectation`),
  KEY `id_cours` (`id_cours`),
  KEY `id_enseignant` (`id_enseignant`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cours_enseignants`
--

INSERT INTO `cours_enseignants` (`id_affectation`, `id_cours`, `id_enseignant`, `date_affectation`, `statut_affectation`, `annee_scolaire`, `observations`) VALUES
(1, 1, 1, '2026-02-23 10:22:38', 'actif', '2024-2025', 'Cours principal'),
(2, 2, 1, '2026-02-23 10:22:38', 'actif', '2024-2025', 'Cours principal'),
(3, 3, 1, '2026-02-23 10:22:38', 'actif', '2024-2025', NULL),
(4, 4, 2, '2026-02-23 10:22:38', 'actif', '2024-2025', NULL),
(5, 5, 2, '2026-02-23 10:22:38', 'actif', '2024-2025', NULL),
(6, 6, 2, '2026-02-23 10:22:38', 'actif', '2024-2025', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `directeur_discipline`
--

DROP TABLE IF EXISTS `directeur_discipline`;
CREATE TABLE IF NOT EXISTS `directeur_discipline` (
  `id_directeur` int NOT NULL AUTO_INCREMENT,
  `id_utilisateur` int NOT NULL,
  `bureau` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telephone_pro` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `plages_disponibilite` json DEFAULT NULL,
  `date_debut` date NOT NULL,
  `date_fin` date DEFAULT NULL,
  PRIMARY KEY (`id_directeur`),
  KEY `id_utilisateur` (`id_utilisateur`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `directeur_discipline`
--

INSERT INTO `directeur_discipline` (`id_directeur`, `id_utilisateur`, `bureau`, `telephone_pro`, `plages_disponibilite`, `date_debut`, `date_fin`) VALUES
(1, 4, 'Bureau 30', '771234503', '{\"lundi\": \"8h-12h\", \"mercredi\": \"14h-17h\"}', '2024-09-01', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `discipline`
--

DROP TABLE IF EXISTS `discipline`;
CREATE TABLE IF NOT EXISTS `discipline` (
  `id_discipline` int NOT NULL AUTO_INCREMENT,
  `id_eleve` int NOT NULL,
  `type_infraction` enum('retard','absence','indiscipline','violence','triche','autre') COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `date_infraction` date NOT NULL,
  `lieu` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `temoins` json DEFAULT NULL,
  `sanction` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `duree_sanction` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_personnel_rapport` int DEFAULT NULL,
  `id_parent_informe` int DEFAULT NULL,
  `statut` enum('en_attente','traite','archive') COLLATE utf8mb4_unicode_ci DEFAULT 'en_attente',
  `date_rapport` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_discipline`),
  KEY `id_eleve` (`id_eleve`),
  KEY `id_personnel_rapport` (`id_personnel_rapport`),
  KEY `id_parent_informe` (`id_parent_informe`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `discipline`
--

INSERT INTO `discipline` (`id_discipline`, `id_eleve`, `type_infraction`, `description`, `date_infraction`, `lieu`, `temoins`, `sanction`, `duree_sanction`, `id_personnel_rapport`, `id_parent_informe`, `statut`, `date_rapport`) VALUES
(1, 2, 'retard', 'Arrivée en classe avec 15 minutes de retard', '2024-10-10', 'Salle 101', NULL, 'Avertissement oral', NULL, 4, NULL, 'traite', '2026-02-23 10:22:38'),
(2, 2, 'absence', 'Absence non justifiée au cours de mathématiques', '2024-11-05', NULL, NULL, 'Retenue', NULL, 4, NULL, 'traite', '2026-02-23 10:22:38'),
(3, 3, 'indiscipline', 'Discussion en classe pendant le cours', '2024-11-15', 'Salle 102', NULL, 'Observation', NULL, 4, NULL, 'en_attente', '2026-02-23 10:22:38');

-- --------------------------------------------------------

--
-- Table structure for table `eleve`
--

DROP TABLE IF EXISTS `eleve`;
CREATE TABLE IF NOT EXISTS `eleve` (
  `id_eleve` int NOT NULL AUTO_INCREMENT,
  `id_utilisateur` int DEFAULT NULL,
  `matricule` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nom` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_naissance` date NOT NULL,
  `lieu_naissance` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sexe` enum('M','F') COLLATE utf8mb4_unicode_ci NOT NULL,
  `nationalite` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT 'Congolaise',
  `adresse` text COLLATE utf8mb4_unicode_ci,
  `id_classe_actuelle` int DEFAULT NULL,
  `id_tuteur` int DEFAULT NULL,
  `date_inscription` date DEFAULT NULL,
  PRIMARY KEY (`id_eleve`),
  UNIQUE KEY `matricule` (`matricule`),
  KEY `id_utilisateur` (`id_utilisateur`),
  KEY `id_classe_actuelle` (`id_classe_actuelle`),
  KEY `id_tuteur` (`id_tuteur`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `eleve`
--

INSERT INTO `eleve` (`id_eleve`, `id_utilisateur`, `matricule`, `nom`, `prenom`, `date_naissance`, `lieu_naissance`, `sexe`, `nationalite`, `adresse`, `id_classe_actuelle`, `id_tuteur`, `date_inscription`) VALUES
(1, 7, 'ELE2024001', 'Ngoie', 'Marie', '2010-05-12', 'Lubumbashi', 'F', 'Congolaise', 'Av. du Lac N°15, Lubumbashi', 1, 1, '2024-09-05'),
(2, 8, 'ELE2024002', 'Kalonji', 'Jean', '2009-11-03', 'Lubumbashi', 'M', 'Congolaise', 'Av. de la Gare N°8, Lubumbashi', 1, 2, '2024-09-05'),
(3, 9, 'ELE2024003', 'Mutombo', 'Sophie', '2010-02-28', 'Kinshasa', 'F', 'Congolaise', 'Av. des Écoles N°22, Lubumbashi', 2, 3, '2024-09-06'),
(4, 10, 'ELE2024004', 'Ilunga', 'Paul', '2010-08-15', 'Lubumbashi', 'M', 'Congolaise', 'Av. de l\'Université N°12, Lubumbashi', 2, 1, '2024-09-06'),
(5, 11, 'ELE2024005', 'Kabasele', 'Lucie', '2009-07-22', 'Kinshasa', 'F', 'Congolaise', 'Av. du Marché N°45, Lubumbashi', 3, 2, '2024-09-07');

-- --------------------------------------------------------

--
-- Table structure for table `emprunt`
--

DROP TABLE IF EXISTS `emprunt`;
CREATE TABLE IF NOT EXISTS `emprunt` (
  `id_emprunt` int NOT NULL AUTO_INCREMENT,
  `id_livre` int NOT NULL,
  `id_eleve` int DEFAULT NULL,
  `id_enseignant` int DEFAULT NULL,
  `date_emprunt` date NOT NULL,
  `date_retour_prevue` date NOT NULL,
  `date_retour_effective` date DEFAULT NULL,
  `statut` enum('en_cours','retourne','en_retard','perdu') COLLATE utf8mb4_unicode_ci DEFAULT 'en_cours',
  `penalites` decimal(10,2) DEFAULT '0.00',
  `remarques` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id_emprunt`),
  KEY `id_livre` (`id_livre`),
  KEY `id_eleve` (`id_eleve`),
  KEY `id_enseignant` (`id_enseignant`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `emprunt`
--

INSERT INTO `emprunt` (`id_emprunt`, `id_livre`, `id_eleve`, `id_enseignant`, `date_emprunt`, `date_retour_prevue`, `date_retour_effective`, `statut`, `penalites`, `remarques`) VALUES
(1, 1, 1, NULL, '2024-10-01', '2024-10-15', '2024-10-14', 'retourne', 0.00, NULL),
(2, 1, 2, NULL, '2024-10-20', '2024-11-03', NULL, 'en_cours', 0.00, NULL),
(3, 2, 3, NULL, '2024-10-25', '2024-11-08', NULL, 'en_cours', 0.00, NULL),
(4, 2, 1, NULL, '2024-11-01', '2024-11-15', NULL, 'en_cours', 0.00, NULL);

--
-- Triggers `emprunt`
--
DROP TRIGGER IF EXISTS `restore_exemplaires_disponibles_retour`;
DELIMITER $$
CREATE TRIGGER `restore_exemplaires_disponibles_retour` AFTER UPDATE ON `emprunt` FOR EACH ROW BEGIN
    IF NEW.statut = 'retourne' AND OLD.statut != 'retourne' THEN
        UPDATE livre 
        SET exemplaires_disponibles = exemplaires_disponibles + 1
        WHERE id_livre = NEW.id_livre;
    END IF;
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `update_exemplaires_disponibles_emprunt`;
DELIMITER $$
CREATE TRIGGER `update_exemplaires_disponibles_emprunt` AFTER INSERT ON `emprunt` FOR EACH ROW BEGIN
    UPDATE livre 
    SET exemplaires_disponibles = exemplaires_disponibles - 1
    WHERE id_livre = NEW.id_livre;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `enseignant`
--

DROP TABLE IF EXISTS `enseignant`;
CREATE TABLE IF NOT EXISTS `enseignant` (
  `id_enseignant` int NOT NULL AUTO_INCREMENT,
  `id_utilisateur` int DEFAULT NULL,
  `matricule` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nom` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_naissance` date NOT NULL,
  `lieu_naissance` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sexe` enum('M','F') COLLATE utf8mb4_unicode_ci NOT NULL,
  `nationalite` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT 'Congolaise',
  `adresse` text COLLATE utf8mb4_unicode_ci,
  `telephone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `specialite` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `grade` enum('A1','A2','A3','A4','A5') COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_recrutement` date DEFAULT NULL,
  `diplomes` json DEFAULT NULL,
  `matieres_enseignees` json DEFAULT NULL,
  `id_etablissement` int DEFAULT NULL,
  PRIMARY KEY (`id_enseignant`),
  UNIQUE KEY `matricule` (`matricule`),
  KEY `id_utilisateur` (`id_utilisateur`),
  KEY `id_etablissement` (`id_etablissement`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `enseignant`
--

INSERT INTO `enseignant` (`id_enseignant`, `id_utilisateur`, `matricule`, `nom`, `prenom`, `date_naissance`, `lieu_naissance`, `sexe`, `nationalite`, `adresse`, `telephone`, `email`, `specialite`, `grade`, `date_recrutement`, `diplomes`, `matieres_enseignees`, `id_etablissement`) VALUES
(1, 2, 'ENS001', 'Diop', 'Mamadou', '1985-03-15', NULL, 'M', 'Congolaise', NULL, '771234501', 'mamadou.diop@ecole.sn', 'Mathématiques', 'A2', '2015-09-01', '[\"Licence en Mathématiques\", \"CAPES\"]', NULL, 1),
(2, 3, 'ENS002', 'Mbala', 'Jeanne', '1990-07-22', NULL, 'F', 'Congolaise', NULL, '771234502', 'jeanne.mbala@ecole.sn', 'Français', 'A3', '2018-10-15', '[\"Master en Lettres\", \"CAPES\"]', NULL, 1),
(3, 6, 'ENS003', 'Tshibangu', 'Pierre', '1988-11-30', NULL, 'M', 'Congolaise', NULL, '771234505', 'pierre.tshibangu@ecole.sn', 'Physique', 'A2', '2016-02-10', '[\"Licence en Physique\"]', NULL, 2);

-- --------------------------------------------------------

--
-- Table structure for table `etablissement`
--

DROP TABLE IF EXISTS `etablissement`;
CREATE TABLE IF NOT EXISTS `etablissement` (
  `id_etablissement` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('primaire','secondaire','lycee','technique') COLLATE utf8mb4_unicode_ci NOT NULL,
  `adresse` text COLLATE utf8mb4_unicode_ci,
  `telephone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `province` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ville` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `code_postal` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `directeur_nom` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_creation` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_etablissement`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `etablissement`
--

INSERT INTO `etablissement` (`id_etablissement`, `nom`, `type`, `adresse`, `telephone`, `email`, `province`, `ville`, `code_postal`, `directeur_nom`, `date_creation`) VALUES
(1, 'Lycée Saint Joseph', 'secondaire', 'Avenue de la Paix N°123', '+243812345678', 'contact@saintjoseph.cd', 'Kinshasa', 'Kinshasa', NULL, 'Dr. Jean Mukendi', '2026-02-23 10:22:38'),
(2, 'Complexe scolaire Tukankamane', 'secondaire', 'Av. Kabongo N°45', '+243991234567', 'info@tukankamane.cd', 'Haut-Katanga', 'Lubumbashi', NULL, 'Mme. Marie Kabeya', '2026-02-23 10:22:38'),
(3, 'École Primaire Bethesaida', 'primaire', 'Av. Maendeleo N°78', '+243971234567', 'bethesaida@ecole.cd', 'Nord-Kivu', 'Goma', NULL, 'M. Pierre Balola', '2026-02-23 10:22:38');

-- --------------------------------------------------------

--
-- Table structure for table `examen`
--

DROP TABLE IF EXISTS `examen`;
CREATE TABLE IF NOT EXISTS `examen` (
  `id_examen` int NOT NULL AUTO_INCREMENT,
  `type_examen` enum('Interrogation','Devoir','Composition','Examen final') COLLATE utf8mb4_unicode_ci NOT NULL,
  `periode` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_examen` date NOT NULL,
  `nom` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `coefficient` decimal(3,1) DEFAULT '1.0',
  `id_classe` int NOT NULL,
  `id_enseignant` int DEFAULT NULL,
  `heure_debut` time DEFAULT NULL,
  `heure_fin` time DEFAULT NULL,
  `id_salle` int DEFAULT NULL,
  `annee_scolaire` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_creation` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_examen`),
  KEY `id_classe` (`id_classe`),
  KEY `id_enseignant` (`id_enseignant`),
  KEY `id_salle` (`id_salle`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `examen`
--

INSERT INTO `examen` (`id_examen`, `type_examen`, `periode`, `date_examen`, `nom`, `coefficient`, `id_classe`, `id_enseignant`, `heure_debut`, `heure_fin`, `id_salle`, `annee_scolaire`, `date_creation`) VALUES
(1, 'Interrogation', '1er trimestre', '2024-10-15', 'Interrogation de mathématiques - Nombres entiers', 1.0, 1, 1, '08:00:00', '09:00:00', 1, '2024-2025', '2026-02-23 10:22:38'),
(2, 'Devoir', '1er trimestre', '2024-11-20', 'Devoir de français - La phrase simple', 2.0, 1, 2, '10:00:00', '12:00:00', 2, '2024-2025', '2026-02-23 10:22:38'),
(3, 'Composition', '1er trimestre', '2024-12-10', 'Composition du 1er trimestre - Mathématiques', 3.0, 1, 1, '08:00:00', '11:00:00', 1, '2024-2025', '2026-02-23 10:22:38'),
(4, 'Interrogation', '2ème trimestre', '2025-01-25', 'Interrogation - Les fractions', 1.0, 1, 1, '08:00:00', '09:00:00', 1, '2024-2025', '2026-02-23 10:22:38'),
(5, 'Devoir', '2ème trimestre', '2025-02-18', 'Devoir d\'anglais - Present simple', 1.0, 1, 2, '14:00:00', '15:30:00', 2, '2024-2025', '2026-02-23 10:22:38');

-- --------------------------------------------------------

--
-- Table structure for table `exemple_lecon`
--

DROP TABLE IF EXISTS `exemple_lecon`;
CREATE TABLE IF NOT EXISTS `exemple_lecon` (
  `id_exemple` int NOT NULL AUTO_INCREMENT,
  `id_lecon` int NOT NULL,
  `enonce` text COLLATE utf8mb4_unicode_ci,
  `solution` text COLLATE utf8mb4_unicode_ci,
  `ordre` int DEFAULT NULL,
  PRIMARY KEY (`id_exemple`),
  KEY `id_lecon` (`id_lecon`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `exercice`
--

DROP TABLE IF EXISTS `exercice`;
CREATE TABLE IF NOT EXISTS `exercice` (
  `id_exercice` int NOT NULL AUTO_INCREMENT,
  `id_lecon` int NOT NULL,
  `question` text COLLATE utf8mb4_unicode_ci,
  `type` enum('qcm','vrai_faux','reponse_libre') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `niveau` enum('facile','moyen','difficile') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `score` int DEFAULT '1',
  PRIMARY KEY (`id_exercice`),
  KEY `id_lecon` (`id_lecon`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `exercice`
--

INSERT INTO `exercice` (`id_exercice`, `id_lecon`, `question`, `type`, `niveau`, `score`) VALUES
(1, 1, 'Calculez 15 + 7', 'reponse_libre', 'facile', 2),
(2, 1, 'Quel est le résultat de 24 - 8 ?', 'reponse_libre', 'facile', 2),
(3, 2, 'Simplifiez la fraction 4/8', 'reponse_libre', 'moyen', 3),
(4, 3, 'Que vaut 7 x 6 ?', 'qcm', 'facile', 1),
(5, 4, 'Transformez en phrase interrogative : \"Il mange une pomme\"', 'reponse_libre', 'moyen', 3);

-- --------------------------------------------------------

--
-- Table structure for table `experience_eleve`
--

DROP TABLE IF EXISTS `experience_eleve`;
CREATE TABLE IF NOT EXISTS `experience_eleve` (
  `id_experience` int NOT NULL AUTO_INCREMENT,
  `id_utilisateur` int NOT NULL,
  `xp_total` int DEFAULT '0',
  `id_niveau` int DEFAULT NULL,
  PRIMARY KEY (`id_experience`),
  KEY `id_utilisateur` (`id_utilisateur`),
  KEY `id_niveau` (`id_niveau`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `frais_scolaire`
--

DROP TABLE IF EXISTS `frais_scolaire`;
CREATE TABLE IF NOT EXISTS `frais_scolaire` (
  `id_frais` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('inscription','scolarite','cantine','transport','materiel','autre') COLLATE utf8mb4_unicode_ci NOT NULL,
  `montant` decimal(10,2) NOT NULL,
  `frequence` enum('unique','mensuel','trimestriel','annuel') COLLATE utf8mb4_unicode_ci NOT NULL,
  `niveaux_applicables` json DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `obligatoire` tinyint(1) DEFAULT '1',
  `id_etablissement` int DEFAULT NULL,
  PRIMARY KEY (`id_frais`),
  KEY `id_etablissement` (`id_etablissement`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `frais_scolaire`
--

INSERT INTO `frais_scolaire` (`id_frais`, `nom`, `type`, `montant`, `frequence`, `niveaux_applicables`, `description`, `obligatoire`, `id_etablissement`) VALUES
(1, 'Frais d\'inscription', 'inscription', 150.00, 'unique', '[\"tous\"]', 'Frais annuels d\'inscription', 1, 1),
(2, 'Scolarité mensuelle', 'scolarite', 80.00, 'mensuel', '[\"tous\"]', 'Frais mensuels de scolarité', 1, 1),
(3, 'Frais de cantine', 'cantine', 30.00, 'mensuel', '[\"tous\"]', 'Repas à la cantine', 0, 1),
(4, 'Transport scolaire', 'transport', 25.00, 'mensuel', '[\"tous\"]', 'Service de transport', 0, 1),
(5, 'Frais de laboratoire', 'materiel', 15.00, 'trimestriel', '[\"4ème\", \"5ème\", \"6ème\"]', 'Utilisation des laboratoires', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `inscription`
--

DROP TABLE IF EXISTS `inscription`;
CREATE TABLE IF NOT EXISTS `inscription` (
  `id_inscription` int NOT NULL AUTO_INCREMENT,
  `id_eleve` int NOT NULL,
  `id_classe` int NOT NULL,
  `id_annee_scolaire` int NOT NULL,
  `date_inscription` date NOT NULL,
  `type` enum('nouveau','reinscription','transfert') COLLATE utf8mb4_unicode_ci NOT NULL,
  `statut` enum('en_attente','validee','rejetee') COLLATE utf8mb4_unicode_ci DEFAULT 'en_attente',
  `frais_inscription` decimal(10,2) DEFAULT NULL,
  `montant_paye` decimal(10,2) DEFAULT '0.00',
  `documents_fournis` json DEFAULT NULL,
  `remarques` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id_inscription`),
  KEY `id_eleve` (`id_eleve`),
  KEY `id_classe` (`id_classe`),
  KEY `id_annee_scolaire` (`id_annee_scolaire`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `inscription`
--

INSERT INTO `inscription` (`id_inscription`, `id_eleve`, `id_classe`, `id_annee_scolaire`, `date_inscription`, `type`, `statut`, `frais_inscription`, `montant_paye`, `documents_fournis`, `remarques`) VALUES
(1, 1, 1, 2, '2024-09-05', 'nouveau', 'validee', 150.00, 150.00, NULL, NULL),
(2, 2, 1, 2, '2024-09-05', 'reinscription', 'validee', 150.00, 150.00, NULL, NULL),
(3, 3, 2, 2, '2024-09-06', 'nouveau', 'validee', 150.00, 150.00, NULL, NULL),
(4, 4, 2, 2, '2024-09-06', 'nouveau', 'validee', 150.00, 100.00, NULL, NULL),
(5, 5, 3, 2, '2024-09-07', 'nouveau', 'en_attente', 150.00, 0.00, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `inspecteur`
--

DROP TABLE IF EXISTS `inspecteur`;
CREATE TABLE IF NOT EXISTS `inspecteur` (
  `id_inspecteur` int NOT NULL AUTO_INCREMENT,
  `id_utilisateur` int NOT NULL,
  `specialite` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `grade` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `zone_geographique` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `etablissements_assignes` json DEFAULT NULL,
  `date_nomination` date NOT NULL,
  `date_fin_mission` date DEFAULT NULL,
  `statut_mission` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT 'en_cours',
  PRIMARY KEY (`id_inspecteur`),
  KEY `id_utilisateur` (`id_utilisateur`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `inspecteur`
--

INSERT INTO `inspecteur` (`id_inspecteur`, `id_utilisateur`, `specialite`, `grade`, `zone_geographique`, `etablissements_assignes`, `date_nomination`, `date_fin_mission`, `statut_mission`) VALUES
(1, 5, 'Pédagogie générale', 'Inspecteur Principal', 'Kinshasa', '[1, 2]', '2024-01-15', NULL, 'en_cours');

-- --------------------------------------------------------

--
-- Table structure for table `inventaire`
--

DROP TABLE IF EXISTS `inventaire`;
CREATE TABLE IF NOT EXISTS `inventaire` (
  `id_inventaire` int NOT NULL AUTO_INCREMENT,
  `id_materiel` int NOT NULL,
  `date_inventaire` date NOT NULL,
  `quantite_theorique` int NOT NULL,
  `quantite_reelle` int NOT NULL,
  `difference` int DEFAULT NULL,
  `etat_materiel` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `observations` text COLLATE utf8mb4_unicode_ci,
  `id_responsable` int DEFAULT NULL,
  PRIMARY KEY (`id_inventaire`),
  KEY `id_materiel` (`id_materiel`),
  KEY `id_responsable` (`id_responsable`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `journal_connexion`
--

DROP TABLE IF EXISTS `journal_connexion`;
CREATE TABLE IF NOT EXISTS `journal_connexion` (
  `id` int NOT NULL AUTO_INCREMENT,
  `utilisateur_id` int DEFAULT NULL,
  `email` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_connexion` datetime DEFAULT CURRENT_TIMESTAMP,
  `id_adresse` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `succes` tinyint(1) DEFAULT NULL,
  `raison` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `utilisateur_id` (`utilisateur_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `journal_connexion`
--

INSERT INTO `journal_connexion` (`id`, `utilisateur_id`, `email`, `date_connexion`, `id_adresse`, `user_agent`, `succes`, `raison`) VALUES
(1, 1, 'admin@ecole.sn', '2026-02-23 10:22:38', '192.168.1.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/120.0.0.0', 1, NULL),
(2, 2, 'mamadou.diop@ecole.sn', '2026-02-23 10:22:38', '192.168.1.2', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/120.0.0.0', 1, NULL),
(3, 7, 'marie.ngoie@ecole.sn', '2026-02-23 10:22:38', '192.168.1.3', 'Mozilla/5.0 (iPhone; CPU iPhone OS 15_0) AppleWebKit/605.1.15', 1, NULL),
(4, NULL, 'inconnu@test.com', '2026-02-23 10:22:38', '192.168.1.100', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/120.0.0.0', 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `lecon`
--

DROP TABLE IF EXISTS `lecon`;
CREATE TABLE IF NOT EXISTS `lecon` (
  `id_lecon` int NOT NULL AUTO_INCREMENT,
  `id_cours` int NOT NULL,
  `titre` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `ordre` int DEFAULT NULL,
  `duree_estimee` int DEFAULT NULL,
  `statut` enum('brouillon','publie') COLLATE utf8mb4_unicode_ci DEFAULT 'brouillon',
  PRIMARY KEY (`id_lecon`),
  KEY `id_cours` (`id_cours`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lecon`
--

INSERT INTO `lecon` (`id_lecon`, `id_cours`, `titre`, `description`, `ordre`, `duree_estimee`, `statut`) VALUES
(1, 1, 'Les nombres naturels', 'Définition et propriétés des nombres naturels', 1, 30, 'publie'),
(2, 1, 'Addition et soustraction', 'Techniques d\'addition et soustraction', 2, 45, 'publie'),
(3, 1, 'Multiplication et division', 'Tables et techniques de multiplication et division', 3, 45, 'publie'),
(4, 2, 'Introduction aux fractions', 'Définition et représentation des fractions', 1, 40, 'publie'),
(5, 4, 'Les types de phrases', 'Phrases déclaratives, interrogatives et impératives', 1, 30, 'publie'),
(6, 5, 'Verbes du 1er groupe', 'Conjugaison des verbes en -er', 1, 40, 'publie');

-- --------------------------------------------------------

--
-- Table structure for table `livre`
--

DROP TABLE IF EXISTS `livre`;
CREATE TABLE IF NOT EXISTS `livre` (
  `id_livre` int NOT NULL AUTO_INCREMENT,
  `titre` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `auteur` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `isbn` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `editeur` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `annee_publication` year DEFAULT NULL,
  `genre` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `langue` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT 'Français',
  `niveau_scolaire` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `matiere` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nombre_exemplaires` int DEFAULT '1',
  `exemplaires_disponibles` int DEFAULT '1',
  `description` text COLLATE utf8mb4_unicode_ci,
  `date_ajout` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_livre`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `livre`
--

INSERT INTO `livre` (`id_livre`, `titre`, `auteur`, `isbn`, `editeur`, `annee_publication`, `genre`, `langue`, `niveau_scolaire`, `matiere`, `nombre_exemplaires`, `exemplaires_disponibles`, `description`, `date_ajout`) VALUES
(1, 'Mathématiques 6ème', 'Collection Diop', '978-2-01-123456-7', 'Hachette', '2023', 'Manuel scolaire', 'Français', '6ème', 'Mathématiques', 10, 6, 'Manuel de mathématiques pour la 6ème', '2026-02-23 10:22:38'),
(2, 'Français 6ème', 'Collection Mbala', '978-2-01-234567-8', 'Nathan', '2023', 'Manuel scolaire', 'Français', '6ème', 'Français', 8, 4, 'Manuel de français pour la 6ème', '2026-02-23 10:22:38'),
(3, 'Le Petit Prince', 'Saint-Exupéry', '978-2-07-040850-4', 'Gallimard', '1943', 'Roman', 'Français', 'Tous', 'Littérature', 5, 5, 'Conte philosophique', '2026-02-23 10:22:38'),
(4, 'Grammaire française', 'Grevisse', '978-2-8011-1625-0', 'De Boeck', '2020', 'Grammaire', 'Français', 'Secondaire', 'Français', 3, 3, 'Référence grammaticale', '2026-02-23 10:22:38');

-- --------------------------------------------------------

--
-- Table structure for table `materiel`
--

DROP TABLE IF EXISTS `materiel`;
CREATE TABLE IF NOT EXISTS `materiel` (
  `id_materiel` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('mobilier','informatique','scientifique','sportif','autre') COLLATE utf8mb4_unicode_ci NOT NULL,
  `reference` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `marque` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `modele` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_achat` date DEFAULT NULL,
  `prix_achat` decimal(10,2) DEFAULT NULL,
  `etat` enum('neuf','bon','moyen','mauvais','hors_service') COLLATE utf8mb4_unicode_ci DEFAULT 'bon',
  `localisation` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_salle` int DEFAULT NULL,
  `responsable` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_inventaire` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_materiel`),
  KEY `id_salle` (`id_salle`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `materiel`
--

INSERT INTO `materiel` (`id_materiel`, `nom`, `type`, `reference`, `marque`, `modele`, `date_achat`, `prix_achat`, `etat`, `localisation`, `id_salle`, `responsable`, `date_inventaire`) VALUES
(1, 'Tableau blanc', 'mobilier', 'TB-001', 'Staedtler', 'Grand format', '2023-08-15', 150.00, 'bon', 'Salle 101', 1, 'M. Tshibangu', '2026-02-23 10:22:38'),
(2, 'Projecteur', 'informatique', 'PJ-001', 'Epson', 'EB-X41', '2023-09-01', 450.00, 'neuf', 'Salle 101', 1, 'M. Tshibangu', '2026-02-23 10:22:38'),
(3, 'Microscope', 'scientifique', 'MS-001', 'Leica', 'DM500', '2023-07-20', 1200.00, 'bon', 'Labo Physique', 3, 'Mme. Mbala', '2026-02-23 10:22:38'),
(4, 'Ordinateur', 'informatique', 'PC-001', 'Dell', 'OptiPlex', '2023-08-10', 600.00, 'bon', 'Bibliothèque', 4, 'M. Mukendi', '2026-02-23 10:22:38');

-- --------------------------------------------------------

--
-- Table structure for table `matiere`
--

DROP TABLE IF EXISTS `matiere`;
CREATE TABLE IF NOT EXISTS `matiere` (
  `id_matiere` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `coefficient` int DEFAULT '1',
  `domaine` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `objectifs_generaux` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id_matiere`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `matiere`
--

INSERT INTO `matiere` (`id_matiere`, `nom`, `description`, `coefficient`, `domaine`, `objectifs_generaux`) VALUES
(1, 'Mathématiques', 'Algèbre, géométrie et analyse', 4, 'Scientifique', 'Développer le raisonnement logique et les capacités de calcul'),
(2, 'Français', 'Grammaire, littérature et expression écrite', 3, 'Littéraire', 'Maîtriser la langue française et développer l\'expression'),
(3, 'Anglais', 'Langue et communication', 2, 'Linguistique', 'Acquérir les bases de la communication en anglais'),
(4, 'Physique-Chimie', 'Sciences physiques et chimiques', 3, 'Scientifique', 'Comprendre les phénomènes physiques et chimiques'),
(5, 'Histoire-Géographie', 'Sciences humaines', 2, 'Littéraire', 'Connaître l\'histoire et comprendre l\'organisation du monde'),
(6, 'SVT', 'Sciences de la vie et de la Terre', 2, 'Scientifique', 'Découvrir le monde vivant et la géologie'),
(7, 'Comptabilité', 'Comptabilité générale et analytique', 3, 'Commercial', 'Maîtriser les principes comptables'),
(8, 'Informatique', 'Bases de l\'informatique et programmation', 2, 'Technique', 'Initier à l\'utilisation et à la programmation');

-- --------------------------------------------------------

--
-- Table structure for table `niveaux`
--

DROP TABLE IF EXISTS `niveaux`;
CREATE TABLE IF NOT EXISTS `niveaux` (
  `id_niveau` int NOT NULL AUTO_INCREMENT,
  `nom_niveau` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `xp_min` int NOT NULL,
  `xp_max` int NOT NULL,
  PRIMARY KEY (`id_niveau`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `niveaux`
--

INSERT INTO `niveaux` (`id_niveau`, `nom_niveau`, `xp_min`, `xp_max`) VALUES
(1, 'Débutant', 0, 100),
(2, 'Apprenti', 101, 300),
(3, 'Intermédiaire', 301, 600),
(4, 'Avancé', 601, 1000),
(5, 'Expert', 1001, 2000);

-- --------------------------------------------------------

--
-- Table structure for table `note`
--

DROP TABLE IF EXISTS `note`;
CREATE TABLE IF NOT EXISTS `note` (
  `id_note` int NOT NULL AUTO_INCREMENT,
  `id_eleve` int NOT NULL,
  `id_examen` int NOT NULL,
  `valeur` decimal(5,2) NOT NULL,
  `appreciation` text COLLATE utf8mb4_unicode_ci,
  `date_saisie` datetime DEFAULT CURRENT_TIMESTAMP,
  `id_enseignant` int DEFAULT NULL,
  PRIMARY KEY (`id_note`),
  KEY `id_eleve` (`id_eleve`),
  KEY `id_examen` (`id_examen`),
  KEY `id_enseignant` (`id_enseignant`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `note`
--

INSERT INTO `note` (`id_note`, `id_eleve`, `id_examen`, `valeur`, `appreciation`, `date_saisie`, `id_enseignant`) VALUES
(1, 1, 1, 15.50, 'Très bon travail', '2026-02-23 10:22:38', 1),
(2, 2, 1, 12.00, 'Bien, peut mieux faire', '2026-02-23 10:22:38', 1),
(3, 3, 1, 17.00, 'Excellent', '2026-02-23 10:22:38', 1),
(4, 1, 2, 14.00, 'Bon', '2026-02-23 10:22:38', 2),
(5, 2, 2, 10.50, 'Passable', '2026-02-23 10:22:38', 2),
(6, 3, 2, 16.50, 'Très bien', '2026-02-23 10:22:38', 2),
(7, 1, 3, 13.00, 'Bien', '2026-02-23 10:22:38', 1),
(8, 2, 3, 8.50, 'Insuffisant, doit travailler', '2026-02-23 10:22:38', 1),
(9, 3, 3, 18.00, 'Exceptionnel', '2026-02-23 10:22:38', 1),
(10, 1, 4, 14.50, 'Bien', '2026-02-23 10:22:38', 1),
(11, 2, 4, 11.00, 'Passable', '2026-02-23 10:22:38', 1),
(12, 3, 4, 16.00, 'Très bien', '2026-02-23 10:22:38', 1);

-- --------------------------------------------------------

--
-- Table structure for table `objectif_lecon`
--

DROP TABLE IF EXISTS `objectif_lecon`;
CREATE TABLE IF NOT EXISTS `objectif_lecon` (
  `id_objectif` int NOT NULL AUTO_INCREMENT,
  `id_lecon` int NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id_objectif`),
  KEY `id_lecon` (`id_lecon`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `option_etude`
--

DROP TABLE IF EXISTS `option_etude`;
CREATE TABLE IF NOT EXISTS `option_etude` (
  `id_option` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `niveaux` json DEFAULT NULL,
  `debouches` json DEFAULT NULL,
  `id_section` int DEFAULT NULL,
  PRIMARY KEY (`id_option`),
  KEY `id_section` (`id_section`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `option_etude`
--

INSERT INTO `option_etude` (`id_option`, `nom`, `code`, `description`, `niveaux`, `debouches`, `id_section`) VALUES
(1, 'Mathématiques-Physique', 'MP', 'Option axée sur les mathématiques et la physique', '[\"4ème\", \"5ème\", \"6ème\"]', '[\"Universités scientifiques\", \"Écoles d\'ingénieurs\"]', 1),
(2, 'Sciences de la Vie', 'SV', 'Option axée sur la biologie et les sciences de la terre', '[\"4ème\", \"5ème\", \"6ème\"]', '[\"Médecine\", \"Agronomie\", \"Environnement\"]', 1),
(3, 'Lettres-Philosophie', 'LP', 'Option littéraire et philosophique', '[\"4ème\", \"5ème\", \"6ème\"]', '[\"Lettres\", \"Droit\", \"Journalisme\"]', 2),
(4, 'Comptabilité-Gestion', 'CG', 'Option comptabilité et gestion', '[\"4ème\", \"5ème\", \"6ème\"]', '[\"Gestion\", \"Finance\", \"Comptabilité\"]', 3),
(5, 'Électrotechnique', 'ELT', 'Option électrotechnique et électronique', '[\"4ème\", \"5ème\", \"6ème\"]', '[\"Électricité\", \"Électronique\", \"Maintenance\"]', 4);

-- --------------------------------------------------------

--
-- Table structure for table `paiement`
--

DROP TABLE IF EXISTS `paiement`;
CREATE TABLE IF NOT EXISTS `paiement` (
  `id_paiement` int NOT NULL AUTO_INCREMENT,
  `id_eleve` int NOT NULL,
  `type_paiement` enum('scolarite','frais_scolaire','cantine','transport','autre') COLLATE utf8mb4_unicode_ci NOT NULL,
  `montant` decimal(10,2) NOT NULL,
  `montant_paye` decimal(10,2) DEFAULT '0.00',
  `date_paiement` date DEFAULT NULL,
  `mode_paiement` enum('especes','mobile_money','virement','cheque') COLLATE utf8mb4_unicode_ci NOT NULL,
  `reference_paiement` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `statut` enum('en_attente','partiel','complet') COLLATE utf8mb4_unicode_ci DEFAULT 'en_attente',
  `id_utilisateur` int DEFAULT NULL,
  `annee_scolaire` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id_paiement`),
  KEY `id_eleve` (`id_eleve`),
  KEY `id_utilisateur` (`id_utilisateur`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `paiement`
--

INSERT INTO `paiement` (`id_paiement`, `id_eleve`, `type_paiement`, `montant`, `montant_paye`, `date_paiement`, `mode_paiement`, `reference_paiement`, `statut`, `id_utilisateur`, `annee_scolaire`) VALUES
(1, 1, 'frais_scolaire', 150.00, 150.00, '2024-09-05', 'mobile_money', NULL, 'complet', NULL, '2024-2025'),
(2, 1, 'scolarite', 80.00, 80.00, '2024-09-10', 'mobile_money', NULL, 'complet', NULL, '2024-2025'),
(3, 2, 'frais_scolaire', 150.00, 150.00, '2024-09-05', 'especes', NULL, 'complet', NULL, '2024-2025'),
(4, 2, 'scolarite', 80.00, 40.00, '2024-09-15', 'especes', NULL, 'partiel', NULL, '2024-2025'),
(5, 3, 'frais_scolaire', 150.00, 100.00, '2024-09-06', 'mobile_money', NULL, 'partiel', NULL, '2024-2025');

-- --------------------------------------------------------

--
-- Table structure for table `permission_role`
--

DROP TABLE IF EXISTS `permission_role`;
CREATE TABLE IF NOT EXISTS `permission_role` (
  `id` int NOT NULL AUTO_INCREMENT,
  `role` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `permission_code` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permission_role`
--

INSERT INTO `permission_role` (`id`, `role`, `permission_code`, `description`, `created_at`) VALUES
(1, 'administrateur', 'all', 'Toutes les permissions', '2026-02-23 10:22:38'),
(2, 'enseignant', 'notes.manage', 'Gérer les notes', '2026-02-23 10:22:38'),
(3, 'enseignant', 'cours.view', 'Voir les cours', '2026-02-23 10:22:38'),
(4, 'eleve', 'notes.view', 'Voir ses notes', '2026-02-23 10:22:38'),
(5, 'eleve', 'cours.view', 'Voir les cours', '2026-02-23 10:22:38'),
(6, 'parent', 'notes.view.child', 'Voir les notes de ses enfants', '2026-02-23 10:22:38'),
(7, 'bibliothecaire', 'livres.manage', 'Gérer les livres', '2026-02-23 10:22:38'),
(8, 'comptable', 'paiements.manage', 'Gérer les paiements', '2026-02-23 10:22:38');

-- --------------------------------------------------------

--
-- Table structure for table `programme`
--

DROP TABLE IF EXISTS `programme`;
CREATE TABLE IF NOT EXISTS `programme` (
  `id_programme` int NOT NULL AUTO_INCREMENT,
  `nom_programme` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `niveau` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ministere_source` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `date_creation` datetime DEFAULT CURRENT_TIMESTAMP,
  `date_debut` date DEFAULT NULL,
  `date_fin` date DEFAULT NULL,
  `statut` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT 'Actif',
  `objectifs_programme` text COLLATE utf8mb4_unicode_ci,
  `competences_visees` text COLLATE utf8mb4_unicode_ci,
  `modalites_evaluation` text COLLATE utf8mb4_unicode_ci,
  `prerequis_programme` text COLLATE utf8mb4_unicode_ci,
  `duree_totale` int DEFAULT '0',
  PRIMARY KEY (`id_programme`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `programme`
--

INSERT INTO `programme` (`id_programme`, `nom_programme`, `niveau`, `ministere_source`, `description`, `date_creation`, `date_debut`, `date_fin`, `statut`, `objectifs_programme`, `competences_visees`, `modalites_evaluation`, `prerequis_programme`, `duree_totale`) VALUES
(1, 'Programme Mathématiques 6ème', '6ème', 'Ministère de l\'Éducation', 'Programme officiel de mathématiques pour la 6ème', '2026-02-23 10:22:38', '2024-09-01', '2025-06-30', 'Actif', 'Acquérir les bases mathématiques fondamentales', NULL, NULL, NULL, 120),
(2, 'Programme Français 6ème', '6ème', 'Ministère de l\'Éducation', 'Programme officiel de français pour la 6ème', '2026-02-23 10:22:38', '2024-09-01', '2025-06-30', 'Actif', 'Maîtriser les bases de la langue française', NULL, NULL, NULL, 90),
(3, 'Programme Anglais 6ème', '6ème', 'Ministère de l\'Éducation', 'Programme officiel d\'anglais pour la 6ème', '2026-02-23 10:22:38', '2024-09-01', '2025-06-30', 'Actif', 'Initiation à l\'anglais', NULL, NULL, NULL, 60);

-- --------------------------------------------------------

--
-- Table structure for table `progression`
--

DROP TABLE IF EXISTS `progression`;
CREATE TABLE IF NOT EXISTS `progression` (
  `id_progression` int NOT NULL AUTO_INCREMENT,
  `id_utilisateur` int NOT NULL,
  `id_cours` int NOT NULL,
  `pourcentage` decimal(5,2) DEFAULT NULL,
  `derniere_mise_a_jour` datetime DEFAULT NULL,
  PRIMARY KEY (`id_progression`),
  KEY `id_utilisateur` (`id_utilisateur`),
  KEY `id_cours` (`id_cours`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `progression`
--

INSERT INTO `progression` (`id_progression`, `id_utilisateur`, `id_cours`, `pourcentage`, `derniere_mise_a_jour`) VALUES
(1, 7, 1, 75.00, '2026-02-20 15:30:00'),
(2, 7, 2, 40.00, '2026-02-21 10:15:00'),
(3, 8, 1, 60.00, '2026-02-19 14:20:00'),
(4, 9, 1, 90.00, '2026-02-22 09:45:00');

-- --------------------------------------------------------

--
-- Table structure for table `proviseur`
--

DROP TABLE IF EXISTS `proviseur`;
CREATE TABLE IF NOT EXISTS `proviseur` (
  `id_proviseur` int NOT NULL AUTO_INCREMENT,
  `id_utilisateur` int NOT NULL,
  `etablissement` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `duree_mandat` int DEFAULT NULL,
  `bureau` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id_proviseur`),
  KEY `id_utilisateur` (`id_utilisateur`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `quiz`
--

DROP TABLE IF EXISTS `quiz`;
CREATE TABLE IF NOT EXISTS `quiz` (
  `id_quiz` int NOT NULL AUTO_INCREMENT,
  `id_lecon` int NOT NULL,
  `titre` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `score_min` int DEFAULT NULL,
  PRIMARY KEY (`id_quiz`),
  KEY `id_lecon` (`id_lecon`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `quiz`
--

INSERT INTO `quiz` (`id_quiz`, `id_lecon`, `titre`, `score_min`) VALUES
(1, 1, 'Quiz sur les nombres entiers', 5),
(2, 2, 'Quiz sur les fractions', 7);

-- --------------------------------------------------------

--
-- Table structure for table `rapports`
--

DROP TABLE IF EXISTS `rapports`;
CREATE TABLE IF NOT EXISTS `rapports` (
  `id_rapport` int NOT NULL AUTO_INCREMENT,
  `id_classe` int NOT NULL,
  `id_inspecteur` int NOT NULL,
  `contenu` text COLLATE utf8mb4_unicode_ci,
  `date_rapport` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_rapport`),
  KEY `id_classe` (`id_classe`),
  KEY `id_inspecteur` (`id_inspecteur`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reponse_exercice`
--

DROP TABLE IF EXISTS `reponse_exercice`;
CREATE TABLE IF NOT EXISTS `reponse_exercice` (
  `id_reponse` int NOT NULL AUTO_INCREMENT,
  `id_exercice` int NOT NULL,
  `texte` text COLLATE utf8mb4_unicode_ci,
  `correcte` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id_reponse`),
  KEY `id_exercice` (`id_exercice`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reponse_exercice`
--

INSERT INTO `reponse_exercice` (`id_reponse`, `id_exercice`, `texte`, `correcte`) VALUES
(1, 4, '42', 1),
(2, 4, '36', 0),
(3, 4, '48', 0),
(4, 4, '45', 0);

-- --------------------------------------------------------

--
-- Table structure for table `resultats`
--

DROP TABLE IF EXISTS `resultats`;
CREATE TABLE IF NOT EXISTS `resultats` (
  `id_resultat` int NOT NULL AUTO_INCREMENT,
  `id_utilisateur` int NOT NULL,
  `id_exercice` int NOT NULL,
  `score` int DEFAULT NULL,
  `date_passage` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_resultat`),
  KEY `id_utilisateur` (`id_utilisateur`),
  KEY `id_exercice` (`id_exercice`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `resultats`
--

INSERT INTO `resultats` (`id_resultat`, `id_utilisateur`, `id_exercice`, `score`, `date_passage`) VALUES
(1, 7, 1, 85, '2026-02-18 11:20:00'),
(2, 7, 2, 70, '2026-02-19 14:30:00'),
(3, 8, 1, 60, '2026-02-18 15:45:00'),
(4, 9, 1, 95, '2026-02-18 10:10:00');

-- --------------------------------------------------------

--
-- Table structure for table `resume_lecon`
--

DROP TABLE IF EXISTS `resume_lecon`;
CREATE TABLE IF NOT EXISTS `resume_lecon` (
  `id_resume` int NOT NULL AUTO_INCREMENT,
  `id_lecon` int NOT NULL,
  `contenu` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id_resume`),
  KEY `id_lecon` (`id_lecon`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `salle`
--

DROP TABLE IF EXISTS `salle`;
CREATE TABLE IF NOT EXISTS `salle` (
  `id_salle` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('classe','laboratoire','bibliotheque','salle_informatique','salle_sport','administration') COLLATE utf8mb4_unicode_ci NOT NULL,
  `capacite` int DEFAULT '30',
  `etage` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `batiment` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `equipements` json DEFAULT NULL,
  `etat` enum('excellent','bon','moyen','mauvais') COLLATE utf8mb4_unicode_ci DEFAULT 'bon',
  `id_etablissement` int DEFAULT NULL,
  PRIMARY KEY (`id_salle`),
  KEY `id_etablissement` (`id_etablissement`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `salle`
--

INSERT INTO `salle` (`id_salle`, `nom`, `type`, `capacite`, `etage`, `batiment`, `equipements`, `etat`, `id_etablissement`) VALUES
(1, 'Salle 101', 'classe', 35, '1er étage', 'Bâtiment A', '[\"Tableau blanc\", \"Projecteur\", \"Climatisation\"]', 'excellent', 1),
(2, 'Salle 102', 'classe', 35, '1er étage', 'Bâtiment A', '[\"Tableau blanc\", \"Projecteur\"]', 'bon', 1),
(3, 'Labo Physique', 'laboratoire', 25, '2ème étage', 'Bâtiment B', '[\"Équipements de physique\", \"Paillasses\"]', 'bon', 1),
(4, 'Bibliothèque', 'bibliotheque', 50, 'Rez-de-chaussée', 'Bâtiment C', '[\"Ordinateurs\", \"Tables de lecture\"]', 'excellent', 1),
(5, 'Salle Info 1', 'salle_informatique', 20, '2ème étage', 'Bâtiment B', '[\"20 ordinateurs\", \"Projecteur\"]', 'bon', 2);

-- --------------------------------------------------------

--
-- Table structure for table `section`
--

DROP TABLE IF EXISTS `section`;
CREATE TABLE IF NOT EXISTS `section` (
  `id_section` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `matieres_principales` json DEFAULT NULL,
  `niveaux` json DEFAULT NULL,
  PRIMARY KEY (`id_section`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `section`
--

INSERT INTO `section` (`id_section`, `nom`, `code`, `description`, `matieres_principales`, `niveaux`) VALUES
(1, 'Scientifique', 'SCI', 'Section scientifique avec mathématiques, physique, chimie et biologie', '[\"Mathématiques\", \"Physique\", \"Chimie\", \"Biologie\"]', '[\"1ère\", \"2ème\", \"3ème\", \"4ème\", \"5ème\", \"6ème\"]'),
(2, 'Littéraire', 'LIT', 'Section littéraire avec français, philosophie, histoire et géographie', '[\"Français\", \"Philosophie\", \"Histoire\", \"Géographie\"]', '[\"1ère\", \"2ème\", \"3ème\", \"4ème\", \"5ème\", \"6ème\"]'),
(3, 'Commerciale', 'COM', 'Section commerciale avec comptabilité, économie et gestion', '[\"Comptabilité\", \"Économie\", \"Gestion\"]', '[\"3ème\", \"4ème\", \"5ème\", \"6ème\"]'),
(4, 'Technique', 'TECH', 'Section technique avec électronique, mécanique et dessin technique', '[\"Électronique\", \"Mécanique\", \"Dessin Technique\"]', '[\"3ème\", \"4ème\", \"5ème\", \"6ème\"]');

-- --------------------------------------------------------

--
-- Table structure for table `tuteur`
--

DROP TABLE IF EXISTS `tuteur`;
CREATE TABLE IF NOT EXISTS `tuteur` (
  `id_tuteur` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telephone` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `profession` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `adresse` text COLLATE utf8mb4_unicode_ci,
  `lien_parental` enum('pere','mere','tuteur','autre') COLLATE utf8mb4_unicode_ci NOT NULL,
  `piece_identite` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_creation` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_tuteur`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tuteur`
--

INSERT INTO `tuteur` (`id_tuteur`, `nom`, `prenom`, `telephone`, `email`, `profession`, `adresse`, `lien_parental`, `piece_identite`, `date_creation`) VALUES
(1, 'Ilunga', 'David', '771234509', 'david.ilunga@ecole.sn', 'Ingénieur', 'Av. de l\'Université N°12, Lubumbashi', 'pere', NULL, '2026-02-23 10:22:38'),
(2, 'Kabasele', 'Marie', '771234510', 'marie.kabasele@ecole.sn', 'Enseignante', 'Av. du Marché N°45, Lubumbashi', 'mere', NULL, '2026-02-23 10:22:38'),
(3, 'Mukendi', 'Joseph', '771234511', 'joseph.mukendi@ecole.sn', 'Commerçant', 'Av. des Écoles N°78, Lubumbashi', 'tuteur', NULL, '2026-02-23 10:22:38'),
(4, 'Tshimanga', 'Alice', '771234512', 'alice.tshimanga@ecole.sn', 'Médecin', 'Av. de la Clinique N°23, Kinshasa', 'mere', NULL, '2026-02-23 10:22:38'),
(5, 'Ngoy', 'François', '771234513', 'francois.ngoy@ecole.sn', 'Comptable', 'Av. du Commerce N°56, Kinshasa', 'pere', NULL, '2026-02-23 10:22:38');

-- --------------------------------------------------------

--
-- Table structure for table `utilisateur`
--

DROP TABLE IF EXISTS `utilisateur`;
CREATE TABLE IF NOT EXISTS `utilisateur` (
  `id_utilisateur` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telephone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mot_de_passe` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('administrateur','proviseur','censeur','directeur_discipline','enseignant','eleve','parent','prefet','chef_classe','president_eleves','comite_parents','secretaire','bibliothecaire','comptable','surveillant') COLLATE utf8mb4_unicode_ci NOT NULL,
  `statut` enum('actif','inactif','suspendu') COLLATE utf8mb4_unicode_ci DEFAULT 'actif',
  `date_creation` datetime DEFAULT CURRENT_TIMESTAMP,
  `derniere_connexion` datetime DEFAULT NULL,
  `photo_profil` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `token_reset` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `token_expiration` datetime DEFAULT NULL,
  PRIMARY KEY (`id_utilisateur`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `utilisateur`
--

INSERT INTO `utilisateur` (`id_utilisateur`, `nom`, `prenom`, `email`, `telephone`, `mot_de_passe`, `role`, `statut`, `date_creation`, `derniere_connexion`, `photo_profil`, `token_reset`, `token_expiration`) VALUES
(1, 'Admin', 'System', 'admin@ecole.sn', '771234500', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'administrateur', 'actif', '2026-02-23 10:22:38', NULL, NULL, NULL, NULL),
(2, 'Diop', 'Mamadou', 'mamadou.diop@ecole.sn', '771234501', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'enseignant', 'actif', '2026-02-23 10:22:38', NULL, NULL, NULL, NULL),
(3, 'Mbala', 'Jeanne', 'jeanne.mbala@ecole.sn', '771234502', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'enseignant', 'actif', '2026-02-23 10:22:38', NULL, NULL, NULL, NULL),
(4, 'Kalenga', 'Marcel', 'marcel.kalenga@ecole.sn', '771234503', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'directeur_discipline', 'actif', '2026-02-23 10:22:38', NULL, NULL, NULL, NULL),
(5, 'Ndayikeza', 'Amos', 'amos.ndayikeza@ecole.sn', '771234504', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'censeur', 'actif', '2026-02-23 10:22:38', NULL, NULL, NULL, NULL),
(6, 'Tshibangu', 'Pierre', 'pierre.tshibangu@ecole.sn', '771234505', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'surveillant', 'actif', '2026-02-23 10:22:38', NULL, NULL, NULL, NULL),
(7, 'Ngoie', 'Marie', 'marie.ngoie@ecole.sn', '771234506', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'eleve', 'actif', '2026-02-23 10:22:38', NULL, NULL, NULL, NULL),
(8, 'Kalonji', 'Jean', 'jean.kalonji@ecole.sn', '771234507', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'eleve', 'actif', '2026-02-23 10:22:38', NULL, NULL, NULL, NULL),
(9, 'Mutombo', 'Sophie', 'sophie.mutombo@ecole.sn', '771234508', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'eleve', 'actif', '2026-02-23 10:22:38', NULL, NULL, NULL, NULL),
(10, 'Ilunga', 'David', 'david.ilunga@ecole.sn', '771234509', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'parent', 'actif', '2026-02-23 10:22:38', NULL, NULL, NULL, NULL),
(11, 'Kabasele', 'Marie', 'marie.kabasele@ecole.sn', '771234510', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'parent', 'actif', '2026-02-23 10:22:38', NULL, NULL, NULL, NULL),
(12, 'Mukendi', 'Joseph', 'joseph.mukendi@ecole.sn', '771234511', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'bibliothecaire', 'actif', '2026-02-23 10:22:38', NULL, NULL, NULL, NULL),
(13, 'Lubaki', 'Patricia', 'patricia.lubaki@ecole.sn', '771234512', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'comptable', 'actif', '2026-02-23 10:22:38', NULL, NULL, NULL, NULL);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activite`
--
ALTER TABLE `activite`
  ADD CONSTRAINT `activite_ibfk_1` FOREIGN KEY (`id_lecon`) REFERENCES `lecon` (`id_lecon`) ON DELETE CASCADE;

--
-- Constraints for table `activites`
--
ALTER TABLE `activites`
  ADD CONSTRAINT `activites_ibfk_1` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateur` (`id_utilisateur`) ON DELETE CASCADE;

--
-- Constraints for table `administrateurs`
--
ALTER TABLE `administrateurs`
  ADD CONSTRAINT `administrateurs_ibfk_1` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateur` (`id_utilisateur`) ON DELETE CASCADE;

--
-- Constraints for table `badges_obtenus`
--
ALTER TABLE `badges_obtenus`
  ADD CONSTRAINT `badges_obtenus_ibfk_1` FOREIGN KEY (`id_badge`) REFERENCES `badges` (`id_badge`) ON DELETE CASCADE,
  ADD CONSTRAINT `badges_obtenus_ibfk_2` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateur` (`id_utilisateur`) ON DELETE CASCADE;

--
-- Constraints for table `bulletin`
--
ALTER TABLE `bulletin`
  ADD CONSTRAINT `bulletin_ibfk_1` FOREIGN KEY (`id_eleve`) REFERENCES `eleve` (`id_eleve`) ON DELETE CASCADE,
  ADD CONSTRAINT `bulletin_ibfk_2` FOREIGN KEY (`id_classe`) REFERENCES `classe` (`id_classe`) ON DELETE CASCADE,
  ADD CONSTRAINT `bulletin_ibfk_3` FOREIGN KEY (`id_enseignant_principal`) REFERENCES `enseignant` (`id_enseignant`) ON DELETE SET NULL;

--
-- Constraints for table `classe`
--
ALTER TABLE `classe`
  ADD CONSTRAINT `classe_ibfk_1` FOREIGN KEY (`id_option`) REFERENCES `option_etude` (`id_option`) ON DELETE SET NULL,
  ADD CONSTRAINT `classe_ibfk_2` FOREIGN KEY (`id_section`) REFERENCES `section` (`id_section`) ON DELETE SET NULL,
  ADD CONSTRAINT `classe_ibfk_3` FOREIGN KEY (`id_etablissement`) REFERENCES `etablissement` (`id_etablissement`) ON DELETE CASCADE;

--
-- Constraints for table `competences`
--
ALTER TABLE `competences`
  ADD CONSTRAINT `competences_ibfk_1` FOREIGN KEY (`id_cours`) REFERENCES `cours` (`id_cours`) ON DELETE CASCADE;

--
-- Constraints for table `contenu_cours`
--
ALTER TABLE `contenu_cours`
  ADD CONSTRAINT `contenu_cours_ibfk_1` FOREIGN KEY (`id_cours`) REFERENCES `cours` (`id_cours`) ON DELETE CASCADE;

--
-- Constraints for table `contenu_lecon`
--
ALTER TABLE `contenu_lecon`
  ADD CONSTRAINT `contenu_lecon_ibfk_1` FOREIGN KEY (`id_lecon`) REFERENCES `lecon` (`id_lecon`) ON DELETE CASCADE;

--
-- Constraints for table `cours`
--
ALTER TABLE `cours`
  ADD CONSTRAINT `cours_ibfk_1` FOREIGN KEY (`id_matiere`) REFERENCES `matiere` (`id_matiere`) ON DELETE CASCADE,
  ADD CONSTRAINT `cours_ibfk_2` FOREIGN KEY (`id_programme`) REFERENCES `programme` (`id_programme`) ON DELETE CASCADE,
  ADD CONSTRAINT `cours_ibfk_3` FOREIGN KEY (`id_classe`) REFERENCES `classe` (`id_classe`) ON DELETE SET NULL;

--
-- Constraints for table `cours_enseignants`
--
ALTER TABLE `cours_enseignants`
  ADD CONSTRAINT `cours_enseignants_ibfk_1` FOREIGN KEY (`id_cours`) REFERENCES `cours` (`id_cours`) ON DELETE CASCADE,
  ADD CONSTRAINT `cours_enseignants_ibfk_2` FOREIGN KEY (`id_enseignant`) REFERENCES `enseignant` (`id_enseignant`) ON DELETE CASCADE;

--
-- Constraints for table `directeur_discipline`
--
ALTER TABLE `directeur_discipline`
  ADD CONSTRAINT `directeur_discipline_ibfk_1` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateur` (`id_utilisateur`) ON DELETE CASCADE;

--
-- Constraints for table `discipline`
--
ALTER TABLE `discipline`
  ADD CONSTRAINT `discipline_ibfk_1` FOREIGN KEY (`id_eleve`) REFERENCES `eleve` (`id_eleve`) ON DELETE CASCADE,
  ADD CONSTRAINT `discipline_ibfk_2` FOREIGN KEY (`id_personnel_rapport`) REFERENCES `utilisateur` (`id_utilisateur`) ON DELETE SET NULL,
  ADD CONSTRAINT `discipline_ibfk_3` FOREIGN KEY (`id_parent_informe`) REFERENCES `tuteur` (`id_tuteur`) ON DELETE SET NULL;

--
-- Constraints for table `eleve`
--
ALTER TABLE `eleve`
  ADD CONSTRAINT `eleve_ibfk_1` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateur` (`id_utilisateur`) ON DELETE SET NULL,
  ADD CONSTRAINT `eleve_ibfk_2` FOREIGN KEY (`id_classe_actuelle`) REFERENCES `classe` (`id_classe`) ON DELETE SET NULL,
  ADD CONSTRAINT `eleve_ibfk_3` FOREIGN KEY (`id_tuteur`) REFERENCES `tuteur` (`id_tuteur`) ON DELETE SET NULL;

--
-- Constraints for table `emprunt`
--
ALTER TABLE `emprunt`
  ADD CONSTRAINT `emprunt_ibfk_1` FOREIGN KEY (`id_livre`) REFERENCES `livre` (`id_livre`) ON DELETE CASCADE,
  ADD CONSTRAINT `emprunt_ibfk_2` FOREIGN KEY (`id_eleve`) REFERENCES `eleve` (`id_eleve`) ON DELETE SET NULL,
  ADD CONSTRAINT `emprunt_ibfk_3` FOREIGN KEY (`id_enseignant`) REFERENCES `enseignant` (`id_enseignant`) ON DELETE SET NULL;

--
-- Constraints for table `enseignant`
--
ALTER TABLE `enseignant`
  ADD CONSTRAINT `enseignant_ibfk_1` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateur` (`id_utilisateur`) ON DELETE SET NULL,
  ADD CONSTRAINT `enseignant_ibfk_2` FOREIGN KEY (`id_etablissement`) REFERENCES `etablissement` (`id_etablissement`) ON DELETE SET NULL;

--
-- Constraints for table `examen`
--
ALTER TABLE `examen`
  ADD CONSTRAINT `examen_ibfk_1` FOREIGN KEY (`id_classe`) REFERENCES `classe` (`id_classe`) ON DELETE CASCADE,
  ADD CONSTRAINT `examen_ibfk_2` FOREIGN KEY (`id_enseignant`) REFERENCES `enseignant` (`id_enseignant`) ON DELETE SET NULL,
  ADD CONSTRAINT `examen_ibfk_3` FOREIGN KEY (`id_salle`) REFERENCES `salle` (`id_salle`) ON DELETE SET NULL;

--
-- Constraints for table `exemple_lecon`
--
ALTER TABLE `exemple_lecon`
  ADD CONSTRAINT `exemple_lecon_ibfk_1` FOREIGN KEY (`id_lecon`) REFERENCES `lecon` (`id_lecon`) ON DELETE CASCADE;

--
-- Constraints for table `exercice`
--
ALTER TABLE `exercice`
  ADD CONSTRAINT `exercice_ibfk_1` FOREIGN KEY (`id_lecon`) REFERENCES `lecon` (`id_lecon`) ON DELETE CASCADE;

--
-- Constraints for table `experience_eleve`
--
ALTER TABLE `experience_eleve`
  ADD CONSTRAINT `experience_eleve_ibfk_1` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateur` (`id_utilisateur`) ON DELETE CASCADE,
  ADD CONSTRAINT `experience_eleve_ibfk_2` FOREIGN KEY (`id_niveau`) REFERENCES `niveaux` (`id_niveau`) ON DELETE SET NULL;

--
-- Constraints for table `frais_scolaire`
--
ALTER TABLE `frais_scolaire`
  ADD CONSTRAINT `frais_scolaire_ibfk_1` FOREIGN KEY (`id_etablissement`) REFERENCES `etablissement` (`id_etablissement`) ON DELETE CASCADE;

--
-- Constraints for table `inscription`
--
ALTER TABLE `inscription`
  ADD CONSTRAINT `inscription_ibfk_1` FOREIGN KEY (`id_eleve`) REFERENCES `eleve` (`id_eleve`) ON DELETE CASCADE,
  ADD CONSTRAINT `inscription_ibfk_2` FOREIGN KEY (`id_classe`) REFERENCES `classe` (`id_classe`) ON DELETE CASCADE,
  ADD CONSTRAINT `inscription_ibfk_3` FOREIGN KEY (`id_annee_scolaire`) REFERENCES `annee_scolaire` (`id_annee`) ON DELETE CASCADE;

--
-- Constraints for table `inspecteur`
--
ALTER TABLE `inspecteur`
  ADD CONSTRAINT `inspecteur_ibfk_1` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateur` (`id_utilisateur`) ON DELETE CASCADE;

--
-- Constraints for table `inventaire`
--
ALTER TABLE `inventaire`
  ADD CONSTRAINT `inventaire_ibfk_1` FOREIGN KEY (`id_materiel`) REFERENCES `materiel` (`id_materiel`) ON DELETE CASCADE,
  ADD CONSTRAINT `inventaire_ibfk_2` FOREIGN KEY (`id_responsable`) REFERENCES `utilisateur` (`id_utilisateur`) ON DELETE SET NULL;

--
-- Constraints for table `journal_connexion`
--
ALTER TABLE `journal_connexion`
  ADD CONSTRAINT `journal_connexion_ibfk_1` FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateur` (`id_utilisateur`) ON DELETE SET NULL;

--
-- Constraints for table `lecon`
--
ALTER TABLE `lecon`
  ADD CONSTRAINT `lecon_ibfk_1` FOREIGN KEY (`id_cours`) REFERENCES `cours` (`id_cours`) ON DELETE CASCADE;

--
-- Constraints for table `materiel`
--
ALTER TABLE `materiel`
  ADD CONSTRAINT `materiel_ibfk_1` FOREIGN KEY (`id_salle`) REFERENCES `salle` (`id_salle`) ON DELETE SET NULL;

--
-- Constraints for table `note`
--
ALTER TABLE `note`
  ADD CONSTRAINT `note_ibfk_1` FOREIGN KEY (`id_eleve`) REFERENCES `eleve` (`id_eleve`) ON DELETE CASCADE,
  ADD CONSTRAINT `note_ibfk_2` FOREIGN KEY (`id_examen`) REFERENCES `examen` (`id_examen`) ON DELETE CASCADE,
  ADD CONSTRAINT `note_ibfk_3` FOREIGN KEY (`id_enseignant`) REFERENCES `enseignant` (`id_enseignant`) ON DELETE SET NULL;

--
-- Constraints for table `objectif_lecon`
--
ALTER TABLE `objectif_lecon`
  ADD CONSTRAINT `objectif_lecon_ibfk_1` FOREIGN KEY (`id_lecon`) REFERENCES `lecon` (`id_lecon`) ON DELETE CASCADE;

--
-- Constraints for table `option_etude`
--
ALTER TABLE `option_etude`
  ADD CONSTRAINT `option_etude_ibfk_1` FOREIGN KEY (`id_section`) REFERENCES `section` (`id_section`) ON DELETE SET NULL;

--
-- Constraints for table `paiement`
--
ALTER TABLE `paiement`
  ADD CONSTRAINT `paiement_ibfk_1` FOREIGN KEY (`id_eleve`) REFERENCES `eleve` (`id_eleve`) ON DELETE CASCADE,
  ADD CONSTRAINT `paiement_ibfk_2` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateur` (`id_utilisateur`) ON DELETE SET NULL;

--
-- Constraints for table `progression`
--
ALTER TABLE `progression`
  ADD CONSTRAINT `progression_ibfk_1` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateur` (`id_utilisateur`) ON DELETE CASCADE,
  ADD CONSTRAINT `progression_ibfk_2` FOREIGN KEY (`id_cours`) REFERENCES `cours` (`id_cours`) ON DELETE CASCADE;

--
-- Constraints for table `proviseur`
--
ALTER TABLE `proviseur`
  ADD CONSTRAINT `proviseur_ibfk_1` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateur` (`id_utilisateur`) ON DELETE CASCADE;

--
-- Constraints for table `quiz`
--
ALTER TABLE `quiz`
  ADD CONSTRAINT `quiz_ibfk_1` FOREIGN KEY (`id_lecon`) REFERENCES `lecon` (`id_lecon`) ON DELETE CASCADE;

--
-- Constraints for table `rapports`
--
ALTER TABLE `rapports`
  ADD CONSTRAINT `rapports_ibfk_1` FOREIGN KEY (`id_classe`) REFERENCES `classe` (`id_classe`) ON DELETE CASCADE,
  ADD CONSTRAINT `rapports_ibfk_2` FOREIGN KEY (`id_inspecteur`) REFERENCES `inspecteur` (`id_inspecteur`) ON DELETE CASCADE;

--
-- Constraints for table `reponse_exercice`
--
ALTER TABLE `reponse_exercice`
  ADD CONSTRAINT `reponse_exercice_ibfk_1` FOREIGN KEY (`id_exercice`) REFERENCES `exercice` (`id_exercice`) ON DELETE CASCADE;

--
-- Constraints for table `resultats`
--
ALTER TABLE `resultats`
  ADD CONSTRAINT `resultats_ibfk_1` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateur` (`id_utilisateur`) ON DELETE CASCADE,
  ADD CONSTRAINT `resultats_ibfk_2` FOREIGN KEY (`id_exercice`) REFERENCES `exercice` (`id_exercice`) ON DELETE CASCADE;

--
-- Constraints for table `resume_lecon`
--
ALTER TABLE `resume_lecon`
  ADD CONSTRAINT `resume_lecon_ibfk_1` FOREIGN KEY (`id_lecon`) REFERENCES `lecon` (`id_lecon`) ON DELETE CASCADE;

--
-- Constraints for table `salle`
--
ALTER TABLE `salle`
  ADD CONSTRAINT `salle_ibfk_1` FOREIGN KEY (`id_etablissement`) REFERENCES `etablissement` (`id_etablissement`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
