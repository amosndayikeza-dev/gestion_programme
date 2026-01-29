-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jan 07, 2026 at 03:46 PM
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

-- --------------------------------------------------------

--
-- Table structure for table `activite`
--

DROP TABLE IF EXISTS `activite`;
CREATE TABLE IF NOT EXISTS `activite` (
  `id_activite` int NOT NULL AUTO_INCREMENT,
  `id_lecon` int NOT NULL,
  `type` enum('glisser_deposer','qcm','association','completer') DEFAULT NULL,
  `instruction` text,
  PRIMARY KEY (`id_activite`),
  KEY `id_lecon` (`id_lecon`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `activites`
--

DROP TABLE IF EXISTS `activites`;
CREATE TABLE IF NOT EXISTS `activites` (
  `id_activite` int NOT NULL AUTO_INCREMENT,
  `id_utilisateur` int NOT NULL,
  `nom_utilisateur` varchar(200) NOT NULL,
  `action` varchar(100) NOT NULL,
  `details` text,
  `date_activite` datetime NOT NULL,
  `statut` varchar(50) DEFAULT 'Succès',
  PRIMARY KEY (`id_activite`),
  KEY `id_utilisateur` (`id_utilisateur`)
) ENGINE=MyISAM AUTO_INCREMENT=169 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


DROP TABLE IF EXISTS `badges`;
CREATE TABLE IF NOT EXISTS `badges` (
  `id_badge` int NOT NULL AUTO_INCREMENT,
  `nom_badge` varchar(100) NOT NULL,
  `condition_obtention` text,
  PRIMARY KEY (`id_badge`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

DROP TABLE IF EXISTS `classes`;
CREATE TABLE IF NOT EXISTS `classes` (
  `id_classe` int NOT NULL AUTO_INCREMENT,
  `nom_classe` varchar(50) NOT NULL,
  `niveau` varchar(50) NOT NULL,
  `id_etablissement` int NOT NULL,
  `effectif_maximum` int DEFAULT NULL COMMENT 'Effectif maximum de la classe',
  `effectif_actuel` int DEFAULT '0' COMMENT 'Effectif actuel de la classe',
  `salle` varchar(50) DEFAULT NULL COMMENT 'Numéro ou nom de la salle',
  `annee_scolaire` varchar(20) DEFAULT NULL COMMENT 'Année scolaire (ex: 2024-2025)',
  `description` text COMMENT 'Description détaillée de la classe',
  PRIMARY KEY (`id_classe`),
  KEY `id_etablissement` (`id_etablissement`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `classes`
--

INSERT INTO `classes` (`id_classe`, `nom_classe`, `niveau`, `id_etablissement`, `effectif_maximum`, `effectif_actuel`, `salle`, `annee_scolaire`, `description`) VALUES
(1, '6ème A', '6ème', 1, 30, 28, 'Salle 4', '2024-2025', 'Classe standard'),
(3, 'CM2', 'CM2', 2, 30, 0, 'Non assignée', '2024-2025', 'Classe standard'),
(4, 'CP', 'CP', 3, 30, 28, 'Salle 3', '2024-2025', 'Classe standard'),
(5, '3e EQ', '3ème', 2, 60, 58, 'laboratoire', '2024-2025', 'l\'apprentissage c\'est un ordre de mission');

-- --------------------------------------------------------

--
-- Table structure for table `competences`
--

DROP TABLE IF EXISTS `competences`;
CREATE TABLE IF NOT EXISTS `competences` (
  `id_competence` int NOT NULL AUTO_INCREMENT,
  `nom_competence` varchar(100) NOT NULL,
  `description` text,
  `niveau_difficulte` int DEFAULT NULL,
  `id_cours` int NOT NULL,
  PRIMARY KEY (`id_competence`),
  KEY `id_cours` (`id_cours`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contenu_lecon`
--

DROP TABLE IF EXISTS `contenu_lecon`;
CREATE TABLE IF NOT EXISTS `contenu_lecon` (
  `id_contenu` int NOT NULL AUTO_INCREMENT,
  `id_lecon` int NOT NULL,
  `type` enum('texte','video','audio','image') DEFAULT NULL,
  `contenu` text,
  `ordre` int DEFAULT NULL,
  PRIMARY KEY (`id_contenu`),
  KEY `id_lecon` (`id_lecon`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cours`
--

DROP TABLE IF EXISTS `cours`;
CREATE TABLE IF NOT EXISTS `cours` (
  `id_cours` int NOT NULL AUTO_INCREMENT,
  `titre` varchar(150) NOT NULL,
  `description` text,
  `ordre_progression` int DEFAULT NULL,
  `id_matiere` int NOT NULL,
  `id_programme` int NOT NULL,
  `id_classe` int DEFAULT NULL,
  `niveau_difficulte` varchar(20) DEFAULT 'Intermédiaire',
  `duree_estimee` int DEFAULT '60',
  `date_creation` datetime DEFAULT CURRENT_TIMESTAMP,
  `date_modification` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `statut` varchar(20) DEFAULT 'Actif',
  `type_cours` varchar(30) DEFAULT 'Mixte',
  `objectifs_apprentissage` text,
  `prerequis` text,
  `ressources_externes` text,
  `nb_vues` int DEFAULT '0',
  `taux_reussite` decimal(5,2) DEFAULT '0.00',
  `seuil_reussite` decimal(5,2) DEFAULT '50.00',
  `createur_id` int DEFAULT NULL,
  `visible` tinyint(1) DEFAULT '1',
  `tags` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_cours`),
  KEY `id_matiere` (`id_matiere`),
  KEY `id_programme` (`id_programme`),
  KEY `fk_cours_classe` (`id_classe`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cours`
--

INSERT INTO `cours` (`id_cours`, `titre`, `description`, `ordre_progression`, `id_matiere`, `id_programme`, `id_classe`, `niveau_difficulte`, `duree_estimee`, `date_creation`, `date_modification`, `statut`, `type_cours`, `objectifs_apprentissage`, `prerequis`, `ressources_externes`, `nb_vues`, `taux_reussite`, `seuil_reussite`, `createur_id`, `visible`, `tags`) VALUES
(1, 'Mathematique', 'sceince de recherche', 9, 5, 3, 1, 'Débutant', 60, '2025-12-29 17:55:17', '2025-12-31 12:42:44', 'Actif', 'Théorique', 'etre capable', 'arithmetique', 'books.com', 0, 0.00, 50.00, NULL, 1, 'mathematique examen');

-- --------------------------------------------------------

--
-- Table structure for table `etablissements`
--

DROP TABLE IF EXISTS `etablissements`;
CREATE TABLE IF NOT EXISTS `etablissements` (
  `id_etablissement` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(150) NOT NULL,
  `type` enum('primaire','secondaire','universitaire') NOT NULL,
  `localisation` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id_etablissement`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `etablissements`
--

INSERT INTO `etablissements` (`id_etablissement`, `nom`, `type`, `localisation`) VALUES
(1, 'College Bukongo', 'secondaire', 'Av. Kabongo'),
(2, 'Collège Al Khawarizmi', 'secondaire', 'Av. du Lac commune du lac'),
(3, 'École Primaire Bethesaida', 'primaire', 'Av. Maendeleo'),
(4, 'College Mwangaza', 'secondaire', 'Commune de la lukuga, Q. Kahite');

-- --------------------------------------------------------

--
-- Table structure for table `exemple_lecon`
--

DROP TABLE IF EXISTS `exemple_lecon`;
CREATE TABLE IF NOT EXISTS `exemple_lecon` (
  `id_exemple` int NOT NULL AUTO_INCREMENT,
  `id_lecon` int NOT NULL,
  `enonce` text,
  `solution` text,
  `ordre` int DEFAULT NULL,
  PRIMARY KEY (`id_exemple`),
  KEY `id_lecon` (`id_lecon`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `exercice`
--

DROP TABLE IF EXISTS `exercice`;
CREATE TABLE IF NOT EXISTS `exercice` (
  `id_exercice` int NOT NULL AUTO_INCREMENT,
  `id_lecon` int NOT NULL,
  `question` text,
  `type` enum('qcm','vrai_faux','reponse_libre') DEFAULT NULL,
  `niveau` enum('facile','moyen','difficile') DEFAULT NULL,
  `score` int DEFAULT '1',
  PRIMARY KEY (`id_exercice`),
  KEY `id_lecon` (`id_lecon`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `exercices`
--

DROP TABLE IF EXISTS `exercices`;
CREATE TABLE IF NOT EXISTS `exercices` (
  `id_exercice` int NOT NULL AUTO_INCREMENT,
  `question` text NOT NULL,
  `type` enum('qcm','texte','calcul') NOT NULL,
  `difficulte` int DEFAULT NULL,
  `id_competence` int NOT NULL,
  PRIMARY KEY (`id_exercice`),
  KEY `id_competence` (`id_competence`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  UNIQUE KEY `id_utilisateur` (`id_utilisateur`),
  KEY `id_niveau` (`id_niveau`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inscriptions`
--

DROP TABLE IF EXISTS `inscriptions`;
CREATE TABLE IF NOT EXISTS `inscriptions` (
  `id_inscription` int NOT NULL AUTO_INCREMENT,
  `id_utilisateur` int NOT NULL,
  `id_classe` int NOT NULL,
  `annee_scolaire` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id_inscription`),
  KEY `id_utilisateur` (`id_utilisateur`),
  KEY `id_classe` (`id_classe`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inscriptions`
--

INSERT INTO `inscriptions` (`id_inscription`, `id_utilisateur`, `id_classe`, `annee_scolaire`) VALUES
(1, 2, 1, '2024-2025');

-- --------------------------------------------------------

--
-- Table structure for table `lecon`
--

DROP TABLE IF EXISTS `lecon`;
CREATE TABLE IF NOT EXISTS `lecon` (
  `id_lecon` int NOT NULL AUTO_INCREMENT,
  `id_cours` int NOT NULL,
  `titre` varchar(150) DEFAULT NULL,
  `description` text,
  `ordre` int DEFAULT NULL,
  `duree_estimee` int DEFAULT NULL,
  `statut` enum('brouillon','publie') DEFAULT 'brouillon',
  PRIMARY KEY (`id_lecon`),
  KEY `id_cours` (`id_cours`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `matiere`
--

DROP TABLE IF EXISTS `matiere`;
CREATE TABLE IF NOT EXISTS `matiere` (
  `id_matiere` int NOT NULL AUTO_INCREMENT,
  `nom_matiere` varchar(100) DEFAULT NULL,
  `coefficient` varchar(100) DEFAULT NULL,
  `description` text,
  PRIMARY KEY (`id_matiere`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `matieres`
--

DROP TABLE IF EXISTS `matieres`;
CREATE TABLE IF NOT EXISTS `matieres` (
  `id_matiere` int NOT NULL AUTO_INCREMENT,
  `nom_matiere` varchar(100) NOT NULL,
  `coefficient` int DEFAULT '1',
  `description` text,
  `couleur` varchar(7) DEFAULT '#3498db',
  `icone` varchar(50) DEFAULT 'book',
  `date_creation` datetime DEFAULT CURRENT_TIMESTAMP,
  `statut` varchar(20) DEFAULT 'Actif',
  `domaine` varchar(50) DEFAULT NULL,
  `niveau_min` varchar(20) DEFAULT NULL,
  `niveau_max` varchar(20) DEFAULT NULL,
  `objectifs_generaux` text,
  `nb_heures_total` int DEFAULT '0',
  `nb_cours_total` int DEFAULT '0',
  PRIMARY KEY (`id_matiere`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `matieres`
--

INSERT INTO `matieres` (`id_matiere`, `nom_matiere`, `coefficient`, `description`, `couleur`, `icone`, `date_creation`, `statut`, `domaine`, `niveau_min`, `niveau_max`, `objectifs_generaux`, `nb_heures_total`, `nb_cours_total`) VALUES
(2, 'Français', 3, 'Langue et littérature française', '#E74C3C', 'book', '2025-12-29 18:44:02', 'Actif', 'Langues', 'CP', 'CE2', 'metrise de tout', 15, 0),
(5, 'Anglais', 2, 'Langue anglaise', '#3498DB', 'language', '2025-12-29 18:44:02', 'Actif', 'Sciences Humaines', 'CE2', '6ème', 'permettre a tous de bien', 7, 5);

-- --------------------------------------------------------

--
-- Table structure for table `niveaux`
--

DROP TABLE IF EXISTS `niveaux`;
CREATE TABLE IF NOT EXISTS `niveaux` (
  `id_niveau` int NOT NULL AUTO_INCREMENT,
  `nom_niveau` varchar(50) NOT NULL,
  `xp_min` int NOT NULL,
  `xp_max` int NOT NULL,
  PRIMARY KEY (`id_niveau`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `objectif_lecon`
--

DROP TABLE IF EXISTS `objectif_lecon`;
CREATE TABLE IF NOT EXISTS `objectif_lecon` (
  `id_objectif` int NOT NULL AUTO_INCREMENT,
  `id_lecon` int NOT NULL,
  `description` text,
  PRIMARY KEY (`id_objectif`),
  KEY `id_lecon` (`id_lecon`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `programme`
--

DROP TABLE IF EXISTS `programme`;
CREATE TABLE IF NOT EXISTS `programme` (
  `id_programme` int NOT NULL AUTO_INCREMENT,
  `id_matiere` int NOT NULL,
  `titre` varchar(150) DEFAULT NULL,
  `description` text,
  PRIMARY KEY (`id_programme`),
  KEY `id_matiere` (`id_matiere`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `programmes`
--

DROP TABLE IF EXISTS `programmes`;
CREATE TABLE IF NOT EXISTS `programmes` (
  `id_programme` int NOT NULL AUTO_INCREMENT,
  `nom_programme` varchar(150) NOT NULL,
  `niveau` varchar(50) NOT NULL,
  `ministere_source` varchar(150) DEFAULT NULL,
  `description` text,
  `date_creation` datetime DEFAULT CURRENT_TIMESTAMP,
  `date_debut` date DEFAULT NULL,
  `date_fin` date DEFAULT NULL,
  `statut` varchar(20) DEFAULT 'Actif',
  `objectifs_programme` text,
  `competences_visees` text,
  `modalites_evaluation` text,
  `prerequis_programme` text,
  `duree_totale` int DEFAULT '0',
  `nb_matiere` int DEFAULT '0',
  `nb_cours_total` int DEFAULT '0',
  `createur_id` int DEFAULT NULL,
  `version` varchar(20) DEFAULT '1.0',
  PRIMARY KEY (`id_programme`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `programmes`
--

INSERT INTO `programmes` (`id_programme`, `nom_programme`, `niveau`, `ministere_source`, `description`, `date_creation`, `date_debut`, `date_fin`, `statut`, `objectifs_programme`, `competences_visees`, `modalites_evaluation`, `prerequis_programme`, `duree_totale`, `nb_matiere`, `nb_cours_total`, `createur_id`, `version`) VALUES
(1, 'Programme National', 'Secondaire', 'Éducation Nationale', 'Programme officiel de l\'éducation nationale', '2025-12-29 18:44:02', '2024-09-01', '2025-06-30', 'Actif', 'Développer les compétences fondamentales', 'Compétences du socle commun', 'Examens écrits et pratiques', 'Aucun', 900, 8, 40, NULL, '1.0'),
(2, 'Programme International', 'Lycée', 'International Baccalaureate', 'Programme international basé sur les standards IB', '2025-12-29 18:44:02', '2024-09-01', '2025-06-30', 'Actif', 'Préparer aux études supérieures', 'Compétences internationales', 'Évaluations continues', 'Niveau B1 en anglais', 1200, 12, 60, NULL, '1.0'),
(3, 'Programme Technique', 'Professionnel', 'Ministère du Travail', 'Formation professionnelle et technique', '2025-12-29 18:44:02', '2024-09-01', '2025-06-30', 'Actif', 'Acquérir des compétences pratiques', 'Compétences professionnelles', 'Évaluations en entreprise', 'Diplôme de fin d\'études', 600, 10, 50, NULL, '1.0');

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `quiz`
--

DROP TABLE IF EXISTS `quiz`;
CREATE TABLE IF NOT EXISTS `quiz` (
  `id_quiz` int NOT NULL AUTO_INCREMENT,
  `id_lecon` int NOT NULL,
  `titre` varchar(100) DEFAULT NULL,
  `score_min` int DEFAULT NULL,
  PRIMARY KEY (`id_quiz`),
  KEY `id_lecon` (`id_lecon`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rapports`
--

DROP TABLE IF EXISTS `rapports`;
CREATE TABLE IF NOT EXISTS `rapports` (
  `id_rapport` int NOT NULL AUTO_INCREMENT,
  `id_classe` int NOT NULL,
  `id_inspecteur` int NOT NULL,
  `contenu` text,
  `date_rapport` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_rapport`),
  KEY `id_classe` (`id_classe`),
  KEY `id_inspecteur` (`id_inspecteur`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reponse_exercice`
--

DROP TABLE IF EXISTS `reponse_exercice`;
CREATE TABLE IF NOT EXISTS `reponse_exercice` (
  `id_reponse` int NOT NULL AUTO_INCREMENT,
  `id_exercice` int NOT NULL,
  `texte` text,
  `correcte` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id_reponse`),
  KEY `id_exercice` (`id_exercice`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `resume_lecon`
--

DROP TABLE IF EXISTS `resume_lecon`;
CREATE TABLE IF NOT EXISTS `resume_lecon` (
  `id_resume` int NOT NULL AUTO_INCREMENT,
  `id_lecon` int NOT NULL,
  `contenu` text,
  PRIMARY KEY (`id_resume`),
  KEY `id_lecon` (`id_lecon`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `utilisateurs`
--

DROP TABLE IF EXISTS `utilisateurs`;
CREATE TABLE IF NOT EXISTS `utilisateurs` (
  `id_utilisateur` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  `role` enum('eleve','enseignant','inspecteur','administrateur') NOT NULL,
  `date_creation` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_utilisateur`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id_utilisateur`, `nom`, `prenom`, `email`, `mot_de_passe`, `role`, `date_creation`) VALUES
(1, 'Admin', 'System', 'admin@ecole.com', '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918', 'administrateur', '2025-12-28 10:29:13'),
(2, 'Dupont', 'Jean', 'jean.dupont@ecole.com', '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918', 'eleve', '2025-12-28 10:29:13'),
(3, 'Kalenga', 'Marc', 'kalenga@biu.bi', 'ef797c8118f02dfb649607dd5d3f8c7623048c9c063d532cc95c5ed7a898a64f', 'administrateur', '2025-12-29 14:39:30');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
