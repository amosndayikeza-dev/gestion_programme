-- =====================================================
-- BASE DE DONNÉES COMPLÈTE POUR ÉCOLE SECONDAIRE CONGO
-- =====================================================
-- Création de la base de données
CREATE DATABASE IF NOT EXISTS `ecole_secondaire_congo` 
DEFAULT CHARACTER SET utf8mb4 
DEFAULT COLLATE utf8mb4_unicode_ci;

USE `ecole_secondaire_congo`;

-- =====================================================
-- 1. TABLE ECOLE
-- =====================================================
CREATE TABLE `ecole` (
  `id_ecole` INT AUTO_INCREMENT PRIMARY KEY,
  `nom_ecole` VARCHAR(200) NOT NULL,
  `type_ecole` ENUM('Publique', 'Privée', 'Confessionnelle') NOT NULL,
  `ministere_tutelle` VARCHAR(100) NOT NULL DEFAULT 'MINISTERE DE L\'EDUCATION NATIONALE',
  `province` VARCHAR(50) NOT NULL,
  `territoire_commune` VARCHAR(100) NOT NULL,
  `adresse` TEXT,
  `telephone` VARCHAR(20),
  `email` VARCHAR(100),
  `code_ecole` VARCHAR(20) UNIQUE,
  `date_creation` DATE DEFAULT CURRENT_DATE,
  `statut` ENUM('Active', 'Suspendue', 'Fermée') DEFAULT 'Active',
  INDEX `idx_province` (`province`),
  INDEX `idx_territoire` (`territoire_commune`)
) ENGINE=InnoDB;

-- =====================================================
-- 2. TABLE ANNEE_SCOLAIRE
-- =====================================================
CREATE TABLE `annee_scolaire` (
  `id_annee` INT AUTO_INCREMENT PRIMARY KEY,
  `libelle` VARCHAR(20) NOT NULL UNIQUE, -- Ex: 2024-2025
  `date_debut` DATE NOT NULL,
  `date_fin` DATE NOT NULL,
  `active` BOOLEAN DEFAULT FALSE,
  INDEX `idx_active` (`active`)
) ENGINE=InnoDB;

-- =====================================================
-- 3. TABLE OPTION_ETUDE
-- =====================================================
CREATE TABLE `option_etude` (
  `id_option` INT AUTO_INCREMENT PRIMARY KEY,
  `nom_option` VARCHAR(100) NOT NULL UNIQUE, -- Ex: Littéraire, Scientifique, Commerciale
  `description` TEXT,
  INDEX `idx_nom_option` (`nom_option`)
) ENGINE=InnoDB;

-- =====================================================
-- 4. TABLE SECTION
-- =====================================================
CREATE TABLE `section` (
  `id_section` INT AUTO_INCREMENT PRIMARY KEY,
  `nom_section` VARCHAR(100) NOT NULL UNIQUE, -- Ex: Latin-Philosophie, Math-Physique
  `description` TEXT,
  INDEX `idx_nom_section` (`nom_section`)
) ENGINE=InnoDB;

-- =====================================================
-- 5. TABLE CLASSE
-- =====================================================
CREATE TABLE `classe` (
  `id_classe` INT AUTO_INCREMENT PRIMARY KEY,
  `niveau` VARCHAR(20) NOT NULL, -- Ex: 1ère, 2ème, 3ème, 4ème, 5ème, 6ème
  `cycle` ENUM('Primaire', 'Secondaire', 'Supérieur') NOT NULL,
  `id_option` INT,
  `id_section` INT,
  `capacite` INT DEFAULT 50,
  `id_ecole` INT NOT NULL,
  FOREIGN KEY (`id_option`) REFERENCES `option_etude`(`id_option`),
  FOREIGN KEY (`id_section`) REFERENCES `section`(`id_section`),
  FOREIGN KEY (`id_ecole`) REFERENCES `ecole`(`id_ecole`),
  INDEX `idx_niveau` (`niveau`),
  INDEX `idx_cycle` (`cycle`),
  INDEX `idx_ecole` (`id_ecole`)
) ENGINE=InnoDB;

-- =====================================================
-- 6. TABLE SALLE
-- =====================================================
CREATE TABLE `salle` (
  `id_salle` INT AUTO_INCREMENT PRIMARY KEY,
  `nom_salle` VARCHAR(50) NOT NULL, -- Ex: Salle A1, Labo Physique
  `type_salle` ENUM('Classe', 'Laboratoire', 'Bibliothèque', 'Salle informatique', 'Salle de sport') NOT NULL,
  `capacite` INT DEFAULT 40,
  `etat` ENUM('Bon', 'Moyen', 'Mauvais', 'En réparation') DEFAULT 'Bon',
  `id_ecole` INT NOT NULL,
  FOREIGN KEY (`id_ecole`) REFERENCES `ecole`(`id_ecole`),
  INDEX `idx_type_salle` (`type_salle`),
  INDEX `idx_ecole_salle` (`id_ecole`)
) ENGINE=InnoDB;

