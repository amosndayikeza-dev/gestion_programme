-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : dim. 22 fév. 2026 à 16:47
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `gestion_programmes`
--

DELIMITER $$
--
-- Procédures
--
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
    
    -- Créer l'inscription dans la table inscription
    INSERT INTO inscription (id_eleve, id_classe, id_annee_scolaire, date_inscription, type, statut)
    VALUES (v_id_eleve, p_id_classe, p_id_annee, CURDATE(), 'nouveau', 'validee');
    
    -- Retourner le matricule et l'ID
    SELECT v_matricule AS matricule, v_id_eleve AS id_eleve;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `activite`
--

CREATE TABLE `activite` (
  `id_activite` int(11) NOT NULL,
  `id_lecon` int(11) NOT NULL,
  `type` enum('glisser_deposer','qcm','association','completer') DEFAULT NULL,
  `instruction` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `activites`
--

CREATE TABLE `activites` (
  `id_activite` int(11) NOT NULL,
  `id_utilisateur` int(11) NOT NULL,
  `nom_utilisateur` varchar(200) NOT NULL,
  `action` varchar(100) NOT NULL,
  `details` text DEFAULT NULL,
  `date_activite` datetime NOT NULL,
  `statut` varchar(50) DEFAULT 'Succès'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `administrateurs`
--

CREATE TABLE `administrateurs` (
  `id_administrateur` int(11) NOT NULL,
  `niveau_acces` varchar(50) NOT NULL,
  `departement` varchar(100) DEFAULT NULL,
  `date_prise_fonction` date NOT NULL,
  `date_fin_fonction` date DEFAULT NULL,
  `permissions_speciales` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`permissions_speciales`)),
  `dernier_audit` datetime DEFAULT NULL,
  `adresse_ip_autorisees` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`adresse_ip_autorisees`)),
  `authentification_2facteurs` tinyint(1) DEFAULT 0,
  `cle_2fa` varchar(255) DEFAULT NULL,
  `niveau_audit` varchar(50) DEFAULT NULL,
  `zone_intervention` varchar(100) DEFAULT NULL,
  `superviseur` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `annee_scolaire`
--

