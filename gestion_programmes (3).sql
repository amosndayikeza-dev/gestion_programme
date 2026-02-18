-- Changer le délimiteur
DELIMITER $$

-- Première procédure : calculer_moyenne_eleve
DROP PROCEDURE IF EXISTS `calculer_moyenne_eleve`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `calculer_moyenne_eleve` (
    IN `p_id_eleve` INT, 
    IN `p_trimestre` VARCHAR(10), 
    IN `p_annee` VARCHAR(20)
)  
BEGIN
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

-- Deuxième procédure : inscrire_eleve (COMPLÈTE)
DROP PROCEDURE IF EXISTS `inscrire_eleve`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `inscrire_eleve` (
    IN `p_nom` VARCHAR(100), 
    IN `p_prenom` VARCHAR(100), 
    IN `p_date_naissance` DATE, 
    IN `p_sexe` ENUM('M','F'), 
    IN `p_id_classe` INT, 
    IN `p_id_tuteur` INT, 
    IN `p_id_annee` INT
)  
BEGIN
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

-- Rétablir le délimiteur par défaut
DELIMITER ;
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
) ENGINE=MyISAM AUTO_INCREMENT=200 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


DROP TABLE IF EXISTS `annee_scolaire`;
CREATE TABLE IF NOT EXISTS `annee_scolaire` (
  `id_annee` int NOT NULL AUTO_INCREMENT,
  `libelle` varchar(20) NOT NULL,
  `date_debut` date NOT NULL,
  `date_fin` date NOT NULL,
  `actif` tinyint(1) DEFAULT '0',
  `date_creation` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_annee`),
  UNIQUE KEY `libelle` (`libelle`),
  KEY `idx_annee_actif` (`actif`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `annee_scolaire`
--

INSERT INTO `annee_scolaire` (`id_annee`, `libelle`, `date_debut`, `date_fin`, `actif`, `date_creation`) VALUES
(1, '2024-2025', '2024-09-01', '2025-07-31', 1, '2026-02-04 12:07:39');

-- --------------------------------------------------------

--
-- Table structure for table `badges`
--

DROP TABLE IF EXISTS `badges`;
CREATE TABLE IF NOT EXISTS `badges` (
  `id_badge` int NOT NULL AUTO_INCREMENT,
  `nom_badge` varchar(100) NOT NULL,
  `condition_obtention` text,
  PRIMARY KEY (`id_badge`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bulletin`
--

DROP TABLE IF EXISTS `bulletin`;
CREATE TABLE IF NOT EXISTS `bulletin` (
  `id_bulletin` int NOT NULL AUTO_INCREMENT,
  `id_eleve` int NOT NULL,
  `id_classe` int NOT NULL,
  `trimestre` enum('1er','2ème','3ème') NOT NULL,
  `annee_scolaire` varchar(20) NOT NULL,
  `moyenne_generale` decimal(5,2) DEFAULT NULL,
  `rang` int DEFAULT NULL,
  `total_effectif` int DEFAULT NULL,
  `appreciation_generale` text,
  `date_emission` date DEFAULT NULL,
  `id_enseignant_principal` int DEFAULT NULL,
  PRIMARY KEY (`id_bulletin`),
  KEY `id_classe` (`id_classe`),
  KEY `id_enseignant_principal` (`id_enseignant_principal`),
  KEY `idx_bulletin_eleve` (`id_eleve`),
  KEY `idx_bulletin_trimestre` (`trimestre`),
  KEY `idx_bulletin_annee` (`annee_scolaire`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `classe`
--

DROP TABLE IF EXISTS `classe`;
CREATE TABLE IF NOT EXISTS `classe` (
  `id_classe` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  `niveau` varchar(20) NOT NULL,
  `cycle` enum('primaire','secondaire','superieur') NOT NULL,
  `id_option` int DEFAULT NULL,
  `id_section` int DEFAULT NULL,
  `capacite` int DEFAULT '30',
  `id_etablissement` int DEFAULT NULL,
  `annee_scolaire` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id_classe`),
  KEY `id_option` (`id_option`),
  KEY `id_section` (`id_section`),
  KEY `idx_classe_niveau` (`niveau`),
  KEY `idx_classe_cycle` (`cycle`),
  KEY `idx_classe_etablissement` (`id_etablissement`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `classe`
--

INSERT INTO `classe` (`id_classe`, `nom`, `niveau`, `cycle`, `id_option`, `id_section`, `capacite`, `id_etablissement`, `annee_scolaire`) VALUES
(1, '6ème Scientifique', '6ème', 'secondaire', NULL, 1, 30, 1, '2024-2025'),
(2, '5ème Scientifique', '5ème', 'secondaire', NULL, 1, 30, 1, '2024-2025'),
(3, '4ème Littéraire', '4ème', 'secondaire', NULL, 2, 30, 1, '2024-2025'),
(4, '3ème Commerciale', '3ème', 'secondaire', NULL, 3, 30, 1, '2024-2025'),
(5, '2ème Technique', '2ème', 'secondaire', NULL, 4, 30, 1, '2024-2025');

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
  KEY `fk_classes_etablissement` (`id_etablissement`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contenu_cours`
--

DROP TABLE IF EXISTS `contenu_cours`;
CREATE TABLE IF NOT EXISTS `contenu_cours` (
  `id_contenu` int NOT NULL AUTO_INCREMENT,
  `id_cours` int NOT NULL,
  `titre_section` varchar(200) DEFAULT NULL,
  `contenu` text,
  `type_contenu` enum('texte','video','document','exercice','quiz') DEFAULT 'texte',
  `ordre` int DEFAULT '1',
  `date_creation` datetime DEFAULT CURRENT_TIMESTAMP,
  `date_modification` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_contenu`),
  KEY `id_cours` (`id_cours`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `contenu_cours`
--

INSERT INTO `contenu_cours` (`id_contenu`, `id_cours`, `titre_section`, `contenu`, `type_contenu`, `ordre`, `date_creation`, `date_modification`) VALUES
(3, 1, 'les nombres complexes', 'le nombre complexe resout un probleme principal sur la racine d\'un nombre negative comme par exemole -1', 'texte', 1, '2026-01-21 09:35:01', '2026-01-21 09:35:01');

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
  KEY `fk_cours_matiere` (`id_matiere`),
  KEY `fk_cours_programme` (`id_programme`),
  KEY `fk_cours_classe` (`id_classe`),
  KEY `fk_cours_createur` (`createur_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `cours`
--

INSERT INTO `cours` (`id_cours`, `titre`, `description`, `ordre_progression`, `id_matiere`, `id_programme`, `id_classe`, `niveau_difficulte`, `duree_estimee`, `date_creation`, `date_modification`, `statut`, `type_cours`, `objectifs_apprentissage`, `prerequis`, `ressources_externes`, `nb_vues`, `taux_reussite`, `seuil_reussite`, `createur_id`, `visible`, `tags`) VALUES
(1, 'Mathematique', 'sceince de recherche', 9, 5, 3, 1, 'Débutant', 60, '2025-12-29 17:55:17', '2025-12-31 12:42:44', 'Actif', 'Théorique', 'etre capable', 'arithmetique', 'books.com', 0, 0.00, 50.00, NULL, 1, 'mathematique examen'),
(2, 'math', 'le nombre entier', 967, 5, 2, 5, 'Débutant', 30, '2026-01-08 11:06:07', '2026-01-08 11:06:06', 'Actif', 'Théorique', 'prendre tout', 'le nombre entier', 'book.com', 0, 0.00, 50.00, NULL, 1, 'mathematique Algebre');

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
  `createur_id` int DEFAULT NULL,
  `date_creation` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modification` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_affectation`),
  UNIQUE KEY `unique_cours_enseignant_annee` (`id_cours`,`id_enseignant`,`annee_scolaire`),
  KEY `idx_enseignant` (`id_enseignant`),
  KEY `idx_cours` (`id_cours`),
  KEY `idx_annee_scolaire` (`annee_scolaire`),
  KEY `idx_statut` (`statut_affectation`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Table d affectation des cours aux enseignants';

--
-- Dumping data for table `cours_enseignants`
--

INSERT INTO `cours_enseignants` (`id_affectation`, `id_cours`, `id_enseignant`, `date_affectation`, `statut_affectation`, `annee_scolaire`, `observations`, `createur_id`, `date_creation`, `date_modification`) VALUES
(4, 1, 4, '2026-01-08 12:54:12', 'actif', '2024-2025', 'prendre', NULL, '2026-01-08 12:54:12', '2026-01-08 12:56:06');

-- --------------------------------------------------------

--
-- Table structure for table `discipline`
--

DROP TABLE IF EXISTS `discipline`;
CREATE TABLE IF NOT EXISTS `discipline` (
  `id_discipline` int NOT NULL AUTO_INCREMENT,
  `id_eleve` int NOT NULL,
  `type_infraction` enum('retard','absence','indiscipline','violence','triche','autre') NOT NULL,
  `description` text,
  `date_infraction` date NOT NULL,
  `lieu` varchar(100) DEFAULT NULL,
  `temoins` json DEFAULT NULL,
  `sanction` varchar(200) DEFAULT NULL,
  `duree_sanction` varchar(50) DEFAULT NULL,
  `id_personnel_rapport` int DEFAULT NULL,
  `id_parent_informe` int DEFAULT NULL,
  `statut` enum('en_attente','traite','archive') DEFAULT 'en_attente',
  `date_rapport` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_discipline`),
  KEY `idx_discipline_eleve` (`id_eleve`),
  KEY `idx_discipline_type` (`type_infraction`),
  KEY `idx_discipline_date` (`date_infraction`),
  KEY `idx_discipline_statut` (`statut`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `eleve`
--

DROP TABLE IF EXISTS `eleve`;
CREATE TABLE IF NOT EXISTS `eleve` (
  `id_eleve` int NOT NULL AUTO_INCREMENT,
  `matricule` varchar(50) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `date_naissance` date NOT NULL,
  `lieu_naissance` varchar(100) DEFAULT NULL,
  `sexe` enum('M','F') NOT NULL,
  `nationalite` varchar(50) DEFAULT 'Congolaise',
  `adresse` text,
  `telephone` varchar(20) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `id_classe_actuelle` int DEFAULT NULL,
  `id_tuteur` int DEFAULT NULL,
  `date_inscription` date DEFAULT NULL,
  `statut` enum('actif','suspendu','diplome','abandon') DEFAULT 'actif',
  PRIMARY KEY (`id_eleve`),
  UNIQUE KEY `matricule` (`matricule`),
  KEY `idx_eleve_matricule` (`matricule`),
  KEY `idx_eleve_classe` (`id_classe_actuelle`),
  KEY `idx_eleve_statut` (`statut`),
  KEY `idx_eleve_sexe` (`sexe`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
  `statut` enum('en_cours','retourne','en_retard','perdu') DEFAULT 'en_cours',
  `penalites` decimal(10,2) DEFAULT '0.00',
  `remarques` text,
  PRIMARY KEY (`id_emprunt`),
  KEY `id_enseignant` (`id_enseignant`),
  KEY `idx_emprunt_livre` (`id_livre`),
  KEY `idx_emprunt_eleve` (`id_eleve`),
  KEY `idx_emprunt_statut` (`statut`),
  KEY `idx_emprunt_date` (`date_emprunt`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
  `matricule` varchar(50) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `date_naissance` date NOT NULL,
  `lieu_naissance` varchar(100) DEFAULT NULL,
  `sexe` enum('M','F') NOT NULL,
  `nationalite` varchar(50) DEFAULT 'Congolaise',
  `adresse` text,
  `telephone` varchar(20) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `specialite` varchar(100) DEFAULT NULL,
  `grade` enum('A1','A2','A3','A4','A5','A6','A7','A8','A9','A10') NOT NULL,
  `date_recrutement` date DEFAULT NULL,
  `diplomes` json DEFAULT NULL,
  `matieres_enseignees` json DEFAULT NULL,
  `id_etablissement` int DEFAULT NULL,
  PRIMARY KEY (`id_enseignant`),
  UNIQUE KEY `matricule` (`matricule`),
  KEY `idx_enseignant_matricule` (`matricule`),
  KEY `idx_enseignant_grade` (`grade`),
  KEY `idx_enseignant_specialite` (`specialite`),
  KEY `idx_enseignant_etablissement` (`id_etablissement`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `etablissement`
--

DROP TABLE IF EXISTS `etablissement`;
CREATE TABLE IF NOT EXISTS `etablissement` (
  `id_etablissement` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(200) NOT NULL,
  `type` enum('primaire','secondaire','lycee','technique') NOT NULL,
  `adresse` text,
  `telephone` varchar(20) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `province` varchar(50) DEFAULT NULL,
  `ville` varchar(100) DEFAULT NULL,
  `code_postal` varchar(10) DEFAULT NULL,
  `directeur_nom` varchar(200) DEFAULT NULL,
  `date_creation` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_etablissement`),
  KEY `idx_etablissement_type` (`type`),
  KEY `idx_etablissement_ville` (`ville`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `etablissement`
--

INSERT INTO `etablissement` (`id_etablissement`, `nom`, `type`, `adresse`, `telephone`, `email`, `province`, `ville`, `code_postal`, `directeur_nom`, `date_creation`) VALUES
(1, 'Lycée Saint Joseph', 'secondaire', 'Avenue de la Paix N°123', NULL, NULL, 'Kinshasa', 'Kinshasa', NULL, 'Dr. Jean Mukendi', '2026-02-04 12:07:39');

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
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `etablissements`
--

INSERT INTO `etablissements` (`id_etablissement`, `nom`, `type`, `localisation`) VALUES
(1, 'Complexe scolaire tukankamane', 'secondaire', 'Av. Kabongo'),
(2, 'college bukongo', 'secondaire', 'Av. du Lac commune du lac'),
(3, 'École Primaire Bethesaida', 'primaire', 'Av. Maendeleo'),
(4, 'College Mwangaza', 'secondaire', 'Commune de la lukuga, Q. Kahite');

-- --------------------------------------------------------

--
-- Table structure for table `examen`
--

DROP TABLE IF EXISTS `examen`;
CREATE TABLE IF NOT EXISTS `examen` (
  `id_examen` int NOT NULL AUTO_INCREMENT,
  `type_examen` enum('Interrogation','Devoir','Composition','Examen final') NOT NULL,
  `periode` varchar(50) NOT NULL,
  `date_examen` date NOT NULL,
  `id_classe` int NOT NULL,
  `nom` varchar(200) DEFAULT NULL,
  `coefficient` decimal(3,1) DEFAULT '1.0',
  `matiere` varchar(100) DEFAULT NULL,
  `id_enseignant` int DEFAULT NULL,
  `heure_debut` time DEFAULT NULL,
  `heure_fin` time DEFAULT NULL,
  `id_salle` int DEFAULT NULL,
  `annee_scolaire` varchar(20) DEFAULT NULL,
  `date_creation` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_examen`),
  KEY `id_enseignant` (`id_enseignant`),
  KEY `id_salle` (`id_salle`),
  KEY `idx_examen_classe` (`id_classe`),
  KEY `idx_examen_type` (`type_examen`),
  KEY `idx_examen_date` (`date_examen`),
  KEY `idx_examen_matiere` (`matiere`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `frais_scolaire`
--

DROP TABLE IF EXISTS `frais_scolaire`;
CREATE TABLE IF NOT EXISTS `frais_scolaire` (
  `id_frais` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) NOT NULL,
  `type` enum('inscription','scolarite','cantine','transport','materiel','autre') NOT NULL,
  `montant` decimal(10,2) NOT NULL,
  `frequence` enum('unique','mensuel','trimestriel','annuel') NOT NULL,
  `niveaux_applicables` json DEFAULT NULL,
  `description` text,
  `obligatoire` tinyint(1) DEFAULT '1',
  `date_debut_applicabilite` date DEFAULT NULL,
  `date_fin_applicabilite` date DEFAULT NULL,
  `id_etablissement` int DEFAULT NULL,
  PRIMARY KEY (`id_frais`),
  KEY `idx_frais_type` (`type`),
  KEY `idx_frais_frequence` (`frequence`),
  KEY `idx_frais_etablissement` (`id_etablissement`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `frais_scolaire`
--

INSERT INTO `frais_scolaire` (`id_frais`, `nom`, `type`, `montant`, `frequence`, `niveaux_applicables`, `description`, `obligatoire`, `date_debut_applicabilite`, `date_fin_applicabilite`, `id_etablissement`) VALUES
(1, 'Frais d\'inscription', 'inscription', 50.00, 'unique', NULL, NULL, 1, NULL, NULL, 1),
(2, 'Scolarité mensuelle', 'scolarite', 80.00, 'mensuel', NULL, NULL, 1, NULL, NULL, 1),
(3, 'Frais de cantine', 'cantine', 30.00, 'mensuel', NULL, NULL, 0, NULL, NULL, 1),
(4, 'Transport scolaire', 'transport', 25.00, 'mensuel', NULL, NULL, 0, NULL, NULL, 1),
(5, 'Frais de laboratoire', 'materiel', 15.00, 'trimestriel', NULL, NULL, 0, NULL, NULL, 1);

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
  `type` enum('nouveau','reinscription','transfert') NOT NULL,
  `statut` enum('en_attente','validee','rejetee') DEFAULT 'en_attente',
  `frais_inscription` decimal(10,2) DEFAULT NULL,
  `montant_paye` decimal(10,2) DEFAULT '0.00',
  `documents_fournis` json DEFAULT NULL,
  `remarques` text,
  PRIMARY KEY (`id_inscription`),
  KEY `idx_inscription_eleve` (`id_eleve`),
  KEY `idx_inscription_classe` (`id_classe`),
  KEY `idx_inscription_annee` (`id_annee_scolaire`),
  KEY `idx_inscription_statut` (`statut`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
  KEY `fk_inscriptions_utilisateur` (`id_utilisateur`),
  KEY `fk_inscriptions_classe` (`id_classe`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `inscriptions`
--

INSERT INTO `inscriptions` (`id_inscription`, `id_utilisateur`, `id_classe`, `annee_scolaire`) VALUES
(1, 2, 1, '2024-2025');

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
  `etat_materiel` varchar(50) DEFAULT NULL,
  `observations` text,
  `id_responsable` int DEFAULT NULL,
  PRIMARY KEY (`id_inventaire`),
  KEY `idx_inventaire_materiel` (`id_materiel`),
  KEY `idx_inventaire_date` (`date_inventaire`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `livre`
--

DROP TABLE IF EXISTS `livre`;
CREATE TABLE IF NOT EXISTS `livre` (
  `id_livre` int NOT NULL AUTO_INCREMENT,
  `titre` varchar(200) NOT NULL,
  `auteur` varchar(100) DEFAULT NULL,
  `isbn` varchar(20) DEFAULT NULL,
  `editeur` varchar(100) DEFAULT NULL,
  `annee_publication` year DEFAULT NULL,
  `genre` varchar(50) DEFAULT NULL,
  `langue` varchar(20) DEFAULT 'Français',
  `niveau_scolaire` varchar(50) DEFAULT NULL,
  `matiere` varchar(50) DEFAULT NULL,
  `nombre_exemplaires` int DEFAULT '1',
  `exemplaires_disponibles` int DEFAULT '1',
  `description` text,
  `date_ajout` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_livre`),
  UNIQUE KEY `isbn` (`isbn`),
  KEY `idx_livre_titre` (`titre`),
  KEY `idx_livre_auteur` (`auteur`),
  KEY `idx_livre_isbn` (`isbn`),
  KEY `idx_livre_matiere` (`matiere`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `materiel`
--

DROP TABLE IF EXISTS `materiel`;
CREATE TABLE IF NOT EXISTS `materiel` (
  `id_materiel` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) NOT NULL,
  `type` enum('mobilier','informatique','scientifique','sportif','autre') NOT NULL,
  `reference` varchar(50) DEFAULT NULL,
  `marque` varchar(50) DEFAULT NULL,
  `modele` varchar(50) DEFAULT NULL,
  `date_achat` date DEFAULT NULL,
  `prix_achat` decimal(10,2) DEFAULT NULL,
  `etat` enum('neuf','bon','moyen','mauvais','hors_service') DEFAULT 'bon',
  `localisation` varchar(100) DEFAULT NULL,
  `id_salle` int DEFAULT NULL,
  `responsable` varchar(100) DEFAULT NULL,
  `date_inventaire` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_materiel`),
  UNIQUE KEY `reference` (`reference`),
  KEY `idx_materiel_type` (`type`),
  KEY `idx_materiel_etat` (`etat`),
  KEY `idx_materiel_salle` (`id_salle`),
  KEY `idx_materiel_reference` (`reference`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `matiere`
--

DROP TABLE IF EXISTS `matiere`;
CREATE TABLE IF NOT EXISTS `matiere` (
  `id_matiere` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) DEFAULT NULL,
  `description` text,
  PRIMARY KEY (`id_matiere`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


DROP TABLE IF EXISTS `niveaux`;
CREATE TABLE IF NOT EXISTS `niveaux` (
  `id_niveau` int NOT NULL AUTO_INCREMENT,
  `nom_niveau` varchar(50) NOT NULL,
  `xp_min` int NOT NULL,
  `xp_max` int NOT NULL,
  PRIMARY KEY (`id_niveau`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


DROP TABLE IF EXISTS `note`;
CREATE TABLE IF NOT EXISTS `note` (
  `id_note` int NOT NULL AUTO_INCREMENT,
  `id_eleve` int NOT NULL,
  `id_examen` int NOT NULL,
  `valeur` decimal(5,2) NOT NULL,
  `appreciation` text,
  `date_saisie` datetime DEFAULT CURRENT_TIMESTAMP,
  `id_enseignant` int DEFAULT NULL,
  PRIMARY KEY (`id_note`),
  KEY `id_enseignant` (`id_enseignant`),
  KEY `idx_note_eleve` (`id_eleve`),
  KEY `idx_note_examen` (`id_examen`),
  KEY `idx_note_valeur` (`valeur`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


DROP TABLE IF EXISTS `option_etude`;
CREATE TABLE IF NOT EXISTS `option_etude` (
  `id_option` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) NOT NULL,
  `code` varchar(20) NOT NULL,
  `description` text,
  `niveaux` json DEFAULT NULL,
  `debouches` json DEFAULT NULL,
  `id_section` int DEFAULT NULL,
  PRIMARY KEY (`id_option`),
  UNIQUE KEY `code` (`code`),
  KEY `idx_option_section` (`id_section`),
  KEY `idx_option_code` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `option_etude` (`id_option`, `nom`, `code`, `description`, `niveaux`, `debouches`, `id_section`) VALUES
(1, 'Mathématiques-Physique', 'MP', 'Mathématiques et Physique-Chimie', NULL, NULL, 1),
(2, 'Sciences de la Vie', 'SV', 'Sciences de la Vie et de la Terre', NULL, NULL, 1),
(3, 'Lettres-Philosophie', 'LP', 'Lettres et Philosophie', NULL, NULL, 2),
(4, 'Histoire-Géographie', 'HG', 'Histoire et Géographie', NULL, NULL, 2),
(5, 'Comptabilité-Gestion', 'CG', 'Comptabilité et Gestion', NULL, NULL, 3),
(6, 'Marketing-Vente', 'MV', 'Marketing et Vente', NULL, NULL, 3),
(7, 'Électrotechnique', 'ET', 'Électrotechnique et Électronique', NULL, NULL, 4),
(8, 'Mécanique', 'ME', 'Mécanique Industrielle', NULL, NULL, 4);


DROP TABLE IF EXISTS `paiement`;
CREATE TABLE IF NOT EXISTS `paiement` (
  `id_paiement` int NOT NULL AUTO_INCREMENT,
  `id_eleve` int NOT NULL,
  `type_paiement` enum('scolarite','frais_scolaire','cantine','transport','autre') NOT NULL,
  `montant` decimal(10,2) NOT NULL,
  `montant_paye` decimal(10,2) DEFAULT '0.00',
  `date_paiement` date DEFAULT NULL,
  `mode_paiement` enum('especes','mobile_money','virement','cheque') NOT NULL,
  `reference_paiement` varchar(100) DEFAULT NULL,
  `statut` enum('en_attente','partiel','complet') DEFAULT 'en_attente',
  `id_utilisateur` int DEFAULT NULL,
  `annee_scolaire` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id_paiement`),
  KEY `id_utilisateur` (`id_utilisateur`),
  KEY `idx_paiement_eleve` (`id_eleve`),
  KEY `idx_paiement_type` (`type_paiement`),
  KEY `idx_paiement_statut` (`statut`),
  KEY `idx_paiement_date` (`date_paiement`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

DROP TABLE IF EXISTS `programme`;
CREATE TABLE IF NOT EXISTS `programme` (
  `id_programme` int NOT NULL AUTO_INCREMENT,
  `id_matiere` int NOT NULL,
  `titre` varchar(150) DEFAULT NULL,
  `description` text,
  PRIMARY KEY (`id_programme`),
  KEY `id_matiere` (`id_matiere`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


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
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


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
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


DROP TABLE IF EXISTS `quiz`;
CREATE TABLE IF NOT EXISTS `quiz` (
  `id_quiz` int NOT NULL AUTO_INCREMENT,
  `id_lecon` int NOT NULL,
  `titre` varchar(100) DEFAULT NULL,
  `score_min` int DEFAULT NULL,
  PRIMARY KEY (`id_quiz`),
  KEY `id_lecon` (`id_lecon`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


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
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


DROP TABLE IF EXISTS `reponse_exercice`;
CREATE TABLE IF NOT EXISTS `reponse_exercice` (
  `id_reponse` int NOT NULL AUTO_INCREMENT,
  `id_exercice` int NOT NULL,
  `texte` text,
  `correcte` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id_reponse`),
  KEY `id_exercice` (`id_exercice`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


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
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;



DROP TABLE IF EXISTS `resume_lecon`;
CREATE TABLE IF NOT EXISTS `resume_lecon` (
  `id_resume` int NOT NULL AUTO_INCREMENT,
  `id_lecon` int NOT NULL,
  `contenu` text,
  PRIMARY KEY (`id_resume`),
  KEY `id_lecon` (`id_lecon`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


DROP TABLE IF EXISTS `salle`;
CREATE TABLE IF NOT EXISTS `salle` (
  `id_salle` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  `type` enum('classe','laboratoire','bibliotheque','salle_informatique','salle_sport','administration') NOT NULL,
  `capacite` int DEFAULT '30',
  `etage` varchar(20) DEFAULT NULL,
  `batiment` varchar(50) DEFAULT NULL,
  `equipements` json DEFAULT NULL,
  `etat` enum('excellent','bon','moyen','mauvis') DEFAULT 'bon',
  `id_etablissement` int DEFAULT NULL,
  PRIMARY KEY (`id_salle`),
  KEY `idx_salle_type` (`type`),
  KEY `idx_salle_etat` (`etat`),
  KEY `idx_salle_etablissement` (`id_etablissement`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;



DROP TABLE IF EXISTS `section`;
CREATE TABLE IF NOT EXISTS `section` (
  `id_section` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) NOT NULL,
  `code` varchar(20) NOT NULL,
  `description` text,
  `matieres_principales` json DEFAULT NULL,
  `niveaux` json DEFAULT NULL,
  PRIMARY KEY (`id_section`),
  UNIQUE KEY `code` (`code`),
  KEY `idx_section_code` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


DROP TABLE IF EXISTS `tuteur`;
CREATE TABLE IF NOT EXISTS `tuteur` (
  `id_tuteur` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `telephone` varchar(20) NOT NULL,
  `email` varchar(150) DEFAULT NULL,
  `profession` varchar(100) DEFAULT NULL,
  `adresse` text,
  `lien_parental` enum('pere','mere','tuteur','autre') NOT NULL,
  `piece_identite` varchar(50) DEFAULT NULL,
  `date_creation` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_tuteur`),
  KEY `idx_tuteur_telephone` (`telephone`),
  KEY `idx_tuteur_lien` (`lien_parental`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;



DROP TABLE IF EXISTS `utilisateur`;
CREATE TABLE IF NOT EXISTS `utilisateur` (
  `id_utilisateur` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  `role` enum('administrateur','proviseur','censeur','directeur_discipline','enseignant','eleve','parent','prefet','chef_classe','president_eleves','comite_parents','secretaire','bibliothecaire','comptable','surveillant') NOT NULL,
  `date_creation` datetime DEFAULT CURRENT_TIMESTAMP,
  `photo_profil` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_utilisateur`),
  UNIQUE KEY `email` (`email`),
  KEY `idx_utilisateur_role` (`role`),
  KEY `idx_utilisateur_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


DROP VIEW IF EXISTS `vue_eleves_complets`;
CREATE TABLE IF NOT EXISTS `vue_eleves_complets` (
`adresse` text
,`date_inscription` date
,`date_naissance` date
,`email` varchar(150)
,`id_classe_actuelle` int
,`id_eleve` int
,`id_tuteur` int
,`lien_parental` enum('pere','mere','tuteur','autre')
,`lieu_naissance` varchar(100)
,`matricule` varchar(50)
,`nationalite` varchar(50)
,`niveau_classe` varchar(20)
,`nom` varchar(100)
,`nom_classe` varchar(50)
,`nom_tuteur` varchar(100)
,`prenom` varchar(100)
,`sexe` enum('M','F')
,`statut` enum('actif','suspendu','diplome','abandon')
,`telephone` varchar(20)
,`telephone_tuteur` varchar(20)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `vue_paiements_en_attente`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `vue_paiements_en_attente`;
CREATE TABLE IF NOT EXISTS `vue_paiements_en_attente` (
`annee_scolaire` varchar(20)
,`date_paiement` date
,`id_eleve` int
,`id_paiement` int
,`id_utilisateur` int
,`matricule_eleve` varchar(50)
,`mode_paiement` enum('especes','mobile_money','virement','cheque')
,`montant` decimal(10,2)
,`montant_paye` decimal(10,2)
,`nom_classe` varchar(50)
,`nom_eleve` varchar(100)
,`prenom_eleve` varchar(100)
,`reference_paiement` varchar(100)
,`statut` enum('en_attente','partiel','complet')
,`type_paiement` enum('scolarite','frais_scolaire','cantine','transport','autre')
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `vue_statistiques_classes`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `vue_statistiques_classes`;
CREATE TABLE IF NOT EXISTS `vue_statistiques_classes` (
`annee_scolaire` varchar(20)
,`capacite` int
,`cycle` enum('primaire','secondaire','superieur')
,`id_classe` int
,`id_etablissement` int
,`id_option` int
,`id_section` int
,`niveau` varchar(20)
,`nom` varchar(50)
,`nom_section` varchar(100)
,`nombre_eleves` bigint
,`nombre_filles` bigint
,`nombre_garcons` bigint
);

-- --------------------------------------------------------

--
-- Structure for view `vue_eleves_complets`
--
DROP TABLE IF EXISTS `vue_eleves_complets`;

DROP VIEW IF EXISTS `vue_eleves_complets`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vue_eleves_complets`  AS SELECT `e`.`id_eleve` AS `id_eleve`, `e`.`matricule` AS `matricule`, `e`.`nom` AS `nom`, `e`.`prenom` AS `prenom`, `e`.`date_naissance` AS `date_naissance`, `e`.`lieu_naissance` AS `lieu_naissance`, `e`.`sexe` AS `sexe`, `e`.`nationalite` AS `nationalite`, `e`.`adresse` AS `adresse`, `e`.`telephone` AS `telephone`, `e`.`email` AS `email`, `e`.`id_classe_actuelle` AS `id_classe_actuelle`, `e`.`id_tuteur` AS `id_tuteur`, `e`.`date_inscription` AS `date_inscription`, `e`.`statut` AS `statut`, `c`.`nom` AS `nom_classe`, `c`.`niveau` AS `niveau_classe`, `t`.`nom` AS `nom_tuteur`, `t`.`telephone` AS `telephone_tuteur`, `t`.`lien_parental` AS `lien_parental` FROM ((`eleve` `e` left join `classe` `c` on((`e`.`id_classe_actuelle` = `c`.`id_classe`))) left join `tuteur` `t` on((`e`.`id_tuteur` = `t`.`id_tuteur`))) ;

-- --------------------------------------------------------

--
-- Structure for view `vue_paiements_en_attente`
--
DROP TABLE IF EXISTS `vue_paiements_en_attente`;

DROP VIEW IF EXISTS `vue_paiements_en_attente`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vue_paiements_en_attente`  AS SELECT `p`.`id_paiement` AS `id_paiement`, `p`.`id_eleve` AS `id_eleve`, `p`.`type_paiement` AS `type_paiement`, `p`.`montant` AS `montant`, `p`.`montant_paye` AS `montant_paye`, `p`.`date_paiement` AS `date_paiement`, `p`.`mode_paiement` AS `mode_paiement`, `p`.`reference_paiement` AS `reference_paiement`, `p`.`statut` AS `statut`, `p`.`id_utilisateur` AS `id_utilisateur`, `p`.`annee_scolaire` AS `annee_scolaire`, `e`.`nom` AS `nom_eleve`, `e`.`prenom` AS `prenom_eleve`, `e`.`matricule` AS `matricule_eleve`, `c`.`nom` AS `nom_classe` FROM (((`paiement` `p` join `eleve` `e` on((`p`.`id_eleve` = `e`.`id_eleve`))) left join `inscription` `i` on(((`e`.`id_classe_actuelle` = `i`.`id_classe`) and (`i`.`statut` = 'validee')))) left join `classe` `c` on((`i`.`id_classe` = `c`.`id_classe`))) WHERE (`p`.`statut` <> 'complet') ORDER BY `p`.`date_paiement` DESC ;

-- --------------------------------------------------------

--
-- Structure for view `vue_statistiques_classes`
--
DROP TABLE IF EXISTS `vue_statistiques_classes`;

DROP VIEW IF EXISTS `vue_statistiques_classes`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vue_statistiques_classes`  AS SELECT `c`.`id_classe` AS `id_classe`, `c`.`nom` AS `nom`, `c`.`niveau` AS `niveau`, `c`.`cycle` AS `cycle`, `c`.`id_option` AS `id_option`, `c`.`id_section` AS `id_section`, `c`.`capacite` AS `capacite`, `c`.`id_etablissement` AS `id_etablissement`, `c`.`annee_scolaire` AS `annee_scolaire`, count(`e`.`id_eleve`) AS `nombre_eleves`, count((case when (`e`.`sexe` = 'M') then 1 end)) AS `nombre_garcons`, count((case when (`e`.`sexe` = 'F') then 1 end)) AS `nombre_filles`, `s`.`nom` AS `nom_section` FROM ((`classe` `c` left join `eleve` `e` on(((`c`.`id_classe` = `e`.`id_classe_actuelle`) and (`e`.`statut` = 'actif')))) left join `section` `s` on((`c`.`id_section` = `s`.`id_section`))) GROUP BY `c`.`id_classe` ;

--
-- Constraints for dumped tables
--

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
  ADD CONSTRAINT `classe_ibfk_1` FOREIGN KEY (`id_etablissement`) REFERENCES `etablissement` (`id_etablissement`) ON DELETE SET NULL,
  ADD CONSTRAINT `classe_ibfk_2` FOREIGN KEY (`id_option`) REFERENCES `option_etude` (`id_option`) ON DELETE SET NULL,
  ADD CONSTRAINT `classe_ibfk_3` FOREIGN KEY (`id_section`) REFERENCES `section` (`id_section`) ON DELETE SET NULL;

--
-- Constraints for table `discipline`
--
ALTER TABLE `discipline`
  ADD CONSTRAINT `discipline_ibfk_1` FOREIGN KEY (`id_eleve`) REFERENCES `eleve` (`id_eleve`) ON DELETE CASCADE;

--
-- Constraints for table `eleve`
--
ALTER TABLE `eleve`
  ADD CONSTRAINT `eleve_ibfk_1` FOREIGN KEY (`id_classe_actuelle`) REFERENCES `classe` (`id_classe`) ON DELETE SET NULL;

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
  ADD CONSTRAINT `enseignant_ibfk_1` FOREIGN KEY (`id_etablissement`) REFERENCES `etablissement` (`id_etablissement`) ON DELETE SET NULL;

--
-- Constraints for table `examen`
--
ALTER TABLE `examen`
  ADD CONSTRAINT `examen_ibfk_1` FOREIGN KEY (`id_classe`) REFERENCES `classe` (`id_classe`) ON DELETE CASCADE,
  ADD CONSTRAINT `examen_ibfk_2` FOREIGN KEY (`id_enseignant`) REFERENCES `enseignant` (`id_enseignant`) ON DELETE SET NULL,
  ADD CONSTRAINT `examen_ibfk_3` FOREIGN KEY (`id_salle`) REFERENCES `salle` (`id_salle`) ON DELETE SET NULL;

--
-- Constraints for table `frais_scolaire`
--
ALTER TABLE `frais_scolaire`
  ADD CONSTRAINT `frais_scolaire_ibfk_1` FOREIGN KEY (`id_etablissement`) REFERENCES `etablissement` (`id_etablissement`) ON DELETE SET NULL;

--
-- Constraints for table `inscription`
--
ALTER TABLE `inscription`
  ADD CONSTRAINT `inscription_ibfk_1` FOREIGN KEY (`id_eleve`) REFERENCES `eleve` (`id_eleve`) ON DELETE CASCADE,
  ADD CONSTRAINT `inscription_ibfk_2` FOREIGN KEY (`id_classe`) REFERENCES `classe` (`id_classe`) ON DELETE CASCADE,
  ADD CONSTRAINT `inscription_ibfk_3` FOREIGN KEY (`id_annee_scolaire`) REFERENCES `annee_scolaire` (`id_annee`) ON DELETE CASCADE;

--
-- Constraints for table `inventaire`
--
ALTER TABLE `inventaire`
  ADD CONSTRAINT `inventaire_ibfk_1` FOREIGN KEY (`id_materiel`) REFERENCES `materiel` (`id_materiel`) ON DELETE CASCADE;

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
-- Constraints for table `salle`
--
ALTER TABLE `salle`
  ADD CONSTRAINT `salle_ibfk_1` FOREIGN KEY (`id_etablissement`) REFERENCES `etablissement` (`id_etablissement`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