-- =====================================================
-- 7. TABLE ELEVE
-- =====================================================
CREATE TABLE `eleve` (
  `id_eleve` INT AUTO_INCREMENT PRIMARY KEY,
  `matricule` VARCHAR(20) UNIQUE NOT NULL,
  `nom` VARCHAR(100) NOT NULL,
  `postnom` VARCHAR(100) NOT NULL,
  `prenom` VARCHAR(100),
  `sexe` ENUM('M', 'F') NOT NULL,
  `date_naissance` DATE NOT NULL,
  `lieu_naissance` VARCHAR(100),
  `nationalite` VARCHAR(50) DEFAULT 'Congolaise',
  `adresse` TEXT,
  `photo` VARCHAR(255), -- Chemin vers la photo
  `statut` ENUM('Actif', 'Transféré', 'Diplômé', 'Exclu') DEFAULT 'Actif',
  `date_creation` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  INDEX `idx_matricule` (`matricule`),
  INDEX `idx_nom` (`nom`, `postnom`),
  INDEX `idx_statut` (`statut`)
) ENGINE=InnoDB;

-- =====================================================
-- 8. TABLE TUTEUR
-- =====================================================
CREATE TABLE `tuteur` (
  `id_tuteur` INT AUTO_INCREMENT PRIMARY KEY,
  `nom_complet` VARCHAR(200) NOT NULL,
  `lien_parental` ENUM('Père', 'Mère', 'Tuteur', 'Oncle', 'Tante', 'Grand-parent', 'Autre') NOT NULL,
  `telephone` VARCHAR(20),
  `email` VARCHAR(100),
  `profession` VARCHAR(100),
  `adresse` TEXT,
  INDEX `idx_nom_tuteur` (`nom_complet`),
  INDEX `idx_lien_parental` (`lien_parental`)
) ENGINE=InnoDB;

-- =====================================================
-- 9. TABLE INSCRIPTION
-- =====================================================
CREATE TABLE `inscription` (
  `id_inscription` INT AUTO_INCREMENT PRIMARY KEY,
  `id_eleve` INT NOT NULL,
  `id_classe` INT NOT NULL,
  `id_annee` INT NOT NULL,
  `date_inscription` DATE DEFAULT CURRENT_DATE,
  `type_inscription` ENUM('Nouvelle', 'Réinscription', 'Transfert') NOT NULL,
  `statut` ENUM('Confirmée', 'En attente', 'Annulée') DEFAULT 'Confirmée',
  FOREIGN KEY (`id_eleve`) REFERENCES `eleve`(`id_eleve`),
  FOREIGN KEY (`id_classe`) REFERENCES `classe`(`id_classe`),
  FOREIGN KEY (`id_annee`) REFERENCES `annee_scolaire`(`id_annee`),
  UNIQUE KEY `unique_eleve_classe_annee` (`id_eleve`, `id_classe`, `id_annee`),
  INDEX `idx_annee_inscription` (`id_annee`),
  INDEX `idx_statut_inscription` (`statut`)
) ENGINE=InnoDB;

-- =====================================================
-- 10. TABLE TRANSFERT
-- =====================================================
CREATE TABLE `transfert` (
  `id_transfert` INT AUTO_INCREMENT PRIMARY KEY,
  `id_eleve` INT NOT NULL,
  `ecole_origine` VARCHAR(200),
  `ecole_destination` VARCHAR(200),
  `date_transfert` DATE NOT NULL,
  `motif` TEXT,
  `statut` ENUM('Sortant', 'Entrant') NOT NULL,
  FOREIGN KEY (`id_eleve`) REFERENCES `eleve`(`id_eleve`),
  INDEX `idx_date_transfert` (`date_transfert`),
  INDEX `idx_statut_transfert` (`statut`)
) ENGINE=InnoDB;

-- =====================================================
-- 11. TABLE ENSEIGNANT
-- =====================================================
CREATE TABLE `enseignant` (
  `id_enseignant` INT AUTO_INCREMENT PRIMARY KEY,
  `nom_complet` VARCHAR(200) NOT NULL,
  `sexe` ENUM('M', 'F') NOT NULL,
  `grade` ENUM('A1', 'A2', 'A3', 'A4', 'A5', 'A6', 'A7', 'A8', 'A9', 'A10') NOT NULL,
  `specialite` VARCHAR(100),
  `telephone` VARCHAR(20),
  `email` VARCHAR(100),
  `statut` ENUM('Actif', 'En congé', 'Retraité', 'Suspendu') DEFAULT 'Actif',
  `date_embauche` DATE,
  INDEX `idx_nom_enseignant` (`nom_complet`),
  INDEX `idx_grade` (`grade`),
  INDEX `idx_specialite` (`specialite`)
) ENGINE=InnoDB;