CREATE TABLE `annee_scolaire` (
  `id_annee` int(11) NOT NULL,
  `libelle` varchar(20) NOT NULL,
  `date_debut` date NOT NULL,
  `date_fin` date NOT NULL,
  `actif` tinyint(1) DEFAULT 0,
  `date_creation` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `annee_scolaire`
--

INSERT INTO `annee_scolaire` (`id_annee`, `libelle`, `date_debut`, `date_fin`, `actif`, `date_creation`) VALUES
(1, '2024-2025', '2024-09-01', '2025-07-31', 1, '2026-02-04 12:07:39');

-- --------------------------------------------------------

--
-- Structure de la table `badges`
--

CREATE TABLE `badges` (
  `id_badge` int(11) NOT NULL,
  `nom_badge` varchar(100) NOT NULL,
  `condition_obtention` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `badges_obtenus`
--

CREATE TABLE `badges_obtenus` (
  `id` int(11) NOT NULL,
  `id_badge` int(11) NOT NULL,
  `id_utilisateur` int(11) NOT NULL,
  `date_obtention` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `bulletin`
--

CREATE TABLE `bulletin` (
  `id_bulletin` int(11) NOT NULL,
  `id_eleve` int(11) NOT NULL,
  `id_classe` int(11) NOT NULL,
  `trimestre` enum('1er','2ème','3ème') NOT NULL,
  `annee_scolaire` varchar(20) NOT NULL,
  `moyenne_generale` decimal(5,2) DEFAULT NULL,
  `rang` int(11) DEFAULT NULL,
  `total_effectif` int(11) DEFAULT NULL,
  `appreciation_generale` text DEFAULT NULL,
  `date_emission` date DEFAULT NULL,
  `id_enseignant_principal` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `classe`
--

CREATE TABLE `classe` (
  `id_classe` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `niveau` varchar(20) NOT NULL,
  `cycle` enum('primaire','secondaire','superieur') NOT NULL,
  `id_option` int(11) DEFAULT NULL,
  `id_section` int(11) DEFAULT NULL,
  `capacite` int(11) DEFAULT 30,
  `id_etablissement` int(11) DEFAULT NULL,
  `annee_scolaire` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `classe`
--

INSERT INTO `classe` (`id_classe`, `nom`, `niveau`, `cycle`, `id_option`, `id_section`, `capacite`, `id_etablissement`, `annee_scolaire`) VALUES
(1, '6ème Scientifique', '6ème', 'secondaire', NULL, 1, 30, 1, '2024-2025'),
(2, '5ème Scientifique', '5ème', 'secondaire', NULL, 1, 30, 1, '2024-2025'),
(3, '4ème Littéraire', '4ème', 'secondaire', NULL, 2, 30, 1, '2024-2025'),
(4, '3ème Commerciale', '3ème', 'secondaire', NULL, 3, 30, 1, '2024-2025'),
(5, '2ème Technique', '2ème', 'secondaire', NULL, 4, 30, 1, '2024-2025');

-- --------------------------------------------------------

--
-- Structure de la table `classes`
--

CREATE TABLE `classes` (
  `id_classe` int(11) NOT NULL,
  `nom_classe` varchar(50) NOT NULL,
  `niveau` varchar(50) NOT NULL,
  `id_etablissement` int(11) NOT NULL,
  `effectif_maximum` int(11) DEFAULT NULL COMMENT 'Effectif maximum de la classe',
  `effectif_actuel` int(11) DEFAULT 0 COMMENT 'Effectif actuel de la classe',
  `salle` varchar(50) DEFAULT NULL COMMENT 'Numéro ou nom de la salle',
  `annee_scolaire` varchar(20) DEFAULT NULL COMMENT 'Année scolaire (ex: 2024-2025)',
  `description` text DEFAULT NULL COMMENT 'Description détaillée de la classe'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `classes`
--

INSERT INTO `classes` (`id_classe`, `nom_classe`, `niveau`, `id_etablissement`, `effectif_maximum`, `effectif_actuel`, `salle`, `annee_scolaire`, `description`) VALUES
(1, '6ème A', '6ème', 1, 30, 28, 'Salle 4', '2024-2025', 'Classe standard'),
(3, 'CM2', 'CM2', 2, 30, 0, 'Non assignée', '2024-2025', 'Classe standard'),
(4, 'CP', 'CP', 3, 30, 28, 'Salle 3', '2024-2025', 'Classe standard'),
(5, '3e EQ', '3ème', 2, 60, 58, 'laboratoire', '2024-2025', 'l\'apprentissage c\'est un ordre de mission');

-- --------------------------------------------------------

--
-- Structure de la table `competences`
--

CREATE TABLE `competences` (
  `id_competence` int(11) NOT NULL,
  `nom_competence` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `niveau_difficulte` int(11) DEFAULT NULL,
  `id_cours` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `contenu_cours`
--

CREATE TABLE `contenu_cours` (
  `id_contenu` int(11) NOT NULL,
  `id_cours` int(11) NOT NULL,
  `titre_section` varchar(200) DEFAULT NULL,
  `contenu` text DEFAULT NULL,
  `type_contenu` enum('texte','video','document','exercice','quiz') DEFAULT 'texte',
  `ordre` int(11) DEFAULT 1,
  `date_creation` datetime DEFAULT current_timestamp(),
  `date_modification` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `contenu_cours`
--

INSERT INTO `contenu_cours` (`id_contenu`, `id_cours`, `titre_section`, `contenu`, `type_contenu`, `ordre`, `date_creation`, `date_modification`) VALUES
(3, 1, 'les nombres complexes', 'le nombre complexe resout un probleme principal sur la racine d\'un nombre negative comme par exemole -1', 'texte', 1, '2026-01-21 09:35:01', '2026-01-21 09:35:01');

-- --------------------------------------------------------

--
-- Structure de la table `contenu_lecon`
--

CREATE TABLE `contenu_lecon` (
  `id_contenu` int(11) NOT NULL,
  `id_lecon` int(11) NOT NULL,
  `type` enum('texte','video','audio','image') DEFAULT NULL,
  `contenu` text DEFAULT NULL,
  `ordre` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `cours`
--

CREATE TABLE `cours` (
  `id_cours` int(11) NOT NULL,
  `titre` varchar(150) NOT NULL,
  `description` text DEFAULT NULL,
  `ordre_progression` int(11) DEFAULT NULL,
  `id_matiere` int(11) NOT NULL,
  `id_programme` int(11) NOT NULL,
  `id_classe` int(11) DEFAULT NULL,
  `niveau_difficulte` varchar(20) DEFAULT 'Intermédiaire',
  `duree_estimee` int(11) DEFAULT 60,
  `date_creation` datetime DEFAULT current_timestamp(),
  `date_modification` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `statut` varchar(20) DEFAULT 'Actif',
  `type_cours` varchar(30) DEFAULT 'Mixte',
  `objectifs_apprentissage` text DEFAULT NULL,
  `prerequis` text DEFAULT NULL,
  `ressources_externes` text DEFAULT NULL,
  `nb_vues` int(11) DEFAULT 0,
  `taux_reussite` decimal(5,2) DEFAULT 0.00,
  `seuil_reussite` decimal(5,2) DEFAULT 50.00,
  `createur_id` int(11) DEFAULT NULL,
  `visible` tinyint(1) DEFAULT 1,
  `tags` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `cours`
--

INSERT INTO `cours` (`id_cours`, `titre`, `description`, `ordre_progression`, `id_matiere`, `id_programme`, `id_classe`, `niveau_difficulte`, `duree_estimee`, `date_creation`, `date_modification`, `statut`, `type_cours`, `objectifs_apprentissage`, `prerequis`, `ressources_externes`, `nb_vues`, `taux_reussite`, `seuil_reussite`, `createur_id`, `visible`, `tags`) VALUES
(1, 'Mathematique', 'sceince de recherche', 9, 5, 3, 1, 'Débutant', 60, '2025-12-29 17:55:17', '2025-12-31 12:42:44', 'Actif', 'Théorique', 'etre capable', 'arithmetique', 'books.com', 0, 0.00, 50.00, NULL, 1, 'mathematique examen'),
(2, 'math', 'le nombre entier', 967, 5, 2, 5, 'Débutant', 30, '2026-01-08 11:06:07', '2026-01-08 11:06:06', 'Actif', 'Théorique', 'prendre tout', 'le nombre entier', 'book.com', 0, 0.00, 50.00, NULL, 1, 'mathematique Algebre');

-- --------------------------------------------------------

--
-- Structure de la table `cours_enseignants`
--

CREATE TABLE `cours_enseignants` (
  `id_affectation` int(11) NOT NULL,
  `id_cours` int(11) NOT NULL,
  `id_enseignant` int(11) NOT NULL,
  `date_affectation` timestamp NULL DEFAULT current_timestamp(),
  `statut_affectation` enum('actif','inactif','terminé') DEFAULT 'actif',
  `annee_scolaire` varchar(20) NOT NULL DEFAULT '2024-2025',
  `observations` text DEFAULT NULL,
  `createur_id` int(11) DEFAULT NULL,
  `date_creation` timestamp NULL DEFAULT current_timestamp(),
  `date_modification` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Table d affectation des cours aux enseignants';

--
-- Déchargement des données de la table `cours_enseignants`
--

INSERT INTO `cours_enseignants` (`id_affectation`, `id_cours`, `id_enseignant`, `date_affectation`, `statut_affectation`, `annee_scolaire`, `observations`, `createur_id`, `date_creation`, `date_modification`) VALUES
(4, 1, 4, '2026-01-08 12:54:12', 'actif', '2024-2025', 'prendre', NULL, '2026-01-08 12:54:12', '2026-01-08 12:56:06');

-- --------------------------------------------------------

--
-- Structure de la table `directeur_discipline`
--

CREATE TABLE `directeur_discipline` (
  `id_directeur` int(11) NOT NULL,
  `bureau` varchar(100) DEFAULT NULL,
  `telephone_pro` varchar(20) DEFAULT NULL,
  `plages_disponibilite` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`plages_disponibilite`)),
  `date_debut` date NOT NULL,
  `date_fin` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `directeur_discipline`
--

INSERT INTO `directeur_discipline` (`id_directeur`, `bureau`, `telephone_pro`, `plages_disponibilite`, `date_debut`, `date_fin`) VALUES
(39, 'Bureau 101', '778889999', '{}', '2024-01-15', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `discipline`
--

CREATE TABLE `discipline` (
  `id_discipline` int(11) NOT NULL,
  `id_eleve` int(11) NOT NULL,
  `type_infraction` enum('retard','absence','indiscipline','violence','triche','autre') NOT NULL,
  `description` text DEFAULT NULL,
  `date_infraction` date NOT NULL,
  `lieu` varchar(100) DEFAULT NULL,
  `temoins` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`temoins`)),
  `sanction` varchar(200) DEFAULT NULL,
  `duree_sanction` varchar(50) DEFAULT NULL,
  `id_personnel_rapport` int(11) DEFAULT NULL,
  `id_parent_informe` int(11) DEFAULT NULL,
  `statut` enum('en_attente','traite','archive') DEFAULT 'en_attente',
  `date_rapport` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `eleve`
--

CREATE TABLE `eleve` (
  `id_eleve` int(11) NOT NULL,
  `id_utilisateur` int(11) DEFAULT NULL,
  `matricule` varchar(50) NOT NULL,
  `date_naissance` date NOT NULL,
  `lieu_naissance` varchar(100) DEFAULT NULL,
  `sexe` enum('M','F') NOT NULL,
  `nationalite` varchar(50) DEFAULT 'Congolaise',
  `adresse` text DEFAULT NULL,
  `id_classe_actuelle` int(11) DEFAULT NULL,
  `id_tuteur` int(11) DEFAULT NULL,
  `date_inscription` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `emprunt`
--

CREATE TABLE `emprunt` (
  `id_emprunt` int(11) NOT NULL,
  `id_livre` int(11) NOT NULL,
  `id_eleve` int(11) DEFAULT NULL,
  `id_enseignant` int(11) DEFAULT NULL,
  `date_emprunt` date NOT NULL,
  `date_retour_prevue` date NOT NULL,
  `date_retour_effective` date DEFAULT NULL,
  `statut` enum('en_cours','retourne','en_retard','perdu') DEFAULT 'en_cours',
  `penalites` decimal(10,2) DEFAULT 0.00,
  `remarques` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déclencheurs `emprunt`
--
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
-- Structure de la table `enseignant`
--

CREATE TABLE `enseignant` (
  `id_enseignant` int(11) NOT NULL,
  `matricule` varchar(50) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `date_naissance` date NOT NULL,
  `lieu_naissance` varchar(100) DEFAULT NULL,
  `sexe` enum('M','F') NOT NULL,
  `nationalite` varchar(50) DEFAULT 'Congolaise',
  `adresse` text DEFAULT NULL,
  `telephone` varchar(20) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `specialite` varchar(100) DEFAULT NULL,
  `grade` enum('A1','A2','A3','A4','A5','A6','A7','A8','A9','A10') NOT NULL,
  `date_recrutement` date DEFAULT NULL,
  `diplomes` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`diplomes`)),
  `matieres_enseignees` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`matieres_enseignees`)),
  `id_etablissement` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `etablissement`
--

CREATE TABLE `etablissement` (
  `id_etablissement` int(11) NOT NULL,
  `nom` varchar(200) NOT NULL,
  `type` enum('primaire','secondaire','lycee','technique') NOT NULL,
  `adresse` text DEFAULT NULL,
  `telephone` varchar(20) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `province` varchar(50) DEFAULT NULL,
  `ville` varchar(100) DEFAULT NULL,
  `code_postal` varchar(10) DEFAULT NULL,
  `directeur_nom` varchar(200) DEFAULT NULL,
  `date_creation` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `etablissement`
--

INSERT INTO `etablissement` (`id_etablissement`, `nom`, `type`, `adresse`, `telephone`, `email`, `province`, `ville`, `code_postal`, `directeur_nom`, `date_creation`) VALUES
(1, 'Lycée Saint Joseph', 'secondaire', 'Avenue de la Paix N°123', NULL, NULL, 'Kinshasa', 'Kinshasa', NULL, 'Dr. Jean Mukendi', '2026-02-04 12:07:39');

-- --------------------------------------------------------

--
-- Structure de la table `etablissements`
--

CREATE TABLE `etablissements` (
  `id_etablissement` int(11) NOT NULL,
  `nom` varchar(150) NOT NULL,
  `type` enum('primaire','secondaire','universitaire') NOT NULL,
  `localisation` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `etablissements`
--

INSERT INTO `etablissements` (`id_etablissement`, `nom`, `type`, `localisation`) VALUES
(1, 'Complexe scolaire tukankamane', 'secondaire', 'Av. Kabongo'),
(2, 'college bukongo', 'secondaire', 'Av. du Lac commune du lac'),
(3, 'École Primaire Bethesaida', 'primaire', 'Av. Maendeleo'),
(4, 'College Mwangaza', 'secondaire', 'Commune de la lukuga, Q. Kahite');

-- --------------------------------------------------------

--
-- Structure de la table `examen`
--

CREATE TABLE `examen` (
  `id_examen` int(11) NOT NULL,
  `type_examen` enum('Interrogation','Devoir','Composition','Examen final') NOT NULL,
  `periode` varchar(50) NOT NULL,
  `date_examen` date NOT NULL,
  `id_classe` int(11) NOT NULL,
  `nom` varchar(200) DEFAULT NULL,
  `coefficient` decimal(3,1) DEFAULT 1.0,
  `matiere` varchar(100) DEFAULT NULL,
  `id_enseignant` int(11) DEFAULT NULL,
  `heure_debut` time DEFAULT NULL,
  `heure_fin` time DEFAULT NULL,
  `id_salle` int(11) DEFAULT NULL,
  `annee_scolaire` varchar(20) DEFAULT NULL,
  `date_creation` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `exemple_lecon`
--

CREATE TABLE `exemple_lecon` (
  `id_exemple` int(11) NOT NULL,
  `id_lecon` int(11) NOT NULL,
  `enonce` text DEFAULT NULL,
  `solution` text DEFAULT NULL,
  `ordre` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `exercice`
--

CREATE TABLE `exercice` (
  `id_exercice` int(11) NOT NULL,
  `id_lecon` int(11) NOT NULL,
  `question` text DEFAULT NULL,
  `type` enum('qcm','vrai_faux','reponse_libre') DEFAULT NULL,
  `niveau` enum('facile','moyen','difficile') DEFAULT NULL,
  `score` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `exercices`
--

CREATE TABLE `exercices` (
  `id_exercice` int(11) NOT NULL,
  `question` text NOT NULL,
  `type` enum('qcm','texte','calcul') NOT NULL,
  `difficulte` int(11) DEFAULT NULL,
  `id_competence` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `experience_eleve`
--

CREATE TABLE `experience_eleve` (
  `id_experience` int(11) NOT NULL,
  `id_utilisateur` int(11) NOT NULL,
  `xp_total` int(11) DEFAULT 0,
  `id_niveau` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `frais_scolaire`
--

CREATE TABLE `frais_scolaire` (
  `id_frais` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `type` enum('inscription','scolarite','cantine','transport','materiel','autre') NOT NULL,
  `montant` decimal(10,2) NOT NULL,
  `frequence` enum('unique','mensuel','trimestriel','annuel') NOT NULL,
  `niveaux_applicables` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`niveaux_applicables`)),
  `description` text DEFAULT NULL,
  `obligatoire` tinyint(1) DEFAULT 1,
  `date_debut_applicabilite` date DEFAULT NULL,
  `date_fin_applicabilite` date DEFAULT NULL,
  `id_etablissement` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `frais_scolaire`
--

INSERT INTO `frais_scolaire` (`id_frais`, `nom`, `type`, `montant`, `frequence`, `niveaux_applicables`, `description`, `obligatoire`, `date_debut_applicabilite`, `date_fin_applicabilite`, `id_etablissement`) VALUES
(1, 'Frais d\'inscription', 'inscription', 50.00, 'unique', NULL, NULL, 1, NULL, NULL, 1),
(2, 'Scolarité mensuelle', 'scolarite', 80.00, 'mensuel', NULL, NULL, 1, NULL, NULL, 1),
(3, 'Frais de cantine', 'cantine', 30.00, 'mensuel', NULL, NULL, 0, NULL, NULL, 1),
(4, 'Transport scolaire', 'transport', 25.00, 'mensuel', NULL, NULL, 0, NULL, NULL, 1),
(5, 'Frais de laboratoire', 'materiel', 15.00, 'trimestriel', NULL, NULL, 0, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Structure de la table `inscription`
--

CREATE TABLE `inscription` (
  `id_inscription` int(11) NOT NULL,
  `id_eleve` int(11) NOT NULL,
  `id_classe` int(11) NOT NULL,
  `id_annee_scolaire` int(11) NOT NULL,
  `date_inscription` date NOT NULL,
  `type` enum('nouveau','reinscription','transfert') NOT NULL,
  `statut` enum('en_attente','validee','rejetee') DEFAULT 'en_attente',
  `frais_inscription` decimal(10,2) DEFAULT NULL,
  `montant_paye` decimal(10,2) DEFAULT 0.00,
  `documents_fournis` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`documents_fournis`)),
  `remarques` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `inscriptions`
--

CREATE TABLE `inscriptions` (
  `id_inscription` int(11) NOT NULL,
  `id_utilisateur` int(11) NOT NULL,
  `id_classe` int(11) NOT NULL,
  `annee_scolaire` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `inscriptions`
--

INSERT INTO `inscriptions` (`id_inscription`, `id_utilisateur`, `id_classe`, `annee_scolaire`) VALUES
(1, 2, 1, '2024-2025');

-- --------------------------------------------------------

--
-- Structure de la table `inspecteur`
--

CREATE TABLE `inspecteur` (
  `id_inspecteur` int(11) NOT NULL,
  `zone_inspection` varchar(100) DEFAULT NULL,
  `niveau_habilitation` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `inspecteurs`
--

CREATE TABLE `inspecteurs` (
  `id_inspecteur` int(11) NOT NULL,
  `specialite` varchar(100) NOT NULL,
  `grade` varchar(100) NOT NULL,
  `zone_geographique` varchar(100) NOT NULL,
  `etablissements_assignes` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`etablissements_assignes`)),
  `date_nomination` date NOT NULL,
  `date_fin_mission` date DEFAULT NULL,
  `statut_mission` varchar(50) DEFAULT 'en_cours',
  `rapports_emis` int(11) DEFAULT 0,
  `derniere_inspection` datetime DEFAULT NULL,
  `prochaine_inspection` datetime DEFAULT NULL,
  `type_inspections` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`type_inspections`)),
  `niveau_habilitation` int(11) DEFAULT 1,
  `vehicule_de_fonction` varchar(50) DEFAULT NULL,
  `prime_inspection` decimal(10,2) DEFAULT NULL,
  `formations_suivies` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`formations_suivies`)),
  `certifications` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`certifications`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `inventaire`
--

CREATE TABLE `inventaire` (
  `id_inventaire` int(11) NOT NULL,
  `id_materiel` int(11) NOT NULL,
  `date_inventaire` date NOT NULL,
  `quantite_theorique` int(11) NOT NULL,
  `quantite_reelle` int(11) NOT NULL,
  `difference` int(11) DEFAULT NULL,
  `etat_materiel` varchar(50) DEFAULT NULL,
  `observations` text DEFAULT NULL,
  `id_responsable` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `journal_connexion`
--

CREATE TABLE `journal_connexion` (
  `id` int(11) NOT NULL,
  `utilisateur_id` int(11) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `date_connexion` datetime DEFAULT current_timestamp(),
  `id_adresse` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `succes` tinyint(1) DEFAULT NULL,
  `raison` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `lecon`
--

CREATE TABLE `lecon` (
  `id_lecon` int(11) NOT NULL,
  `id_cours` int(11) NOT NULL,
  `titre` varchar(150) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `ordre` int(11) DEFAULT NULL,
  `duree_estimee` int(11) DEFAULT NULL,
  `statut` enum('brouillon','publie') DEFAULT 'brouillon'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `livre`
--

CREATE TABLE `livre` (
  `id_livre` int(11) NOT NULL,
  `titre` varchar(200) NOT NULL,
  `auteur` varchar(100) DEFAULT NULL,
  `isbn` varchar(20) DEFAULT NULL,
  `editeur` varchar(100) DEFAULT NULL,
  `annee_publication` year(4) DEFAULT NULL,
  `genre` varchar(50) DEFAULT NULL,
  `langue` varchar(20) DEFAULT 'Français',
  `niveau_scolaire` varchar(50) DEFAULT NULL,
  `matiere` varchar(50) DEFAULT NULL,
  `nombre_exemplaires` int(11) DEFAULT 1,
  `exemplaires_disponibles` int(11) DEFAULT 1,
  `description` text DEFAULT NULL,
  `date_ajout` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `materiel`
--

CREATE TABLE `materiel` (
  `id_materiel` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `type` enum('mobilier','informatique','scientifique','sportif','autre') NOT NULL,
  `reference` varchar(50) DEFAULT NULL,
  `marque` varchar(50) DEFAULT NULL,
  `modele` varchar(50) DEFAULT NULL,
  `date_achat` date DEFAULT NULL,
  `prix_achat` decimal(10,2) DEFAULT NULL,
  `etat` enum('neuf','bon','moyen','mauvais','hors_service') DEFAULT 'bon',
  `localisation` varchar(100) DEFAULT NULL,
  `id_salle` int(11) DEFAULT NULL,
  `responsable` varchar(100) DEFAULT NULL,
  `date_inventaire` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `matiere`
--

CREATE TABLE `matiere` (
  `id_matiere` int(11) NOT NULL,
  `nom` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `matieres`
--

CREATE TABLE `matieres` (
  `id_matiere` int(11) NOT NULL,
  `nom_matiere` varchar(100) NOT NULL,
  `coefficient` int(11) DEFAULT 1,
  `description` text DEFAULT NULL,
  `couleur` varchar(7) DEFAULT '#3498db',
  `icone` varchar(50) DEFAULT 'book',
  `date_creation` datetime DEFAULT current_timestamp(),
  `statut` varchar(20) DEFAULT 'Actif',
  `domaine` varchar(50) DEFAULT NULL,
  `niveau_min` varchar(20) DEFAULT NULL,
  `niveau_max` varchar(20) DEFAULT NULL,
  `objectifs_generaux` text DEFAULT NULL,
  `nb_heures_total` int(11) DEFAULT 0,
  `nb_cours_total` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `niveaux`
--

CREATE TABLE `niveaux` (
  `id_niveau` int(11) NOT NULL,
  `nom_niveau` varchar(50) NOT NULL,
  `xp_min` int(11) NOT NULL,
  `xp_max` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `note`
--

CREATE TABLE `note` (
  `id_note` int(11) NOT NULL,
  `id_eleve` int(11) NOT NULL,
  `id_examen` int(11) NOT NULL,
  `valeur` decimal(5,2) NOT NULL,
  `appreciation` text DEFAULT NULL,
  `date_saisie` datetime DEFAULT current_timestamp(),
  `id_enseignant` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `objectif_lecon`
--

CREATE TABLE `objectif_lecon` (
  `id_objectif` int(11) NOT NULL,
  `id_lecon` int(11) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `option_etude`
--

CREATE TABLE `option_etude` (
  `id_option` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `code` varchar(20) NOT NULL,
  `description` text DEFAULT NULL,
  `niveaux` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`niveaux`)),
  `debouches` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`debouches`)),
  `id_section` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `option_etude`
--

INSERT INTO `option_etude` (`id_option`, `nom`, `code`, `description`, `niveaux`, `debouches`, `id_section`) VALUES
(1, 'Mathématiques-Physique', 'MP', 'Mathématiques et Physique-Chimie', NULL, NULL, 1),
(2, 'Sciences de la Vie', 'SV', 'Sciences de la Vie et de la Terre', NULL, NULL, 1),
(3, 'Lettres-Philosophie', 'LP', 'Lettres et Philosophie', NULL, NULL, 2),
(4, 'Histoire-Géographie', 'HG', 'Histoire et Géographie', NULL, NULL, 2),
(5, 'Comptabilité-Gestion', 'CG', 'Comptabilité et Gestion', NULL, NULL, 3),
(6, 'Marketing-Vente', 'MV', 'Marketing et Vente', NULL, NULL, 3),
(7, 'Électrotechnique', 'ET', 'Électrotechnique et Électronique', NULL, NULL, 4),
(8, 'Mécanique', 'ME', 'Mécanique Industrielle', NULL, NULL, 4);

-- --------------------------------------------------------

--
-- Structure de la table `paiement`
--

CREATE TABLE `paiement` (
  `id_paiement` int(11) NOT NULL,
  `id_eleve` int(11) NOT NULL,
  `type_paiement` enum('scolarite','frais_scolaire','cantine','transport','autre') NOT NULL,
  `montant` decimal(10,2) NOT NULL,
  `montant_paye` decimal(10,2) DEFAULT 0.00,
  `date_paiement` date DEFAULT NULL,
  `mode_paiement` enum('especes','mobile_money','virement','cheque') NOT NULL,
  `reference_paiement` varchar(100) DEFAULT NULL,
  `statut` enum('en_attente','partiel','complet') DEFAULT 'en_attente',
  `id_utilisateur` int(11) DEFAULT NULL,
  `annee_scolaire` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `permission_role`
--

CREATE TABLE `permission_role` (
  `id` int(11) NOT NULL,
  `role` varchar(50) NOT NULL,
  `permission_code` varchar(50) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `prefet_enseignant`
--

CREATE TABLE `prefet_enseignant` (
  `id_prefet` int(11) NOT NULL,
  `departement` varchar(100) DEFAULT NULL,
  `specialite` varchar(100) DEFAULT NULL,
  `echelle_traitement` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `programme`
--

CREATE TABLE `programme` (
  `id_programme` int(11) NOT NULL,
  `id_matiere` int(11) NOT NULL,
  `titre` varchar(150) DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `programmes`
--

CREATE TABLE `programmes` (
  `id_programme` int(11) NOT NULL,
  `nom_programme` varchar(150) NOT NULL,
  `niveau` varchar(50) NOT NULL,
  `ministere_source` varchar(150) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `date_creation` datetime DEFAULT current_timestamp(),
  `date_debut` date DEFAULT NULL,
  `date_fin` date DEFAULT NULL,
  `statut` varchar(20) DEFAULT 'Actif',
  `objectifs_programme` text DEFAULT NULL,
  `competences_visees` text DEFAULT NULL,
  `modalites_evaluation` text DEFAULT NULL,
  `prerequis_programme` text DEFAULT NULL,
  `duree_totale` int(11) DEFAULT 0,
  `nb_matiere` int(11) DEFAULT 0,
  `nb_cours_total` int(11) DEFAULT 0,
  `createur_id` int(11) DEFAULT NULL,
  `version` varchar(20) DEFAULT '1.0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `progression`
--

CREATE TABLE `progression` (
  `id_progression` int(11) NOT NULL,
  `id_utilisateur` int(11) NOT NULL,
  `id_cours` int(11) NOT NULL,
  `pourcentage` decimal(5,2) DEFAULT NULL,
  `derniere_mise_a_jour` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `proviseur`
--

CREATE TABLE `proviseur` (
  `id_proviseur` int(11) NOT NULL,
  `etablissement` varchar(100) DEFAULT NULL,
  `duree_mandat` int(11) DEFAULT NULL,
  `bureau` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `quiz`
--

CREATE TABLE `quiz` (
  `id_quiz` int(11) NOT NULL,
  `id_lecon` int(11) NOT NULL,
  `titre` varchar(100) DEFAULT NULL,
  `score_min` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `rapports`
--

CREATE TABLE `rapports` (
  `id_rapport` int(11) NOT NULL,
  `id_classe` int(11) NOT NULL,
  `id_inspecteur` int(11) NOT NULL,
  `contenu` text DEFAULT NULL,
  `date_rapport` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `reponse_exercice`
--

CREATE TABLE `reponse_exercice` (
  `id_reponse` int(11) NOT NULL,
  `id_exercice` int(11) NOT NULL,
  `texte` text DEFAULT NULL,
  `correcte` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `resultats`
--

CREATE TABLE `resultats` (
  `id_resultat` int(11) NOT NULL,
  `id_utilisateur` int(11) NOT NULL,
  `id_exercice` int(11) NOT NULL,
  `score` int(11) DEFAULT NULL,
  `date_passage` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `resume_lecon`
--

CREATE TABLE `resume_lecon` (
  `id_resume` int(11) NOT NULL,
  `id_lecon` int(11) NOT NULL,
  `contenu` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `salle`
--

CREATE TABLE `salle` (
  `id_salle` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `type` enum('classe','laboratoire','bibliotheque','salle_informatique','salle_sport','administration') NOT NULL,
  `capacite` int(11) DEFAULT 30,
  `etage` varchar(20) DEFAULT NULL,
  `batiment` varchar(50) DEFAULT NULL,
  `equipements` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`equipements`)),
  `etat` enum('excellent','bon','moyen','mauvis') DEFAULT 'bon',
  `id_etablissement` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `section`
--

CREATE TABLE `section` (
  `id_section` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `code` varchar(20) NOT NULL,
  `description` text DEFAULT NULL,
  `matieres_principales` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`matieres_principales`)),
  `niveaux` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`niveaux`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `section`
--

INSERT INTO `section` (`id_section`, `nom`, `code`, `description`, `matieres_principales`, `niveaux`) VALUES
(1, 'Scientifique', 'SCI', 'Section scientifique générale', '[\"Mathématiques\", \"Physique\", \"Chimie\", \"Biologie\"]', '[\"1ère\", \"2ème\", \"3ème\", \"4ème\", \"5ème\", \"6ème\"]'),
(2, 'Littéraire', 'LIT', 'Section littéraire et sciences humaines', '[\"Français\", \"Philosophie\", \"Histoire\", \"Géographie\", \"Latin\"]', '[\"1ère\", \"2ème\", \"3ème\", \"4ème\", \"5ème\", \"6ème\"]'),
(3, 'Commerciale et Gestion', 'COM', 'Section commerciale, gestion et informatique', '[\"Comptabilité\", \"Économie\", \"Informatique de Gestion\"]', '[\"3ème\", \"4ème\", \"5ème\", \"6ème\"]'),
(4, 'Technique Industrielle', 'TECH', 'Section technique et industrielle', '[\"Électronique\", \"Mécanique\", \"Dessin Technique\"]', '[\"3ème\", \"4ème\", \"5ème\", \"6ème\"]');

-- --------------------------------------------------------

--
-- Structure de la table `titulaire`
--

CREATE TABLE `titulaire` (
  `id_titulaire` int(11) NOT NULL,
  `matiere_principale` varchar(100) DEFAULT NULL,
  `volume_horaire` int(11) DEFAULT NULL,
  `date_titularisation` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tuteur`
--

CREATE TABLE `tuteur` (
  `id_tuteur` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `telephone` varchar(20) NOT NULL,
  `email` varchar(150) DEFAULT NULL,
  `profession` varchar(100) DEFAULT NULL,
  `adresse` text DEFAULT NULL,
  `lien_parental` enum('pere','mere','tuteur','autre') NOT NULL,
  `piece_identite` varchar(50) DEFAULT NULL,
  `date_creation` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `id_utilisateur` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `telephone` varchar(20) DEFAULT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  `role` enum('administrateur','proviseur','censeur','directeur_discipline','enseignant','eleve','parent','prefet','chef_classe','president_eleves','comite_parents','secretaire','bibliothecaire','comptable','surveillant') NOT NULL,
  `statut` enum('actif','inactif','suspendu') DEFAULT 'actif',
  `date_creation` datetime DEFAULT current_timestamp(),
  `derniere_connexion` datetime DEFAULT NULL,
  `photo_profil` varchar(255) DEFAULT NULL,
  `token_reset` varchar(100) DEFAULT NULL,
  `token_expiration` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id_utilisateur`, `nom`, `prenom`, `email`, `telephone`, `mot_de_passe`, `role`, `statut`, `date_creation`, `derniere_connexion`, `photo_profil`, `token_reset`, `token_expiration`) VALUES
(18, 'Diop', 'Fatou', 'fatou.diop@ecole.sn', '771234567', '$2y$10$wLHVijx/R8jZNpeLuaKkY.zpPXd4fgQo8a74vANUj5vzuzctafNcC', 'eleve', 'actif', '2026-02-20 10:41:55', NULL, NULL, NULL, NULL),
(19, 'NDAYIKEZA', 'Amos', 'devopsamos@ecole.sn', '66642122', '$2y$10$N3kXoLkGOUgBUx4xXxiAleMBLvvqh8j3WYRNgiTGfhMZC3uU4LiWe', 'administrateur', 'actif', '2026-02-20 10:46:30', NULL, NULL, NULL, NULL),
(39, 'Diop', 'Mamadou', 'mamadou.diop@ecole.sn', '771234567', '$2y$10$SAxWJE8t9tLwEYQ/mFHAou801Fw/QMzZ8YBEEKjM9IHVOg42fdLXO', 'directeur_discipline', 'actif', '2026-02-20 13:45:38', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `vue_eleves_complets`
-- (Voir ci-dessous la vue réelle)
--
CREATE TABLE `vue_eleves_complets` (
);

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `vue_paiements_en_attente`
-- (Voir ci-dessous la vue réelle)
--
CREATE TABLE `vue_paiements_en_attente` (
);

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `vue_statistiques_classes`
-- (Voir ci-dessous la vue réelle)
--
CREATE TABLE `vue_statistiques_classes` (
);

-- --------------------------------------------------------

--
-- Structure de la vue `vue_eleves_complets`
--
DROP TABLE IF EXISTS `vue_eleves_complets`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vue_eleves_complets`  AS SELECT `e`.`id_eleve` AS `id_eleve`, `e`.`matricule` AS `matricule`, `e`.`nom` AS `nom`, `e`.`prenom` AS `prenom`, `e`.`date_naissance` AS `date_naissance`, `e`.`lieu_naissance` AS `lieu_naissance`, `e`.`sexe` AS `sexe`, `e`.`nationalite` AS `nationalite`, `e`.`adresse` AS `adresse`, `e`.`telephone` AS `telephone`, `e`.`email` AS `email`, `e`.`id_classe_actuelle` AS `id_classe_actuelle`, `e`.`id_tuteur` AS `id_tuteur`, `e`.`date_inscription` AS `date_inscription`, `e`.`statut` AS `statut`, `c`.`nom` AS `nom_classe`, `c`.`niveau` AS `niveau_classe`, `t`.`nom` AS `nom_tuteur`, `t`.`telephone` AS `telephone_tuteur`, `t`.`lien_parental` AS `lien_parental` FROM ((`eleve` `e` left join `classe` `c` on(`e`.`id_classe_actuelle` = `c`.`id_classe`)) left join `tuteur` `t` on(`e`.`id_tuteur` = `t`.`id_tuteur`)) ;

-- --------------------------------------------------------

--
-- Structure de la vue `vue_paiements_en_attente`
--
DROP TABLE IF EXISTS `vue_paiements_en_attente`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vue_paiements_en_attente`  AS SELECT `p`.`id_paiement` AS `id_paiement`, `p`.`id_eleve` AS `id_eleve`, `p`.`type_paiement` AS `type_paiement`, `p`.`montant` AS `montant`, `p`.`montant_paye` AS `montant_paye`, `p`.`date_paiement` AS `date_paiement`, `p`.`mode_paiement` AS `mode_paiement`, `p`.`reference_paiement` AS `reference_paiement`, `p`.`statut` AS `statut`, `p`.`id_utilisateur` AS `id_utilisateur`, `p`.`annee_scolaire` AS `annee_scolaire`, `e`.`nom` AS `nom_eleve`, `e`.`prenom` AS `prenom_eleve`, `e`.`matricule` AS `matricule_eleve`, `c`.`nom` AS `nom_classe` FROM (((`paiement` `p` join `eleve` `e` on(`p`.`id_eleve` = `e`.`id_eleve`)) left join `inscription` `i` on(`e`.`id_classe_actuelle` = `i`.`id_classe` and `i`.`statut` = 'validee')) left join `classe` `c` on(`i`.`id_classe` = `c`.`id_classe`)) WHERE `p`.`statut` <> 'complet' ORDER BY `p`.`date_paiement` DESC ;

-- --------------------------------------------------------

--
-- Structure de la vue `vue_statistiques_classes`
--
DROP TABLE IF EXISTS `vue_statistiques_classes`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vue_statistiques_classes`  AS SELECT `c`.`id_classe` AS `id_classe`, `c`.`nom` AS `nom`, `c`.`niveau` AS `niveau`, `c`.`cycle` AS `cycle`, `c`.`id_option` AS `id_option`, `c`.`id_section` AS `id_section`, `c`.`capacite` AS `capacite`, `c`.`id_etablissement` AS `id_etablissement`, `c`.`annee_scolaire` AS `annee_scolaire`, count(`e`.`id_eleve`) AS `nombre_eleves`, count(case when `e`.`sexe` = 'M' then 1 end) AS `nombre_garcons`, count(case when `e`.`sexe` = 'F' then 1 end) AS `nombre_filles`, `s`.`nom` AS `nom_section` FROM ((`classe` `c` left join `eleve` `e` on(`c`.`id_classe` = `e`.`id_classe_actuelle` and `e`.`statut` = 'actif')) left join `section` `s` on(`c`.`id_section` = `s`.`id_section`)) GROUP BY `c`.`id_classe` ;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `activite`
--
ALTER TABLE `activite`
  ADD PRIMARY KEY (`id_activite`),
  ADD KEY `id_lecon` (`id_lecon`);

--
-- Index pour la table `activites`
--
ALTER TABLE `activites`
  ADD PRIMARY KEY (`id_activite`),
  ADD KEY `id_utilisateur` (`id_utilisateur`);

--
-- Index pour la table `administrateurs`
--
ALTER TABLE `administrateurs`
  ADD PRIMARY KEY (`id_administrateur`);

--
-- Index pour la table `annee_scolaire`
--
ALTER TABLE `annee_scolaire`
  ADD PRIMARY KEY (`id_annee`),
  ADD UNIQUE KEY `libelle` (`libelle`),
  ADD KEY `idx_annee_actif` (`actif`);

--
-- Index pour la table `badges`
--
ALTER TABLE `badges`
  ADD PRIMARY KEY (`id_badge`);

--
-- Index pour la table `badges_obtenus`
--
ALTER TABLE `badges_obtenus`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_badge` (`id_badge`),
  ADD KEY `id_utilisateur` (`id_utilisateur`);

--
-- Index pour la table `bulletin`
--
ALTER TABLE `bulletin`
  ADD PRIMARY KEY (`id_bulletin`),
  ADD KEY `id_classe` (`id_classe`),
  ADD KEY `id_enseignant_principal` (`id_enseignant_principal`),
  ADD KEY `idx_bulletin_eleve` (`id_eleve`),
  ADD KEY `idx_bulletin_trimestre` (`trimestre`),
  ADD KEY `idx_bulletin_annee` (`annee_scolaire`);

--
-- Index pour la table `classe`
--
ALTER TABLE `classe`
  ADD PRIMARY KEY (`id_classe`),
  ADD KEY `id_option` (`id_option`),
  ADD KEY `id_section` (`id_section`),
  ADD KEY `idx_classe_niveau` (`niveau`),
  ADD KEY `idx_classe_cycle` (`cycle`),
  ADD KEY `idx_classe_etablissement` (`id_etablissement`);

--
-- Index pour la table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`id_classe`),
  ADD KEY `fk_classes_etablissement` (`id_etablissement`);

--
-- Index pour la table `competences`
--
ALTER TABLE `competences`
  ADD PRIMARY KEY (`id_competence`),
  ADD KEY `id_cours` (`id_cours`);

--
-- Index pour la table `contenu_cours`
--
ALTER TABLE `contenu_cours`
  ADD PRIMARY KEY (`id_contenu`),
  ADD KEY `id_cours` (`id_cours`);

--
-- Index pour la table `contenu_lecon`
--
ALTER TABLE `contenu_lecon`
  ADD PRIMARY KEY (`id_contenu`),
  ADD KEY `id_lecon` (`id_lecon`);

--
-- Index pour la table `cours`
--
ALTER TABLE `cours`
  ADD PRIMARY KEY (`id_cours`),
  ADD KEY `fk_cours_matiere` (`id_matiere`),
  ADD KEY `fk_cours_programme` (`id_programme`),
  ADD KEY `fk_cours_classe` (`id_classe`),
  ADD KEY `fk_cours_createur` (`createur_id`);

--
-- Index pour la table `cours_enseignants`
--
ALTER TABLE `cours_enseignants`
  ADD PRIMARY KEY (`id_affectation`),
  ADD UNIQUE KEY `unique_cours_enseignant_annee` (`id_cours`,`id_enseignant`,`annee_scolaire`),
  ADD KEY `idx_enseignant` (`id_enseignant`),
  ADD KEY `idx_cours` (`id_cours`),
  ADD KEY `idx_annee_scolaire` (`annee_scolaire`),
  ADD KEY `idx_statut` (`statut_affectation`);

--
-- Index pour la table `directeur_discipline`
--
ALTER TABLE `directeur_discipline`
  ADD PRIMARY KEY (`id_directeur`);

--
-- Index pour la table `discipline`
--
ALTER TABLE `discipline`
  ADD PRIMARY KEY (`id_discipline`),
  ADD KEY `idx_discipline_eleve` (`id_eleve`),
  ADD KEY `idx_discipline_type` (`type_infraction`),
  ADD KEY `idx_discipline_date` (`date_infraction`),
  ADD KEY `idx_discipline_statut` (`statut`);

--
-- Index pour la table `eleve`
--
ALTER TABLE `eleve`
  ADD PRIMARY KEY (`id_eleve`),
  ADD UNIQUE KEY `matricule` (`matricule`),
  ADD UNIQUE KEY `id_utilisateur` (`id_utilisateur`),
  ADD KEY `idx_eleve_matricule` (`matricule`),
  ADD KEY `idx_eleve_classe` (`id_classe_actuelle`),
  ADD KEY `idx_eleve_sexe` (`sexe`);

--
-- Index pour la table `emprunt`
--
ALTER TABLE `emprunt`
  ADD PRIMARY KEY (`id_emprunt`),
  ADD KEY `id_enseignant` (`id_enseignant`),
  ADD KEY `idx_emprunt_livre` (`id_livre`),
  ADD KEY `idx_emprunt_eleve` (`id_eleve`),
  ADD KEY `idx_emprunt_statut` (`statut`),
  ADD KEY `idx_emprunt_date` (`date_emprunt`);

--
-- Index pour la table `enseignant`
--
ALTER TABLE `enseignant`
  ADD PRIMARY KEY (`id_enseignant`),
  ADD UNIQUE KEY `matricule` (`matricule`),
  ADD KEY `idx_enseignant_matricule` (`matricule`),
  ADD KEY `idx_enseignant_grade` (`grade`),
  ADD KEY `idx_enseignant_specialite` (`specialite`),
  ADD KEY `idx_enseignant_etablissement` (`id_etablissement`);

--
-- Index pour la table `etablissement`
--
ALTER TABLE `etablissement`
  ADD PRIMARY KEY (`id_etablissement`),
  ADD KEY `idx_etablissement_type` (`type`),
  ADD KEY `idx_etablissement_ville` (`ville`);

--
-- Index pour la table `etablissements`
--
ALTER TABLE `etablissements`
  ADD PRIMARY KEY (`id_etablissement`);

--
-- Index pour la table `examen`
--
ALTER TABLE `examen`
  ADD PRIMARY KEY (`id_examen`),
  ADD KEY `id_enseignant` (`id_enseignant`),
  ADD KEY `id_salle` (`id_salle`),
  ADD KEY `idx_examen_classe` (`id_classe`),
  ADD KEY `idx_examen_type` (`type_examen`),
  ADD KEY `idx_examen_date` (`date_examen`),
  ADD KEY `idx_examen_matiere` (`matiere`);

--
-- Index pour la table `exemple_lecon`
--
ALTER TABLE `exemple_lecon`
  ADD PRIMARY KEY (`id_exemple`),
  ADD KEY `id_lecon` (`id_lecon`);

--
-- Index pour la table `exercice`
--
ALTER TABLE `exercice`
  ADD PRIMARY KEY (`id_exercice`),
  ADD KEY `id_lecon` (`id_lecon`);

--
-- Index pour la table `exercices`
--
ALTER TABLE `exercices`
  ADD PRIMARY KEY (`id_exercice`),
  ADD KEY `id_competence` (`id_competence`);

--
-- Index pour la table `experience_eleve`
--
ALTER TABLE `experience_eleve`
  ADD PRIMARY KEY (`id_experience`),
  ADD UNIQUE KEY `id_utilisateur` (`id_utilisateur`),
  ADD KEY `id_niveau` (`id_niveau`);

--
-- Index pour la table `frais_scolaire`
--
ALTER TABLE `frais_scolaire`
  ADD PRIMARY KEY (`id_frais`),
  ADD KEY `idx_frais_type` (`type`),
  ADD KEY `idx_frais_frequence` (`frequence`),
  ADD KEY `idx_frais_etablissement` (`id_etablissement`);

--
-- Index pour la table `inscription`
--
ALTER TABLE `inscription`
  ADD PRIMARY KEY (`id_inscription`),
  ADD KEY `idx_inscription_eleve` (`id_eleve`),
  ADD KEY `idx_inscription_classe` (`id_classe`),
  ADD KEY `idx_inscription_annee` (`id_annee_scolaire`),
  ADD KEY `idx_inscription_statut` (`statut`);

--
-- Index pour la table `inscriptions`
--
ALTER TABLE `inscriptions`
  ADD PRIMARY KEY (`id_inscription`),
  ADD KEY `fk_inscriptions_utilisateur` (`id_utilisateur`),
  ADD KEY `fk_inscriptions_classe` (`id_classe`);

--
-- Index pour la table `inspecteur`
--
ALTER TABLE `inspecteur`
  ADD PRIMARY KEY (`id_inspecteur`);

--
-- Index pour la table `inspecteurs`
--
ALTER TABLE `inspecteurs`
  ADD PRIMARY KEY (`id_inspecteur`);

--
-- Index pour la table `inventaire`
--
ALTER TABLE `inventaire`
  ADD PRIMARY KEY (`id_inventaire`),
  ADD KEY `idx_inventaire_materiel` (`id_materiel`),
  ADD KEY `idx_inventaire_date` (`date_inventaire`);

--
-- Index pour la table `journal_connexion`
--
ALTER TABLE `journal_connexion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `utilisateur_id` (`utilisateur_id`);

--
-- Index pour la table `lecon`
--
ALTER TABLE `lecon`
  ADD PRIMARY KEY (`id_lecon`),
  ADD KEY `id_cours` (`id_cours`);

--
-- Index pour la table `livre`
--
ALTER TABLE `livre`
  ADD PRIMARY KEY (`id_livre`),
  ADD UNIQUE KEY `isbn` (`isbn`),
  ADD KEY `idx_livre_titre` (`titre`),
  ADD KEY `idx_livre_auteur` (`auteur`),
  ADD KEY `idx_livre_isbn` (`isbn`),
  ADD KEY `idx_livre_matiere` (`matiere`);

--
-- Index pour la table `materiel`
--
ALTER TABLE `materiel`
  ADD PRIMARY KEY (`id_materiel`),
  ADD UNIQUE KEY `reference` (`reference`),
  ADD KEY `idx_materiel_type` (`type`),
  ADD KEY `idx_materiel_etat` (`etat`),
  ADD KEY `idx_materiel_salle` (`id_salle`),
  ADD KEY `idx_materiel_reference` (`reference`);

--
-- Index pour la table `matiere`
--
ALTER TABLE `matiere`
  ADD PRIMARY KEY (`id_matiere`);

--
-- Index pour la table `matieres`
--
ALTER TABLE `matieres`
  ADD PRIMARY KEY (`id_matiere`);

--
-- Index pour la table `niveaux`
--
ALTER TABLE `niveaux`
  ADD PRIMARY KEY (`id_niveau`);

--
-- Index pour la table `note`
--
ALTER TABLE `note`
  ADD PRIMARY KEY (`id_note`),
  ADD KEY `id_enseignant` (`id_enseignant`),
  ADD KEY `idx_note_eleve` (`id_eleve`),
  ADD KEY `idx_note_examen` (`id_examen`),
  ADD KEY `idx_note_valeur` (`valeur`);

--
-- Index pour la table `objectif_lecon`
--
ALTER TABLE `objectif_lecon`
  ADD PRIMARY KEY (`id_objectif`),
  ADD KEY `id_lecon` (`id_lecon`);

--
-- Index pour la table `option_etude`
--
ALTER TABLE `option_etude`
  ADD PRIMARY KEY (`id_option`),
  ADD UNIQUE KEY `code` (`code`),
  ADD KEY `idx_option_section` (`id_section`),
  ADD KEY `idx_option_code` (`code`);

--
-- Index pour la table `paiement`
--
ALTER TABLE `paiement`
  ADD PRIMARY KEY (`id_paiement`),
  ADD KEY `id_utilisateur` (`id_utilisateur`),
  ADD KEY `idx_paiement_eleve` (`id_eleve`),
  ADD KEY `idx_paiement_type` (`type_paiement`),
  ADD KEY `idx_paiement_statut` (`statut`),
  ADD KEY `idx_paiement_date` (`date_paiement`);

--
-- Index pour la table `permission_role`
--
ALTER TABLE `permission_role`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_role_permission` (`role`,`permission_code`);

--
-- Index pour la table `prefet_enseignant`
--
ALTER TABLE `prefet_enseignant`
  ADD PRIMARY KEY (`id_prefet`);

--
-- Index pour la table `programme`
--
ALTER TABLE `programme`
  ADD PRIMARY KEY (`id_programme`),
  ADD KEY `id_matiere` (`id_matiere`);

--
-- Index pour la table `programmes`
--
ALTER TABLE `programmes`
  ADD PRIMARY KEY (`id_programme`);

--
-- Index pour la table `progression`
--
ALTER TABLE `progression`
  ADD PRIMARY KEY (`id_progression`),
  ADD KEY `id_utilisateur` (`id_utilisateur`),
  ADD KEY `id_cours` (`id_cours`);

--
-- Index pour la table `proviseur`
--
ALTER TABLE `proviseur`
  ADD PRIMARY KEY (`id_proviseur`);

--
-- Index pour la table `quiz`
--
ALTER TABLE `quiz`
  ADD PRIMARY KEY (`id_quiz`),
  ADD KEY `id_lecon` (`id_lecon`);

--
-- Index pour la table `rapports`
--
ALTER TABLE `rapports`
  ADD PRIMARY KEY (`id_rapport`),
  ADD KEY `id_classe` (`id_classe`),
  ADD KEY `id_inspecteur` (`id_inspecteur`);

--
-- Index pour la table `reponse_exercice`
--
ALTER TABLE `reponse_exercice`
  ADD PRIMARY KEY (`id_reponse`),
  ADD KEY `id_exercice` (`id_exercice`);

--
-- Index pour la table `resultats`
--
ALTER TABLE `resultats`
  ADD PRIMARY KEY (`id_resultat`),
  ADD KEY `id_utilisateur` (`id_utilisateur`),
  ADD KEY `id_exercice` (`id_exercice`);

--
-- Index pour la table `resume_lecon`
--
ALTER TABLE `resume_lecon`
  ADD PRIMARY KEY (`id_resume`),
  ADD KEY `id_lecon` (`id_lecon`);

--
-- Index pour la table `salle`
--
ALTER TABLE `salle`
  ADD PRIMARY KEY (`id_salle`),
  ADD KEY `idx_salle_type` (`type`),
  ADD KEY `idx_salle_etat` (`etat`),
  ADD KEY `idx_salle_etablissement` (`id_etablissement`);

--
-- Index pour la table `section`
--
ALTER TABLE `section`
  ADD PRIMARY KEY (`id_section`),
  ADD UNIQUE KEY `code` (`code`),
  ADD KEY `idx_section_code` (`code`);

--
-- Index pour la table `titulaire`
--
ALTER TABLE `titulaire`
  ADD PRIMARY KEY (`id_titulaire`);

--
-- Index pour la table `tuteur`
--
ALTER TABLE `tuteur`
  ADD PRIMARY KEY (`id_tuteur`),
  ADD KEY `idx_tuteur_telephone` (`telephone`),
  ADD KEY `idx_tuteur_lien` (`lien_parental`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`id_utilisateur`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `idx_utilisateur_role` (`role`),
  ADD KEY `idx_utilisateur_email` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `activite`
--
ALTER TABLE `activite`
  MODIFY `id_activite` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `activites`
--
ALTER TABLE `activites`
  MODIFY `id_activite` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=200;

--
-- AUTO_INCREMENT pour la table `annee_scolaire`
--
ALTER TABLE `annee_scolaire`
  MODIFY `id_annee` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `badges`
--
ALTER TABLE `badges`
  MODIFY `id_badge` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `badges_obtenus`
--
ALTER TABLE `badges_obtenus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `bulletin`
--
ALTER TABLE `bulletin`
  MODIFY `id_bulletin` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `classe`
--
ALTER TABLE `classe`
  MODIFY `id_classe` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `classes`
--
ALTER TABLE `classes`
  MODIFY `id_classe` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `competences`
--
ALTER TABLE `competences`
  MODIFY `id_competence` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `contenu_cours`
--
ALTER TABLE `contenu_cours`
  MODIFY `id_contenu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `contenu_lecon`
--
ALTER TABLE `contenu_lecon`
  MODIFY `id_contenu` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `cours`
--
ALTER TABLE `cours`
  MODIFY `id_cours` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `cours_enseignants`
--
ALTER TABLE `cours_enseignants`
  MODIFY `id_affectation` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `discipline`
--
ALTER TABLE `discipline`
  MODIFY `id_discipline` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `eleve`
--
ALTER TABLE `eleve`
  MODIFY `id_eleve` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `emprunt`
--
ALTER TABLE `emprunt`
  MODIFY `id_emprunt` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `enseignant`
--
ALTER TABLE `enseignant`
  MODIFY `id_enseignant` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `etablissement`
--
ALTER TABLE `etablissement`
  MODIFY `id_etablissement` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `etablissements`
--
ALTER TABLE `etablissements`
  MODIFY `id_etablissement` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `examen`
--
ALTER TABLE `examen`
  MODIFY `id_examen` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `exemple_lecon`
--
ALTER TABLE `exemple_lecon`
  MODIFY `id_exemple` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `exercice`
--
ALTER TABLE `exercice`
  MODIFY `id_exercice` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `exercices`
--
ALTER TABLE `exercices`
  MODIFY `id_exercice` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `experience_eleve`
--
ALTER TABLE `experience_eleve`
  MODIFY `id_experience` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `frais_scolaire`
--
ALTER TABLE `frais_scolaire`
  MODIFY `id_frais` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `inscription`
--
ALTER TABLE `inscription`
  MODIFY `id_inscription` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `inscriptions`
--
ALTER TABLE `inscriptions`
  MODIFY `id_inscription` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `inventaire`
--
ALTER TABLE `inventaire`
  MODIFY `id_inventaire` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `journal_connexion`
--
ALTER TABLE `journal_connexion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `lecon`
--
ALTER TABLE `lecon`
  MODIFY `id_lecon` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `livre`
--
ALTER TABLE `livre`
  MODIFY `id_livre` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `materiel`
--
ALTER TABLE `materiel`
  MODIFY `id_materiel` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `matiere`
--
ALTER TABLE `matiere`
  MODIFY `id_matiere` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `matieres`
--
ALTER TABLE `matieres`
  MODIFY `id_matiere` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `niveaux`
--
ALTER TABLE `niveaux`
  MODIFY `id_niveau` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `note`
--
ALTER TABLE `note`
  MODIFY `id_note` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `objectif_lecon`
--
ALTER TABLE `objectif_lecon`
  MODIFY `id_objectif` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `option_etude`
--
ALTER TABLE `option_etude`
  MODIFY `id_option` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `paiement`
--
ALTER TABLE `paiement`
  MODIFY `id_paiement` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `permission_role`
--
ALTER TABLE `permission_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `programme`
--
ALTER TABLE `programme`
  MODIFY `id_programme` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `programmes`
--
ALTER TABLE `programmes`
  MODIFY `id_programme` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `progression`
--
ALTER TABLE `progression`
  MODIFY `id_progression` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `quiz`
--
ALTER TABLE `quiz`
  MODIFY `id_quiz` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `rapports`
--
ALTER TABLE `rapports`
  MODIFY `id_rapport` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `reponse_exercice`
--
ALTER TABLE `reponse_exercice`
  MODIFY `id_reponse` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `resultats`
--
ALTER TABLE `resultats`
  MODIFY `id_resultat` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `resume_lecon`
--
ALTER TABLE `resume_lecon`
  MODIFY `id_resume` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `salle`
--
ALTER TABLE `salle`
  MODIFY `id_salle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `section`
--
ALTER TABLE `section`
  MODIFY `id_section` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `tuteur`
--
ALTER TABLE `tuteur`
  MODIFY `id_tuteur` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `id_utilisateur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `administrateurs`
--
ALTER TABLE `administrateurs`
  ADD CONSTRAINT `administrateurs_ibfk_1` FOREIGN KEY (`id_administrateur`) REFERENCES `utilisateur` (`id_utilisateur`) ON DELETE CASCADE;

--
-- Contraintes pour la table `bulletin`
--
ALTER TABLE `bulletin`
  ADD CONSTRAINT `bulletin_ibfk_1` FOREIGN KEY (`id_eleve`) REFERENCES `eleve` (`id_eleve`) ON DELETE CASCADE,
  ADD CONSTRAINT `bulletin_ibfk_2` FOREIGN KEY (`id_classe`) REFERENCES `classe` (`id_classe`) ON DELETE CASCADE,
  ADD CONSTRAINT `bulletin_ibfk_3` FOREIGN KEY (`id_enseignant_principal`) REFERENCES `enseignant` (`id_enseignant`) ON DELETE SET NULL;

--
-- Contraintes pour la table `classe`
--
ALTER TABLE `classe`
  ADD CONSTRAINT `classe_ibfk_1` FOREIGN KEY (`id_etablissement`) REFERENCES `etablissement` (`id_etablissement`) ON DELETE SET NULL,
  ADD CONSTRAINT `classe_ibfk_2` FOREIGN KEY (`id_option`) REFERENCES `option_etude` (`id_option`) ON DELETE SET NULL,
  ADD CONSTRAINT `classe_ibfk_3` FOREIGN KEY (`id_section`) REFERENCES `section` (`id_section`) ON DELETE SET NULL;

--
-- Contraintes pour la table `directeur_discipline`
--
ALTER TABLE `directeur_discipline`
  ADD CONSTRAINT `directeur_discipline_ibfk_1` FOREIGN KEY (`id_directeur`) REFERENCES `utilisateur` (`id_utilisateur`) ON DELETE CASCADE;

--
-- Contraintes pour la table `discipline`
--
ALTER TABLE `discipline`
  ADD CONSTRAINT `discipline_ibfk_1` FOREIGN KEY (`id_eleve`) REFERENCES `eleve` (`id_eleve`) ON DELETE CASCADE;

--
-- Contraintes pour la table `eleve`
--
ALTER TABLE `eleve`
  ADD CONSTRAINT `eleve_ibfk_1` FOREIGN KEY (`id_classe_actuelle`) REFERENCES `classe` (`id_classe`) ON DELETE SET NULL,
  ADD CONSTRAINT `eleve_ibfk_2` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateur` (`id_utilisateur`);

--
-- Contraintes pour la table `emprunt`
--
ALTER TABLE `emprunt`
  ADD CONSTRAINT `emprunt_ibfk_1` FOREIGN KEY (`id_livre`) REFERENCES `livre` (`id_livre`) ON DELETE CASCADE,
  ADD CONSTRAINT `emprunt_ibfk_2` FOREIGN KEY (`id_eleve`) REFERENCES `eleve` (`id_eleve`) ON DELETE SET NULL,
  ADD CONSTRAINT `emprunt_ibfk_3` FOREIGN KEY (`id_enseignant`) REFERENCES `enseignant` (`id_enseignant`) ON DELETE SET NULL;

--
-- Contraintes pour la table `enseignant`
--
ALTER TABLE `enseignant`
  ADD CONSTRAINT `enseignant_ibfk_1` FOREIGN KEY (`id_etablissement`) REFERENCES `etablissement` (`id_etablissement`) ON DELETE SET NULL;

--
-- Contraintes pour la table `examen`
--
ALTER TABLE `examen`
  ADD CONSTRAINT `examen_ibfk_1` FOREIGN KEY (`id_classe`) REFERENCES `classe` (`id_classe`) ON DELETE CASCADE,
  ADD CONSTRAINT `examen_ibfk_2` FOREIGN KEY (`id_enseignant`) REFERENCES `enseignant` (`id_enseignant`) ON DELETE SET NULL,
  ADD CONSTRAINT `examen_ibfk_3` FOREIGN KEY (`id_salle`) REFERENCES `salle` (`id_salle`) ON DELETE SET NULL;

--
-- Contraintes pour la table `frais_scolaire`
--
ALTER TABLE `frais_scolaire`
  ADD CONSTRAINT `frais_scolaire_ibfk_1` FOREIGN KEY (`id_etablissement`) REFERENCES `etablissement` (`id_etablissement`) ON DELETE SET NULL;

--
-- Contraintes pour la table `inscription`
--
ALTER TABLE `inscription`
  ADD CONSTRAINT `inscription_ibfk_1` FOREIGN KEY (`id_eleve`) REFERENCES `eleve` (`id_eleve`) ON DELETE CASCADE,
  ADD CONSTRAINT `inscription_ibfk_2` FOREIGN KEY (`id_classe`) REFERENCES `classe` (`id_classe`) ON DELETE CASCADE,
  ADD CONSTRAINT `inscription_ibfk_3` FOREIGN KEY (`id_annee_scolaire`) REFERENCES `annee_scolaire` (`id_annee`) ON DELETE CASCADE;

--
-- Contraintes pour la table `inspecteur`
--
ALTER TABLE `inspecteur`
  ADD CONSTRAINT `inspecteur_ibfk_1` FOREIGN KEY (`id_inspecteur`) REFERENCES `utilisateur` (`id_utilisateur`);

--
-- Contraintes pour la table `inspecteurs`
--
ALTER TABLE `inspecteurs`
  ADD CONSTRAINT `inspecteurs_ibfk_1` FOREIGN KEY (`id_inspecteur`) REFERENCES `utilisateur` (`id_utilisateur`) ON DELETE CASCADE;

--
-- Contraintes pour la table `inventaire`
--
ALTER TABLE `inventaire`
  ADD CONSTRAINT `inventaire_ibfk_1` FOREIGN KEY (`id_materiel`) REFERENCES `materiel` (`id_materiel`) ON DELETE CASCADE;

--
-- Contraintes pour la table `journal_connexion`
--
ALTER TABLE `journal_connexion`
  ADD CONSTRAINT `journal_connexion_ibfk_1` FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateur` (`id_utilisateur`) ON DELETE SET NULL;

--
-- Contraintes pour la table `materiel`
--
ALTER TABLE `materiel`
  ADD CONSTRAINT `materiel_ibfk_1` FOREIGN KEY (`id_salle`) REFERENCES `salle` (`id_salle`) ON DELETE SET NULL;

--
-- Contraintes pour la table `note`
--
ALTER TABLE `note`
  ADD CONSTRAINT `note_ibfk_1` FOREIGN KEY (`id_eleve`) REFERENCES `eleve` (`id_eleve`) ON DELETE CASCADE,
  ADD CONSTRAINT `note_ibfk_2` FOREIGN KEY (`id_examen`) REFERENCES `examen` (`id_examen`) ON DELETE CASCADE,
  ADD CONSTRAINT `note_ibfk_3` FOREIGN KEY (`id_enseignant`) REFERENCES `enseignant` (`id_enseignant`) ON DELETE SET NULL;

--
-- Contraintes pour la table `option_etude`
--
ALTER TABLE `option_etude`
  ADD CONSTRAINT `option_etude_ibfk_1` FOREIGN KEY (`id_section`) REFERENCES `section` (`id_section`) ON DELETE SET NULL;

--
-- Contraintes pour la table `paiement`
--
ALTER TABLE `paiement`
  ADD CONSTRAINT `paiement_ibfk_1` FOREIGN KEY (`id_eleve`) REFERENCES `eleve` (`id_eleve`) ON DELETE CASCADE,
  ADD CONSTRAINT `paiement_ibfk_2` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateur` (`id_utilisateur`) ON DELETE SET NULL;

--
-- Contraintes pour la table `prefet_enseignant`
--
ALTER TABLE `prefet_enseignant`
  ADD CONSTRAINT `prefet_enseignant_ibfk_1` FOREIGN KEY (`id_prefet`) REFERENCES `utilisateur` (`id_utilisateur`);

--
-- Contraintes pour la table `proviseur`
--
ALTER TABLE `proviseur`
  ADD CONSTRAINT `proviseur_ibfk_1` FOREIGN KEY (`id_proviseur`) REFERENCES `utilisateur` (`id_utilisateur`);

--
-- Contraintes pour la table `salle`
--
ALTER TABLE `salle`
  ADD CONSTRAINT `salle_ibfk_1` FOREIGN KEY (`id_etablissement`) REFERENCES `etablissement` (`id_etablissement`) ON DELETE SET NULL;

--
-- Contraintes pour la table `titulaire`
--
ALTER TABLE `titulaire`
  ADD CONSTRAINT `titulaire_ibfk_1` FOREIGN KEY (`id_titulaire`) REFERENCES `utilisateur` (`id_utilisateur`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
