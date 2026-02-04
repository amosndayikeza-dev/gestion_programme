-- Mise à jour de la table utilisateurs pour ajouter les nouveaux rôles
-- Script SQL pour étendre les fonctionnalités du système de gestion

-- Supprimer l'ancienne table utilisateurs si elle existe
DROP TABLE IF EXISTS `utilisateurs`;

-- Recréer la table utilisateurs avec les nouveaux rôles
CREATE TABLE IF NOT EXISTS `utilisateurs` (
  `id_utilisateur` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  `role` enum('eleve','enseignant','inspecteur','administrateur','parent','prefet','directeur_discipline','proviseur','chef_classe','president_eleves','comite_parents') NOT NULL,
  `date_creation` datetime DEFAULT CURRENT_TIMESTAMP,
  `telephone` varchar(20) DEFAULT NULL,
  `adresse` text DEFAULT NULL,
  `statut` enum('actif','inactif','suspendu') DEFAULT 'actif',
  PRIMARY KEY (`id_utilisateur`),
  UNIQUE KEY `email` (`email`),
  KEY `role` (`role`),
  KEY `statut` (`statut`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table pour les informations spécifiques aux parents
CREATE TABLE IF NOT EXISTS `parent_info` (
  `id_parent_info` int NOT NULL AUTO_INCREMENT,
  `id_utilisateur` int NOT NULL,
  `profession` varchar(100) DEFAULT NULL,
  `telephone_urgence` varchar(20) DEFAULT NULL,
  `lien_parente` enum('pere','mere','tuteur','autre') DEFAULT NULL,
  `autorisation_retard` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id_parent_info`),
  UNIQUE KEY `id_utilisateur` (`id_utilisateur`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table pour les informations spécifiques aux préfets
CREATE TABLE IF NOT EXISTS `prefet_info` (
  `id_prefet_info` int NOT NULL AUTO_INCREMENT,
  `id_utilisateur` int NOT NULL,
  `classe_surveillee` int DEFAULT NULL,
  `niveau_autorite` enum('faible','moyen','eleve') DEFAULT 'moyen',
  `date_nomination` date DEFAULT NULL,
  PRIMARY KEY (`id_prefet_info`),
  UNIQUE KEY `id_utilisateur` (`id_utilisateur`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table pour les informations spécifiques au directeur de discipline
CREATE TABLE IF NOT EXISTS `directeur_discipline_info` (
  `id_directeur_discipline_info` int NOT NULL AUTO_INCREMENT,
  `id_utilisateur` int NOT NULL,
  `bureau` varchar(50) DEFAULT NULL,
  `telephone_pro` varchar(20) DEFAULT NULL,
  `specialite` varchar(100) DEFAULT NULL,
  `date_prise_fonction` date DEFAULT NULL,
  PRIMARY KEY (`id_directeur_discipline_info`),
  UNIQUE KEY `id_utilisateur` (`id_utilisateur`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table pour les informations spécifiques au proviseur
CREATE TABLE IF NOT EXISTS `proviseur_info` (
  `id_proviseur_info` int NOT NULL AUTO_INCREMENT,
  `id_utilisateur` int NOT NULL,
  `etablissement` varchar(150) DEFAULT NULL,
  `bureau` varchar(50) DEFAULT NULL,
  `telephone_pro` varchar(20) DEFAULT NULL,
  `date_debut_mandat` date DEFAULT NULL,
  `date_fin_mandat` date DEFAULT NULL,
  PRIMARY KEY (`id_proviseur_info`),
  UNIQUE KEY `id_utilisateur` (`id_utilisateur`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table pour les informations spécifiques aux chefs de classe
CREATE TABLE IF NOT EXISTS `chef_classe_info` (
  `id_chef_classe_info` int NOT NULL AUTO_INCREMENT,
  `id_utilisateur` int NOT NULL,
  `classe` int NOT NULL,
  `date_nomination` date DEFAULT NULL,
  `delegues` text DEFAULT NULL,
  PRIMARY KEY (`id_chef_classe_info`),
  UNIQUE KEY `id_utilisateur` (`id_utilisateur`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table pour les informations spécifiques au président des élèves
CREATE TABLE IF NOT EXISTS `president_eleves_info` (
  `id_president_eleves_info` int NOT NULL AUTO_INCREMENT,
  `id_utilisateur` int NOT NULL,
  `mandat` varchar(50) DEFAULT NULL,
  `vice_president` int DEFAULT NULL,
  `date_debut_mandat` date DEFAULT NULL,
  `date_fin_mandat` date DEFAULT NULL,
  PRIMARY KEY (`id_president_eleves_info`),
  UNIQUE KEY `id_utilisateur` (`id_utilisateur`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table pour les informations spécifiques au comité de parents
CREATE TABLE IF NOT EXISTS `comite_parents_info` (
  `id_comite_parents_info` int NOT NULL AUTO_INCREMENT,
  `id_utilisateur` int NOT NULL,
  `poste` enum('president','vice-president','secretaire','tresorier','membre') DEFAULT 'membre',
  `mandat` varchar(50) DEFAULT NULL,
  `specialites` text DEFAULT NULL,
  `date_debut_mandat` date DEFAULT NULL,
  PRIMARY KEY (`id_comite_parents_info`),
  UNIQUE KEY `id_utilisateur` (`id_utilisateur`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table pour les relations parent-enfant
CREATE TABLE IF NOT EXISTS `parent_enfant` (
  `id_parent_enfant` int NOT NULL AUTO_INCREMENT,
  `id_parent` int NOT NULL,
  `id_enfant` int NOT NULL,
  `lien_parente` enum('pere','mere','tuteur','autre') NOT NULL,
  `autorisation_contact` tinyint(1) DEFAULT 1,
  `date_ajout` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_parent_enfant`),
  KEY `id_parent` (`id_parent`),
  KEY `id_enfant` (`id_enfant`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table pour les permissions étendues
CREATE TABLE IF NOT EXISTS `permissions_role` (
  `id_permission` int NOT NULL AUTO_INCREMENT,
  `role` varchar(50) NOT NULL,
  `permission` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  PRIMARY KEY (`id_permission`),
  UNIQUE KEY `role_permission` (`role`,`permission`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Insertion des permissions pour chaque rôle
INSERT INTO `permissions_role` (`role`, `permission`, `description`) VALUES
('parent', 'view_child_grades', 'Voir les notes de ses enfants'),
('parent', 'view_child_attendance', 'Voir les absences de ses enfants'),
('parent', 'contact_teachers', 'Contacter les enseignants'),
('parent', 'participate_meetings', 'Participer aux réunions parents-professeurs'),

('prefet', 'manage_class_discipline', 'Gérer la discipline de sa classe'),
('prefet', 'report_issues', 'Signaler des problèmes'),
('prefet', 'represent_class', 'Représenter sa classe'),
('prefet', 'organize_activities', 'Organiser des activités de classe'),

('directeur_discipline', 'manage_discipline', 'Gérer la discipline de l\'établissement'),
('directeur_discipline', 'view_student_records', 'Consulter les dossiers des élèves'),
('directeur_discipline', 'sanction_students', 'Sanctionner les élèves'),
('directeur_discipline', 'manage_conseil', 'Gérer le conseil de discipline'),

('proviseur', 'manage_teachers', 'Gérer le personnel enseignant'),
('proviseur', 'manage_students', 'Gérer les élèves'),
('proviseur', 'view_reports', 'Consulter tous les rapports'),
('proviseur', 'manage_discipline', 'Gérer la discipline'),
('proviseur', 'manage_budget', 'Gérer le budget'),
('proviseur', 'represent_school', 'Représenter l\'établissement'),

('chef_classe', 'represent_class', 'Représenter la classe'),
('chef_classe', 'organize_activities', 'Organiser des activités'),
('chef_classe', 'communicate_admin', 'Communiquer avec l\'administration'),
('chef_classe', 'manage_class_issues', 'Gérer les problèmes de classe'),

('president_eleves', 'represent_students', 'Représenter tous les élèves'),
('president_eleves', 'organize_events', 'Organiser des événements'),
('president_eleves', 'negotiate_admin', 'Négocier avec l\'administration'),
('president_eleves', 'manage_student_budget', 'Gérer le budget étudiant'),
('president_eleves', 'propose_improvements', 'Proposer des améliorations'),

('comite_parents', 'represent_parents', 'Représenter les parents'),
('comite_parents', 'participate_meetings', 'Participer aux réunions'),
('comite_parents', 'propose_projects', 'Proposer des projets'),
('comite_parents', 'help_organization', 'Aider à l\'organisation'),
('comite_parents', 'collect_funds', 'Collecter des fonds');

-- Insertion des utilisateurs par défaut pour tester
INSERT INTO `utilisateurs` (`id_utilisateur`, `nom`, `prenom`, `email`, `mot_de_passe`, `role`, `date_creation`) VALUES
(1, 'Admin', 'System', 'admin@ecole.com', '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918', 'administrateur', '2025-12-28 10:29:13'),
(2, 'Dupont', 'Jean', 'jean.dupont@ecole.com', '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918', 'eleve', '2025-12-28 10:29:13'),
(3, 'Martin', 'Sophie', 'sophie.martin@ecole.com', '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918', 'parent', '2025-12-28 10:30:00'),
(4, 'Petit', 'Lucas', 'lucas.petit@ecole.com', '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918', 'prefet', '2025-12-28 10:31:00'),
(5, 'Durand', 'Marie', 'marie.durand@ecole.com', '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918', 'directeur_discipline', '2025-12-28 10:32:00'),
(6, 'Lefevre', 'Pierre', 'pierre.lefevre@ecole.com', '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918', 'proviseur', '2025-12-28 10:33:00'),
(7, 'Bernard', 'Claire', 'claire.bernard@ecole.com', '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918', 'chef_classe', '2025-12-28 10:34:00'),
(8, 'Rousseau', 'Thomas', 'thomas.rousseau@ecole.com', '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918', 'president_eleves', '2025-12-28 10:35:00'),
(9, 'Girard', 'Isabelle', 'isabelle.girard@ecole.com', '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918', 'comite_parents', '2025-12-28 10:36:00');