-- =====================================================
-- 12. TABLE PERSONNEL
-- =====================================================
CREATE TABLE `personnel` (
  `id_personnel` INT AUTO_INCREMENT PRIMARY KEY,
  `nom_complet` VARCHAR(200) NOT NULL,
  `type_personnel` ENUM('Administratif', 'Technique', 'Service', 'Sécurité', 'Entretien') NOT NULL,
  `telephone` VARCHAR(20),
  `email` VARCHAR(100),
  `statut` ENUM('Actif', 'En congé', 'Retraité', 'Suspendu') DEFAULT 'Actif',
  `date_embauche` DATE,
  INDEX `idx_nom_personnel` (`nom_complet`),
  INDEX `idx_type_personnel` (`type_personnel`)
) ENGINE=InnoDB;

-- =====================================================
-- 13. TABLE FONCTION
-- =====================================================
CREATE TABLE `fonction` (
  `id_fonction` INT AUTO_INCREMENT PRIMARY KEY,
  `libelle` VARCHAR(100) NOT NULL UNIQUE, -- Ex: Proviseur, Censeur, Secrétaire
  `description` TEXT,
  INDEX `idx_libelle_fonction` (`libelle`)
) ENGINE=InnoDB;

-- =====================================================
-- 14. TABLE COURS
-- =====================================================
CREATE TABLE `cours` (
  `id_cours` INT AUTO_INCREMENT PRIMARY KEY,
  `nom_cours` VARCHAR(100) NOT NULL,
  `coefficient` DECIMAL(3,1) DEFAULT 1.0,
  `id_classe` INT NOT NULL,
  `id_enseignant` INT NOT NULL,
  `volume_horaire` INT DEFAULT 2, -- heures par semaine
  FOREIGN KEY (`id_classe`) REFERENCES `classe`(`id_classe`),
  FOREIGN KEY (`id_enseignant`) REFERENCES `enseignant`(`id_enseignant`),
  INDEX `idx_nom_cours` (`nom_cours`),
  INDEX `idx_classe_cours` (`id_classe`),
  INDEX `idx_enseignant_cours` (`id_enseignant`)
) ENGINE=InnoDB;

-- =====================================================
-- 15. TABLE HORAIRE
-- =====================================================
CREATE TABLE `horaire` (
  `id_horaire` INT AUTO_INCREMENT PRIMARY KEY,
  `jour` ENUM('Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi') NOT NULL,
  `heure_debut` TIME NOT NULL,
  `heure_fin` TIME NOT NULL,
  `id_cours` INT NOT NULL,
  `id_salle` INT NOT NULL,
  FOREIGN KEY (`id_cours`) REFERENCES `cours`(`id_cours`),
  FOREIGN KEY (`id_salle`) REFERENCES `salle`(`id_salle`),
  INDEX `idx_jour` (`jour`),
  INDEX `idx_heure` (`heure_debut`, `heure_fin`),
  INDEX `idx_salle_horaire` (`id_salle`)
) ENGINE=InnoDB;

-- =====================================================
-- 16. TABLE PRESENCE
-- =====================================================
CREATE TABLE `presence` (
  `id_presence` INT AUTO_INCREMENT PRIMARY KEY,
  `id_eleve` INT NOT NULL,
  `date_presence` DATE NOT NULL,
  `statut` ENUM('Présent', 'Absent', 'Retard', 'Justifié') NOT NULL DEFAULT 'Présent',
  `remarque` TEXT,
  FOREIGN KEY (`id_eleve`) REFERENCES `eleve`(`id_eleve`),
  UNIQUE KEY `unique_presence` (`id_eleve`, `date_presence`),
  INDEX `idx_date_presence` (`date_presence`),
  INDEX `idx_statut_presence` (`statut`)
) ENGINE=InnoDB;

-- =====================================================
-- 17. TABLE EXAMEN
-- =====================================================
CREATE TABLE `examen` (
  `id_examen` INT AUTO_INCREMENT PRIMARY KEY,
  `type_examen` ENUM('Interrogation', 'Devoir', 'Composition', 'Examen final') NOT NULL,
  `periode` VARCHAR(50) NOT NULL, -- Ex: 1er Trimestre, 2ème Trimestre
  `date_examen` DATE NOT NULL,
  `id_classe` INT NOT NULL,
  FOREIGN KEY (`id_classe`) REFERENCES `classe`(`id_classe`),
  INDEX `idx_type_examen` (`type_examen`),
  INDEX `idx_date_examen` (`date_examen`),
  INDEX `idx_periode` (`periode`)
) ENGINE=InnoDB;

-- =====================================================
-- 18. TABLE NOTE
-- =====================================================
CREATE TABLE `note` (
  `id_note` INT AUTO_INCREMENT PRIMARY KEY,
  `id_eleve` INT NOT NULL,
  `id_cours` INT NOT NULL,
  `id_examen` INT NOT NULL,
  `valeur` DECIMAL(5,2) NOT NULL, -- sur 20
  `observation` TEXT,
  FOREIGN KEY (`id_eleve`) REFERENCES `eleve`(`id_eleve`),
  FOREIGN KEY (`id_cours`) REFERENCES `cours`(`id_cours`),
  FOREIGN KEY (`id_examen`) REFERENCES `examen`(`id_examen`),
  UNIQUE KEY `unique_note` (`id_eleve`, `id_cours`, `id_examen`),
  INDEX `idx_valeur_note` (`valeur`),
  INDEX `idx_examen_note` (`id_examen`)
) ENGINE=InnoDB;

-- =====================================================
-- 19. TABLE BULLETIN
-- =====================================================
CREATE TABLE `bulletin` (
  `id_bulletin` INT AUTO_INCREMENT PRIMARY KEY,
  `id_eleve` INT NOT NULL,
  `id_classe` INT NOT NULL,
  `id_annee` INT NOT NULL,
  `trimestre` ENUM('1er', '2ème', '3ème') NOT NULL,
  `moyenne_generale` DECIMAL(5,2),
  `rang` INT,
  `nombre_eleves` INT,
  `decision` ENUM('Admis', 'Ajourné', 'Exclu', 'Passable', 'Assez bien', 'Bien', 'Très bien'),
  `appreciation_generale` TEXT,
  `date_emission` DATE DEFAULT CURRENT_DATE,
  FOREIGN KEY (`id_eleve`) REFERENCES `eleve`(`id_eleve`),
  FOREIGN KEY (`id_classe`) REFERENCES `classe`(`id_classe`),
  FOREIGN KEY (`id_annee`) REFERENCES `annee_scolaire`(`id_annee`),
  UNIQUE KEY `unique_bulletin` (`id_eleve`, `id_classe`, `id_annee`, `trimestre`),
  INDEX `idx_moyenne` (`moyenne_generale`),
  INDEX `idx_decision` (`decision`)
) ENGINE=InnoDB;

-- =====================================================
-- 20. TABLE FRAIS_SCOLAIRE
-- =====================================================
CREATE TABLE `frais_scolaire` (
  `id_frais` INT AUTO_INCREMENT PRIMARY KEY,
  `libelle` VARCHAR(100) NOT NULL, -- Ex: Frais d'inscription, Frais de scolarité
  `montant` DECIMAL(10,2) NOT NULL,
  `obligatoire` BOOLEAN DEFAULT TRUE,
  `id_classe` INT,
  `id_annee` INT NOT NULL,
  FOREIGN KEY (`id_classe`) REFERENCES `classe`(`id_classe`),
  FOREIGN KEY (`id_annee`) REFERENCES `annee_scolaire`(`id_annee`),
  INDEX `idx_libelle_frais` (`libelle`),
  INDEX `idx_annee_frais` (`id_annee`)
) ENGINE=InnoDB;

-- =====================================================
-- 21. TABLE PAIEMENT
-- =====================================================
CREATE TABLE `paiement` (
  `id_paiement` INT AUTO_INCREMENT PRIMARY KEY,
  `id_eleve` INT NOT NULL,
  `id_frais` INT NOT NULL,
  `montant_paye` DECIMAL(10,2) NOT NULL,
  `date_paiement` DATE DEFAULT CURRENT_DATE,
  `mode_paiement` ENUM('Espèces', 'Banque', 'Mobile Money', 'Virement') NOT NULL,
  `reference` VARCHAR(100), -- Numéro de référence bancaire ou mobile money
  `statut` ENUM('Complet', 'Partiel', 'En retard') DEFAULT 'Partiel',
  FOREIGN KEY (`id_eleve`) REFERENCES `eleve`(`id_eleve`),
  FOREIGN KEY (`id_frais`) REFERENCES `frais_scolaire`(`id_frais`),
  INDEX `idx_date_paiement` (`date_paiement`),
  INDEX `idx_statut_paiement` (`statut`),
  INDEX `idx_eleve_paiement` (`id_eleve`)
) ENGINE=InnoDB;

-- =====================================================
-- 22. TABLE DEPENSE
-- =====================================================
CREATE TABLE `depense` (
  `id_depense` INT AUTO_INCREMENT PRIMARY KEY,
  `libelle` VARCHAR(200) NOT NULL,
  `montant` DECIMAL(10,2) NOT NULL,
  `date_depense` DATE DEFAULT CURRENT_DATE,
  `responsable` VARCHAR(200), -- Nom du responsable de la dépense
  `type_depense` ENUM('Salaires', 'Fournitures', 'Entretien', 'Investissement', 'Autre') NOT NULL,
  `justificatif` VARCHAR(255), -- Chemin vers le justificatif
  INDEX `idx_date_depense` (`date_depense`),
  INDEX `idx_type_depense` (`type_depense`)
) ENGINE=InnoDB;

-- =====================================================
-- 23. TABLE BUDGET
-- =====================================================
CREATE TABLE `budget` (
  `id_budget` INT AUTO_INCREMENT PRIMARY KEY,
  `id_annee` INT NOT NULL,
  `libelle` VARCHAR(200) NOT NULL,
  `montant_prevu` DECIMAL(12,2) NOT NULL,
  `montant_realise` DECIMAL(12,2) DEFAULT 0,
  `type_budget` ENUM('Recettes', 'Dépenses') NOT NULL,
  FOREIGN KEY (`id_annee`) REFERENCES `annee_scolaire`(`id_annee`),
  INDEX `idx_annee_budget` (`id_annee`),
  INDEX `idx_type_budget` (`type_budget`)
) ENGINE=InnoDB;

-- =====================================================
-- 24. TABLE DISCIPLINE
-- =====================================================
CREATE TABLE `discipline` (
  `id_discipline` INT AUTO_INCREMENT PRIMARY KEY,
  `id_eleve` INT NOT NULL,
  `type_faute` ENUM('Mineure', 'Moyenne', 'Grave', 'Très grave') NOT NULL,
  `description` TEXT NOT NULL,
  `date_incident` DATE NOT NULL,
  `lieu_incident` VARCHAR(100),
  `temoins` TEXT,
  `signale_par` VARCHAR(200),
  FOREIGN KEY (`id_eleve`) REFERENCES `eleve`(`id_eleve`),
  INDEX `idx_date_incident` (`date_incident`),
  INDEX `idx_type_faute` (`type_faute`),
  INDEX `idx_eleve_discipline` (`id_eleve`)
) ENGINE=InnoDB;

-- =====================================================
-- 25. TABLE SANCTION
-- =====================================================
CREATE TABLE `sanction` (
  `id_sanction` INT AUTO_INCREMENT PRIMARY KEY,
  `id_discipline` INT NOT NULL,
  `type_sanction` ENUM('Avertissement', 'Blâme', 'Exclusion temporaire', 'Exclusion définitive', 'Travail supplémentaire') NOT NULL,
  `duree` INT, -- en jours pour les exclusions
  `decision` TEXT NOT NULL,
  `date_decision` DATE DEFAULT CURRENT_DATE,
  `date_execution` DATE,
  `responsable_decision` VARCHAR(200),
  FOREIGN KEY (`id_discipline`) REFERENCES `discipline`(`id_discipline`),
  INDEX `idx_type_sanction` (`type_sanction`),
  INDEX `idx_date_decision` (`date_decision`)
) ENGINE=InnoDB;

-- =====================================================
-- 26. TABLE LIVRE
-- =====================================================
CREATE TABLE `livre` (
  `id_livre` INT AUTO_INCREMENT PRIMARY KEY,
  `titre` VARCHAR(200) NOT NULL,
  `auteur` VARCHAR(200),
  `edition` VARCHAR(100),
  `annee` INT,
  `isbn` VARCHAR(20),
  `quantite_total` INT DEFAULT 1,
  `quantite_disponible` INT DEFAULT 1,
  `categorie` VARCHAR(100),
  INDEX `idx_titre` (`titre`),
  INDEX `idx_auteur` (`auteur`),
  INDEX `idx_categorie` (`categorie`)
) ENGINE=InnoDB;

-- =====================================================
-- 27. TABLE EMPRUNT
-- =====================================================
CREATE TABLE `emprunt` (
  `id_emprunt` INT AUTO_INCREMENT PRIMARY KEY,
  `id_livre` INT NOT NULL,
  `id_eleve` INT NOT NULL,
  `date_emprunt` DATE DEFAULT CURRENT_DATE,
  `date_retour_prevue` DATE NOT NULL,
  `date_retour_effective` DATE,
  `etat` ENUM('En cours', 'Retourné', 'En retard', 'Perdu') DEFAULT 'En cours',
  `penalite` DECIMAL(5,2) DEFAULT 0,
  FOREIGN KEY (`id_livre`) REFERENCES `livre`(`id_livre`),
  FOREIGN KEY (`id_eleve`) REFERENCES `eleve`(`id_eleve`),
  INDEX `idx_date_emprunt` (`date_emprunt`),
  INDEX `idx_etat_emprunt` (`etat`),
  INDEX `idx_eleve_emprunt` (`id_eleve`)
) ENGINE=InnoDB;

-- =====================================================
-- 28. TABLE MATERIEL
-- =====================================================
CREATE TABLE `materiel` (
  `id_materiel` INT AUTO_INCREMENT PRIMARY KEY,
  `designation` VARCHAR(200) NOT NULL,
  `categorie` ENUM('Mobilier', 'Informatique', 'Laboratoire', 'Sport', 'Bureau', 'Autre') NOT NULL,
  `quantite` INT DEFAULT 1,
  `etat` ENUM('Bon', 'Moyen', 'Mauvais', 'Hors service') DEFAULT 'Bon',
  `date_acquisition` DATE,
  `valeur_unitaire` DECIMAL(10,2),
  `localisation` VARCHAR(100),
  INDEX `idx_designation` (`designation`),
  INDEX `idx_categorie_materiel` (`categorie`),
  INDEX `idx_etat_materiel` (`etat`)
) ENGINE=InnoDB;

-- =====================================================
-- 29. TABLE INVENTAIRE
-- =====================================================
CREATE TABLE `inventaire` (
  `id_inventaire` INT AUTO_INCREMENT PRIMARY KEY,
  `id_materiel` INT NOT NULL,
  `date_inventaire` DATE DEFAULT CURRENT_DATE,
  `quantite_constatee` INT NOT NULL,
  `quantite_theorique` INT NOT NULL,
  `observation` TEXT,
  `responsable` VARCHAR(200),
  FOREIGN KEY (`id_materiel`) REFERENCES `materiel`(`id_materiel`),
  INDEX `idx_date_inventaire` (`date_inventaire`),
  INDEX `idx_responsable` (`responsable`)
) ENGINE=InnoDB;

-- =====================================================
-- 30. TABLE ROLE
-- =====================================================
CREATE TABLE `role` (
  `id_role` INT AUTO_INCREMENT PRIMARY KEY,
  `nom_role` VARCHAR(50) NOT NULL UNIQUE,
  `description` TEXT,
  INDEX `idx_nom_role` (`nom_role`)
) ENGINE=InnoDB;

-- =====================================================
-- 31. TABLE UTILISATEUR
-- =====================================================
CREATE TABLE `utilisateur` (
  `id_utilisateur` INT AUTO_INCREMENT PRIMARY KEY,
  `nom_utilisateur` VARCHAR(100) NOT NULL UNIQUE,
  `mot_de_passe` VARCHAR(255) NOT NULL,
  `id_role` INT NOT NULL,
  `statut` ENUM('Actif', 'Inactif', 'Suspendu') DEFAULT 'Actif',
  `date_creation` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `derniere_connexion` TIMESTAMP NULL,
  FOREIGN KEY (`id_role`) REFERENCES `role`(`id_role`),
  INDEX `idx_nom_utilisateur` (`nom_utilisateur`),
  INDEX `idx_statut_utilisateur` (`statut`)
) ENGINE=InnoDB;

-- =====================================================
-- 32. TABLE JOURNAL_ACTIVITE
-- =====================================================
CREATE TABLE `journal_activite` (
  `id_journal` INT AUTO_INCREMENT PRIMARY KEY,
  `id_utilisateur` INT NOT NULL,
  `action` VARCHAR(200) NOT NULL,
  `table_concernee` VARCHAR(50),
  `id_enregistrement` INT,
  `date_action` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `ip` VARCHAR(45),
  `navigateur` VARCHAR(200),
  FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateur`(`id_utilisateur`),
  INDEX `idx_date_action` (`date_action`),
  INDEX `idx_utilisateur_action` (`id_utilisateur`),
  INDEX `idx_table_concernee` (`table_concernee`)
) ENGINE=InnoDB;

-- =====================================================
-- TABLES DE LIAISON SUPPLÉMENTAIRES
-- =====================================================

-- Table de liaison entre élèves et tuteurs
CREATE TABLE `eleve_tuteur` (
  `id_eleve_tuteur` INT AUTO_INCREMENT PRIMARY KEY,
  `id_eleve` INT NOT NULL,
  `id_tuteur` INT NOT NULL,
  `priorite` ENUM('Principal', 'Secondaire') DEFAULT 'Principal',
  FOREIGN KEY (`id_eleve`) REFERENCES `eleve`(`id_eleve`),
  FOREIGN KEY (`id_tuteur`) REFERENCES `tuteur`(`id_tuteur`),
  UNIQUE KEY `unique_eleve_tuteur_priorite` (`id_eleve`, `id_tuteur`, `priorite`)
) ENGINE=InnoDB;

-- Table de liaison entre personnel et fonctions
CREATE TABLE `personnel_fonction` (
  `id_personnel_fonction` INT AUTO_INCREMENT PRIMARY KEY,
  `id_personnel` INT NOT NULL,
  `id_fonction` INT NOT NULL,
  `date_debut` DATE DEFAULT CURRENT_DATE,
  `date_fin` DATE,
  FOREIGN KEY (`id_personnel`) REFERENCES `personnel`(`id_personnel`),
  FOREIGN KEY (`id_fonction`) REFERENCES `fonction`(`id_fonction`)
) ENGINE=InnoDB;

-- =====================================================
-- INSERTION DES DONNÉES DE RÉFÉRENCE
-- =====================================================

-- Insertion des rôles
INSERT INTO `role` (`nom_role`, `description`) VALUES
('administrateur', 'Administrateur du système'),
('proviseur', 'Proviseur de l\'établissement'),
('censeur', 'Censeur responsable des études'),
('directeur_discipline', 'Directeur de la discipline'),
('enseignant', 'Enseignant'),
('eleve', 'Élève'),
('parent', 'Parent/Tuteur'),
('prefet', 'Préfet d\'élèves'),
('chef_classe', 'Chef de classe'),
('president_eleves', 'Président des élèves'),
('comite_parents', 'Membre du comité de parents'),
('secretaire', 'Secrétaire administratif'),
('bibliothecaire', 'Bibliothécaire'),
('comptable', 'Comptable'),
('surveillant', 'Surveillant général');

-- Insertion des options d'étude
INSERT INTO `option_etude` (`nom_option`, `description`) VALUES
('Littéraire', 'Option littéraire avec focus sur les langues et sciences humaines'),
('Scientifique', 'Option scientifique avec focus sur mathématiques et sciences'),
('Commerciale', 'Option commerciale avec focus sur gestion et économie'),
('Pédagogique', 'Option pédagogique pour futurs enseignants'),
('Artistique', 'Option artistique avec focus sur les arts plastiques et musique'),
('Technique', 'Option technique avec focus sur les technologies industrielles');

-- Insertion des sections
INSERT INTO `section` (`nom_section`, `description`) VALUES
('Latin-Philosophie', 'Section avec latin et philosophie'),
('Math-Physique', 'Section mathématiques et physique'),
('Math-Chimie', 'Section mathématiques et chimie'),
('Bio-Chimie', 'Section biologie et chimie'),
('Economie-Gestion', 'Section économie et gestion'),
('Lettres-Histoire', 'Section lettres et histoire'),
('Anglais-Littérature', 'Section anglais et littérature anglaise');

-- Insertion des fonctions
INSERT INTO `fonction` (`libelle`, `description`) VALUES
('Proviseur', 'Directeur général de l\'établissement'),
('Proviseur Adjoint', 'Adjoint au proviseur'),
('Censeur', 'Responsable pédagogique'),
('Censeur Adjoint', 'Adjoint au censeur'),
('Directeur Discipline', 'Responsable de la discipline'),
('Secrétaire Général', 'Secrétaire administratif'),
('Secrétaire Adjoint', 'Adjoint au secrétaire'),
('Comptable', 'Gestionnaire financier'),
('Bibliothécaire', 'Gestionnaire de la bibliothèque'),
('Surveillant Général', 'Surveillance générale des élèves'),
('Conseiller Pédagogique', 'Conseil pédagogique'),
('Responsable Laboratoire', 'Gestion des laboratoires');

-- =====================================================
-- VUES UTILES
-- =====================================================

-- Vue pour les informations complètes des élèves
CREATE VIEW `vue_eleves_complet` AS
SELECT 
  e.*,
  i.id_classe,
  i.id_annee,
  c.niveau,
  c.cycle,
  o.nom_option,
  s.nom_section,
  a.libelle as annee_scolaire
FROM eleve e
LEFT JOIN inscription i ON e.id_eleve = i.id_eleve AND i.statut = 'Confirmée'
LEFT JOIN classe c ON i.id_classe = c.id_classe
LEFT JOIN option_etude o ON c.id_option = o.id_option
LEFT JOIN section s ON c.id_section = s.id_section
LEFT JOIN annee_scolaire a ON i.id_annee = a.id_annee
WHERE e.statut = 'Actif';

-- Vue pour les statistiques de paiement
CREATE VIEW `vue_statistiques_paiement` AS
SELECT 
  e.id_eleve,
  e.nom,
  e.postnom,
  e.prenom,
  c.niveau,
  o.nom_option,
  SUM(f.montant) as total_frais,
  COALESCE(SUM(p.montant_paye), 0) as total_paye,
  (SUM(f.montant) - COALESCE(SUM(p.montant_paye), 0)) as solde,
  CASE 
    WHEN SUM(f.montant) = COALESCE(SUM(p.montant_paye), 0) THEN 'Complet'
    WHEN COALESCE(SUM(p.montant_paye), 0) > 0 THEN 'Partiel'
    ELSE 'Non payé'
  END as statut_paiement
FROM eleve e
JOIN inscription i ON e.id_eleve = i.id_eleve
JOIN classe c ON i.id_classe = c.id_classe
LEFT JOIN option_etude o ON c.id_option = o.id_option
LEFT JOIN frais_scolaire f ON i.id_classe = f.id_classe AND i.id_annee = f.id_annee
LEFT JOIN paiement p ON e.id_eleve = p.id_eleve AND f.id_frais = p.id_frais
WHERE i.statut = 'Confirmée'
GROUP BY e.id_eleve, e.nom, e.postnom, e.prenom, c.niveau, o.nom_option;

-- =====================================================
-- PROCÉDURES STOCKÉES UTILES
-- =====================================================

DELIMITER //

-- Procédure pour calculer la moyenne générale d'un élève
CREATE PROCEDURE `calculer_moyenne_eleve`(
  IN p_id_eleve INT,
  IN p_id_classe INT,
  IN p_id_annee INT,
  IN p_trimestre VARCHAR(10)
)
BEGIN
  DECLARE v_moyenne DECIMAL(5,2);
  
  SELECT AVG(n.valeur) INTO v_moyenne
  FROM note n
  JOIN cours c ON n.id_cours = c.id_cours
  JOIN examen e ON n.id_examen = e.id_examen
  WHERE n.id_eleve = p_id_eleve 
    AND c.id_classe = p_id_classe
    AND e.periode = p_trimestre;
  
  -- Mise à jour du bulletin
  UPDATE bulletin 
  SET moyenne_generale = v_moyenne
  WHERE id_eleve = p_id_eleve 
    AND id_classe = p_id_classe 
    AND id_annee = p_id_annee 
    AND trimestre = p_trimestre;
  
  SELECT v_moyenne as moyenne_calcullee;
END //

-- Procédure pour générer les statistiques annuelles
CREATE PROCEDURE `statistiques_annuelles`(
  IN p_id_annee INT
)
BEGIN
  SELECT 
    'Effectif total' as indicateur,
    COUNT(DISTINCT i.id_eleve) as valeur
  FROM inscription i
  WHERE i.id_annee = p_id_annee AND i.statut = 'Confirmée'
  
  UNION ALL
  
  SELECT 
    'Nombre de classes' as indicateur,
    COUNT(DISTINCT i.id_classe) as valeur
  FROM inscription i
  WHERE i.id_annee = p_id_annee AND i.statut = 'Confirmée'
  
  UNION ALL
  
  SELECT 
    'Recettes totales' as indicateur,
    COALESCE(SUM(p.montant_paye), 0) as valeur
  FROM paiement p
  JOIN inscription i ON p.id_eleve = i.id_eleve
  WHERE i.id_annee = p_id_annee
  
  UNION ALL
  
  SELECT 
    'Dépenses totales' as indicateur,
    COALESCE(SUM(d.montant), 0) as valeur
  FROM depense d
  WHERE YEAR(d.date_depense) = (SELECT date_debut FROM annee_scolaire WHERE id_annee = p_id_annee);
END //

DELIMITER ;

-- =====================================================
-- DÉCLENCHEURS (TRIGGERS)
-- =====================================================

DELIMITER //

-- Trigger pour mettre à jour la quantité disponible de livres lors d'un emprunt
CREATE TRIGGER `after_emprunt_insert` 
AFTER INSERT ON `emprunt`
FOR EACH ROW
BEGIN
  UPDATE livre 
  SET quantite_disponible = quantite_disponible - 1 
  WHERE id_livre = NEW.id_livre;
END //

-- Trigger pour mettre à jour la quantité disponible lors d'un retour
CREATE TRIGGER `after_emprunt_update_retour` 
AFTER UPDATE ON `emprunt`
FOR EACH ROW
BEGIN
  IF NEW.etat = 'Retourné' AND OLD.etat != 'Retourné' THEN
    UPDATE livre 
    SET quantite_disponible = quantite_disponible + 1 
    WHERE id_livre = NEW.id_livre;
  END IF;
END //

-- Trigger pour journaliser les activités sensibles
CREATE TRIGGER `after_utilisateur_insert` 
AFTER INSERT ON `utilisateur`
FOR EACH ROW
BEGIN
  INSERT INTO journal_activite (id_utilisateur, action, table_concernee, id_enregistrement)
  VALUES (NEW.id_utilisateur, 'Création utilisateur', 'utilisateur', NEW.id_utilisateur);
END //

DELIMITER ;

-- =====================================================
-- COMMENTAIRES FINAUX
-- =====================================================

-- La base de données est maintenant prête pour une école secondaire congolaise
-- Elle inclut toutes les fonctionnalités nécessaires :
-- - Gestion académique (élèves, classes, cours, notes, bulletins)
-- - Gestion administrative (personnel, fonctions, rôles)
-- - Gestion financière (frais, paiements, budget, dépenses)
-- - Gestion de la discipline (fautes, sanctions)
-- - Gestion des ressources (livres, matériel, inventaire)
-- - Sécurité et traçabilité (utilisateurs, rôles, journal)

-- Les données de référence sont insérées pour démarrer rapidement
-- Les vues et procédures facilitent les opérations courantes
-- Les triggers assurent la cohérence des données
