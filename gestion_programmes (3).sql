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
) ENGINE=MyISAM AUTO_INCREMENT=169 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `activites`
--

INSERT INTO `activites` (`id_activite`, `id_utilisateur`, `nom_utilisateur`, `action`, `details`, `date_activite`, `statut`) VALUES
(1, 1, 'System Admin', 'Rafraîchissement', 'Dashboard rafraîchi', '2025-12-28 10:46:11', 'Succès'),
(2, 1, 'System Admin', 'Rafraîchissement', 'Dashboard rafraîchi', '2025-12-28 10:46:16', 'Succès'),
(3, 1, 'System Admin', 'Rafraîchissement', 'Dashboard rafraîchi', '2025-12-28 10:47:00', 'Succès'),
(4, 1, 'System Admin', 'Déconnexion', 'Utilisateur déconnecté', '2025-12-28 10:47:04', 'Succès'),
(5, 1, 'System Admin', 'Ajout d\'utilisateur', 'Ouverture du formulaire', '2025-12-28 10:47:45', 'Succès'),
(6, 1, 'System Admin', 'Ajout d\'utilisateur', 'Ouverture du formulaire', '2025-12-28 11:07:22', 'Succès'),
(7, 1, 'System Admin', 'Déconnexion', 'Utilisateur déconnecté', '2025-12-28 11:09:18', 'Succès'),
(8, 1, 'System Admin', 'Ajout d\'utilisateur', 'Ouverture du formulaire', '2025-12-28 12:12:22', 'Succès'),
(9, 1, 'System Admin', 'Déconnexion', 'Utilisateur déconnecté', '2025-12-28 12:13:38', 'Succès'),
(10, 1, 'System Admin', 'Ajout d\'utilisateur', 'Ouverture du formulaire', '2025-12-28 12:18:38', 'Succès'),
(11, 1, 'System Admin', 'Gestion cours', 'Page de gestion des cours ouverte', '2025-12-28 12:32:50', 'Succès'),
(12, 1, 'System Admin', 'Consultation utilisateurs', 'Liste des utilisateurs affichée', '2025-12-28 12:40:18', 'Succès'),
(13, 1, 'System Admin', 'Gestion classes', 'Page de gestion des classes ouverte', '2025-12-28 12:42:07', 'Succès'),
(14, 1, 'System Admin', 'Déconnexion', 'Utilisateur déconnecté', '2025-12-28 12:42:44', 'Succès'),
(15, 1, 'System Admin', 'Gestion cours', 'Page de gestion des cours ouverte', '2025-12-28 13:26:14', 'Succès'),
(16, 1, 'System Admin', 'Gestion classes', 'Page de gestion des classes ouverte', '2025-12-28 13:26:51', 'Succès'),
(17, 1, 'System Admin', 'Consultation utilisateurs', 'Liste des utilisateurs affichée', '2025-12-28 13:27:49', 'Succès'),
(18, 1, 'System Admin', 'Gestion cours', 'Page de gestion des cours ouverte', '2025-12-28 13:27:55', 'Succès'),
(19, 1, 'System Admin', 'Gestion classes', 'Page de gestion des classes ouverte', '2025-12-28 13:27:57', 'Succès'),
(20, 1, 'System Admin', 'Gestion établissements', 'Page de gestion des établissements ouverte', '2025-12-28 13:28:08', 'Succès'),
(21, 1, 'System Admin', 'Consultation utilisateurs', 'Liste des utilisateurs affichée', '2025-12-28 13:28:38', 'Succès'),
(22, 1, 'System Admin', 'Déconnexion', 'Utilisateur déconnecté', '2025-12-28 13:28:49', 'Succès'),
(23, 1, 'System Admin', 'Déconnexion', 'Utilisateur déconnecté', '2025-12-28 13:59:21', 'Succès'),
(24, 1, 'System Admin', 'Gestion classes', 'Page de gestion des classes ouverte', '2025-12-28 14:13:34', 'Succès'),
(25, 1, 'System Admin', 'Gestion établissements', 'Page de gestion des établissements ouverte', '2025-12-28 14:37:38', 'Succès'),
(26, 1, 'System Admin', 'Gestion classes', 'Page de gestion des classes ouverte', '2025-12-28 14:37:50', 'Succès'),
(27, 1, 'System Admin', 'Gestion cours', 'Page de gestion des cours ouverte', '2025-12-28 14:37:56', 'Succès'),
(28, 1, 'System Admin', 'Consultation utilisateurs', 'Liste des utilisateurs affichée', '2025-12-28 14:38:12', 'Succès'),
(29, 1, 'System Admin', 'Consultation utilisateurs', 'Liste des utilisateurs affichée', '2025-12-28 14:38:37', 'Succès'),
(30, 1, 'System Admin', 'Consultation utilisateurs', 'Liste des utilisateurs affichée', '2025-12-28 14:38:39', 'Succès'),
(31, 1, 'System Admin', 'Gestion cours', 'Page de gestion des cours ouverte', '2025-12-28 14:38:40', 'Succès'),
(32, 1, 'System Admin', 'Gestion classes', 'Page de gestion des classes ouverte', '2025-12-28 14:38:44', 'Succès'),
(33, 1, 'System Admin', 'Ajout d\'utilisateur', 'Ouverture du formulaire', '2025-12-28 14:39:11', 'Succès'),
(34, 1, 'System Admin', 'Ajout d\'utilisateur', 'Ouverture du formulaire', '2025-12-28 14:51:39', 'Succès'),
(35, 1, 'System Admin', 'Gestion classes', 'Page de gestion des classes ouverte', '2025-12-28 15:01:01', 'Succès'),
(36, 1, 'System Admin', 'Consultation utilisateurs', 'Liste des utilisateurs affichée', '2025-12-28 15:01:19', 'Succès'),
(37, 1, 'System Admin', 'Gestion cours', 'Page de gestion des cours ouverte', '2025-12-28 15:01:23', 'Succès'),
(38, 1, 'System Admin', 'Gestion classes', 'Page de gestion des classes ouverte', '2025-12-28 15:01:24', 'Succès'),
(39, 1, 'System Admin', 'Gestion établissements', 'Page de gestion des établissements ouverte', '2025-12-28 15:01:26', 'Succès'),
(40, 1, 'System Admin', 'Gestion cours', 'Page de gestion des cours ouverte', '2025-12-28 15:01:38', 'Succès'),
(41, 1, 'System Admin', 'Consultation utilisateurs', 'Liste des utilisateurs affichée', '2025-12-28 15:06:05', 'Succès'),
(42, 1, 'System Admin', 'Gestion cours', 'Page de gestion des cours ouverte', '2025-12-28 15:06:09', 'Succès'),
(43, 1, 'System Admin', 'Gestion classes', 'Page de gestion des classes ouverte', '2025-12-28 15:06:11', 'Succès'),
(44, 1, 'System Admin', 'Gestion établissements', 'Page de gestion des établissements ouverte', '2025-12-28 15:06:15', 'Succès'),
(45, 1, 'System Admin', 'Consultation utilisateurs', 'Liste des utilisateurs affichée', '2025-12-28 15:06:23', 'Succès'),
(46, 1, 'System Admin', 'Consultation utilisateurs', 'Liste des utilisateurs affichée', '2025-12-28 15:07:55', 'Succès'),
(47, 1, 'System Admin', 'Gestion cours', 'Page de gestion des cours ouverte', '2025-12-28 15:07:57', 'Succès'),
(48, 1, 'System Admin', 'Gestion classes', 'Page de gestion des classes ouverte', '2025-12-28 15:07:59', 'Succès'),
(49, 1, 'System Admin', 'Ajout d\'utilisateur', 'Ouverture du formulaire', '2025-12-28 15:08:43', 'Succès'),
(50, 1, 'System Admin', 'Gestion établissements', 'Page de gestion des établissements ouverte', '2025-12-29 12:08:36', 'Succès'),
(51, 1, 'System Admin', 'Gestion classes', 'Page de gestion des classes ouverte', '2025-12-29 12:08:44', 'Succès'),
(52, 1, 'System Admin', 'Gestion cours', 'Page de gestion des cours ouverte', '2025-12-29 12:08:47', 'Succès'),
(53, 1, 'System Admin', 'Consultation utilisateurs', 'Liste des utilisateurs affichée', '2025-12-29 12:08:49', 'Succès'),
(54, 1, 'System Admin', 'Gestion établissements', 'Page de gestion des établissements ouverte', '2025-12-29 12:09:33', 'Succès'),
(55, 1, 'System Admin', 'Consultation utilisateurs', 'Liste des utilisateurs affichée', '2025-12-29 12:09:34', 'Succès'),
(56, 1, 'System Admin', 'Consultation utilisateurs', 'Liste des utilisateurs affichée', '2025-12-29 12:11:04', 'Succès'),
(57, 1, 'System Admin', 'Gestion cours', 'Page de gestion des cours ouverte', '2025-12-29 12:11:07', 'Succès'),
(58, 1, 'System Admin', 'Gestion classes', 'Page de gestion des classes ouverte', '2025-12-29 12:11:09', 'Succès'),
(59, 1, 'System Admin', 'Gestion cours', 'Page de gestion des cours ouverte', '2025-12-29 12:12:28', 'Succès'),
(60, 1, 'System Admin', 'Consultation utilisateurs', 'Liste des utilisateurs affichée', '2025-12-29 12:12:30', 'Succès'),
(61, 1, 'System Admin', 'Gestion classes', 'Page de gestion des classes ouverte', '2025-12-29 12:12:31', 'Succès'),
(62, 1, 'System Admin', 'Gestion établissements', 'Page de gestion des établissements ouverte', '2025-12-29 12:12:32', 'Succès'),
(63, 1, 'System Admin', 'Gestion établissements', 'Page de gestion des établissements ouverte', '2025-12-29 12:12:37', 'Succès'),
(64, 1, 'System Admin', 'Gestion classes', 'Page de gestion des classes ouverte', '2025-12-29 12:12:39', 'Succès'),
(65, 1, 'System Admin', 'Gestion cours', 'Page de gestion des cours ouverte', '2025-12-29 12:12:40', 'Succès'),
(66, 1, 'System Admin', 'Consultation utilisateurs', 'Liste des utilisateurs affichée', '2025-12-29 12:12:42', 'Succès'),
(67, 1, 'System Admin', 'Déconnexion', 'Utilisateur déconnecté', '2025-12-29 12:31:43', 'Succès'),
(68, 1, 'System Admin', 'Consultation utilisateurs', 'Liste des utilisateurs affichée', '2025-12-29 14:11:51', 'Succès'),
(69, 1, 'System Admin', 'Gestion établissements', 'Page de gestion des établissements ouverte', '2025-12-29 14:12:23', 'Succès'),
(70, 1, 'System Admin', 'Gestion établissements', 'Page de gestion des établissements ouverte', '2025-12-29 14:36:41', 'Succès'),
(71, 1, 'System Admin', 'Consultation utilisateurs', 'Liste des utilisateurs affichée', '2025-12-29 14:38:00', 'Succès'),
(72, 1, 'System Admin', 'Création utilisateur', 'Nouvel utilisateur créé: Marc Kalenga', '2025-12-29 14:39:30', 'Succès'),
(73, 1, 'System Admin', 'Consultation', 'Consultation des détails de Marc Kalenga', '2025-12-29 14:41:18', 'Succès'),
(74, 1, 'System Admin', 'Déconnexion', 'Utilisateur déconnecté', '2025-12-29 14:43:34', 'Succès'),
(75, 3, 'Marc Kalenga', 'Consultation utilisateurs', 'Liste des utilisateurs affichée', '2025-12-29 14:44:26', 'Succès'),
(76, 3, 'Marc Kalenga', 'Consultation utilisateurs', 'Liste des utilisateurs affichée', '2025-12-29 14:44:58', 'Succès'),
(77, 3, 'Marc Kalenga', 'Gestion cours', 'Page de gestion des cours ouverte', '2025-12-29 14:45:01', 'Succès'),
(78, 3, 'Marc Kalenga', 'Gestion classes', 'Page de gestion des classes ouverte', '2025-12-29 14:45:04', 'Succès'),
(79, 3, 'Marc Kalenga', 'Gestion établissements', 'Page de gestion des établissements ouverte', '2025-12-29 15:11:10', 'Succès'),
(80, 1, 'System Admin', 'Consultation utilisateurs', 'Liste des utilisateurs affichée', '2025-12-29 15:26:51', 'Succès'),
(81, 1, 'System Admin', 'Gestion classes', 'Page de gestion des classes ouverte', '2025-12-29 15:26:58', 'Succès'),
(82, 1, 'System Admin', 'Consultation utilisateurs', 'Liste des utilisateurs affichée', '2025-12-29 15:30:34', 'Succès'),
(83, 1, 'System Admin', 'Gestion établissements', 'Page de gestion des établissements ouverte', '2025-12-29 15:31:10', 'Succès'),
(84, 1, 'System Admin', 'Gestion établissements', 'Page de gestion des établissements ouverte', '2025-12-29 15:31:30', 'Succès'),
(85, 1, 'System Admin', 'Gestion classes', 'Page de gestion des classes ouverte', '2025-12-29 15:31:31', 'Succès'),
(86, 1, 'System Admin', 'Gestion cours', 'Page de gestion des cours ouverte', '2025-12-29 15:32:01', 'Succès'),
(87, 1, 'System Admin', 'Consultation utilisateurs', 'Liste des utilisateurs affichée', '2025-12-29 15:32:03', 'Succès'),
(88, 1, 'System Admin', 'Consultation utilisateurs', 'Liste des utilisateurs affichée', '2025-12-29 15:35:35', 'Succès'),
(89, 1, 'System Admin', 'Gestion classes', 'Page de gestion des classes ouverte', '2025-12-29 15:36:01', 'Succès'),
(90, 1, 'System Admin', 'Gestion cours', 'Page de gestion des cours ouverte', '2025-12-29 15:39:26', 'Succès'),
(91, 1, 'System Admin', 'Gestion classes', 'Page de gestion des classes ouverte', '2025-12-29 15:39:29', 'Succès'),
(92, 1, 'System Admin', 'Gestion classes', 'Page de gestion des classes ouverte', '2025-12-29 15:58:21', 'Succès'),
(93, 1, 'System Admin', 'Gestion classes', 'Page de gestion des classes ouverte', '2025-12-29 16:09:05', 'Succès'),
(94, 1, 'System Admin', 'Gestion classes', 'Page de gestion des classes ouverte', '2025-12-29 16:18:37', 'Succès'),
(95, 1, 'System Admin', 'Gestion cours', 'Page de gestion des cours ouverte', '2025-12-29 16:27:08', 'Succès'),
(96, 1, 'System Admin', 'Gestion établissements', 'Page de gestion des établissements ouverte', '2025-12-29 16:27:11', 'Succès'),
(97, 1, 'System Admin', 'Gestion cours', 'Page de gestion des cours ouverte', '2025-12-29 16:27:59', 'Succès'),
(98, 1, 'System Admin', 'Gestion établissements', 'Page de gestion des établissements ouverte', '2025-12-29 16:34:47', 'Succès'),
(99, 1, 'System Admin', 'Consultation utilisateurs', 'Liste des utilisateurs affichée', '2025-12-29 16:41:46', 'Succès'),
(100, 1, 'System Admin', 'Gestion établissements', 'Page de gestion des établissements ouverte', '2025-12-29 16:42:10', 'Succès'),
(101, 1, 'System Admin', 'Gestion cours', 'Page de gestion des cours ouverte', '2025-12-29 16:42:17', 'Succès'),
(102, 1, 'System Admin', 'Gestion cours', 'Page de gestion des cours ouverte', '2025-12-29 16:54:52', 'Succès'),
(103, 1, 'System Admin', 'Gestion cours', 'Page de gestion des cours ouverte', '2025-12-29 17:43:17', 'Succès'),
(104, 1, 'System Admin', 'Consultation utilisateurs', 'Liste des utilisateurs affichée', '2025-12-29 17:48:23', 'Succès'),
(105, 1, 'System Admin', 'Gestion cours', 'Page de gestion des cours ouverte', '2025-12-29 17:48:25', 'Succès'),
(106, 1, 'System Admin', 'Gestion cours', 'Page de gestion des cours ouverte', '2025-12-29 17:52:25', 'Succès'),
(107, 1, 'System Admin', 'Consultation utilisateurs', 'Liste des utilisateurs affichée', '2025-12-29 17:56:29', 'Succès'),
(108, 1, 'System Admin', 'Gestion cours', 'Page de gestion des cours ouverte', '2025-12-29 17:56:32', 'Succès'),
(109, 1, 'System Admin', 'Gestion cours', 'Page de gestion des cours ouverte', '2025-12-29 18:08:46', 'Succès'),
(110, 1, 'System Admin', 'Gestion cours', 'Page de gestion des cours ouverte', '2025-12-29 18:12:59', 'Succès'),
(111, 1, 'System Admin', 'Gestion cours', 'Page de gestion des cours ouverte', '2025-12-29 18:14:58', 'Succès'),
(112, 1, 'System Admin', 'Gestion cours', 'Page de gestion des cours ouverte', '2025-12-29 18:16:36', 'Succès'),
(113, 1, 'System Admin', 'Gestion cours', 'Page de gestion des cours ouverte', '2025-12-29 18:25:38', 'Succès'),
(114, 1, 'System Admin', 'Gestion cours', 'Page de gestion des cours ouverte', '2025-12-29 18:31:38', 'Succès'),
(115, 1, 'System Admin', 'Gestion cours', 'Page de gestion des cours ouverte', '2025-12-29 18:35:52', 'Succès'),
(116, 1, 'System Admin', 'Ajout cours', 'Formulaire d\'ajout de cours ouvert', '2025-12-29 19:13:41', 'Succès'),
(117, 1, 'System Admin', 'Consultation utilisateurs', 'Liste des utilisateurs affichée', '2025-12-29 19:14:03', 'Succès'),
(118, 1, 'System Admin', 'Gestion cours', 'Page de gestion des cours ouverte', '2025-12-29 19:14:06', 'Succès'),
(119, 1, 'System Admin', 'Gestion classes', 'Page de gestion des classes ouverte', '2025-12-29 19:14:09', 'Succès'),
(120, 1, 'System Admin', 'Gestion établissements', 'Page de gestion des établissements ouverte', '2025-12-29 19:14:13', 'Succès'),
(121, 1, 'System Admin', 'Déconnexion', 'Utilisateur déconnecté', '2025-12-29 19:41:44', 'Succès'),
(122, 1, 'System Admin', 'Gestion classes', 'Page de gestion des classes ouverte', '2025-12-30 13:38:30', 'Succès'),
(123, 1, 'System Admin', 'Consultation utilisateurs', 'Liste des utilisateurs affichée', '2025-12-30 14:03:41', 'Succès'),
(124, 1, 'System Admin', 'Gestion cours', 'Page de gestion des cours ouverte', '2025-12-30 14:03:44', 'Succès'),
(125, 1, 'System Admin', 'Gestion classes', 'Page de gestion des classes ouverte', '2025-12-30 14:03:48', 'Succès'),
(126, 1, 'System Admin', 'Gestion matières', 'Page de gestion des matières ouverte', '2025-12-30 14:20:51', 'Succès'),
(127, 1, 'System Admin', 'Gestion matières', 'Page de gestion des matières ouverte', '2025-12-30 16:47:42', 'Succès'),
(128, 1, 'System Admin', 'Gestion matières', 'Page de gestion des matières ouverte', '2025-12-30 16:59:02', 'Succès'),
(129, 1, 'System Admin', 'Gestion matières', 'Page de gestion des matières ouverte', '2025-12-30 17:04:20', 'Succès'),
(130, 1, 'System Admin', 'Gestion programmes', 'Page de gestion des programmes ouverte', '2025-12-30 17:04:28', 'Succès'),
(131, 1, 'System Admin', 'Gestion programmes', 'Page de gestion des programmes ouverte', '2025-12-30 17:05:27', 'Succès'),
(132, 1, 'System Admin', 'Gestion matières', 'Page de gestion des matières ouverte', '2025-12-30 17:05:30', 'Succès'),
(133, 1, 'System Admin', 'Gestion matières', 'Page de gestion des matières ouverte', '2025-12-30 17:10:53', 'Succès'),
(134, 1, 'System Admin', 'Gestion matières', 'Page de gestion des matières ouverte', '2025-12-30 17:18:13', 'Succès'),
(135, 1, 'System Admin', 'Gestion programmes', 'Page de gestion des programmes ouverte', '2025-12-30 17:18:20', 'Succès'),
(136, 1, 'System Admin', 'Gestion matières', 'Page de gestion des matières ouverte', '2025-12-30 17:18:25', 'Succès'),
(137, 1, 'System Admin', 'Gestion matières', 'Page de gestion des matières ouverte', '2025-12-30 17:20:09', 'Succès'),
(138, 1, 'System Admin', 'Gestion programmes', 'Page de gestion des programmes ouverte', '2025-12-30 17:20:11', 'Succès'),
(139, 1, 'System Admin', 'Gestion matières', 'Page de gestion des matières ouverte', '2025-12-30 17:20:18', 'Succès'),
(140, 1, 'System Admin', 'Gestion matières', 'Page de gestion des matières ouverte', '2025-12-30 17:58:57', 'Succès'),
(141, 1, 'System Admin', 'Gestion matières', 'Page de gestion des matières ouverte', '2025-12-30 18:08:33', 'Succès'),
(142, 3, 'Marc Kalenga', 'Consultation utilisateurs', 'Liste des utilisateurs affichée', '2025-12-31 10:11:08', 'Succès'),
(143, 3, 'Marc Kalenga', 'Consultation', 'Consultation des détails de Marc Kalenga', '2025-12-31 10:11:14', 'Succès'),
(144, 3, 'Marc Kalenga', 'Gestion établissements', 'Page de gestion des établissements ouverte', '2025-12-31 10:13:24', 'Succès'),
(145, 3, 'Marc Kalenga', 'Gestion classes', 'Page de gestion des classes ouverte', '2025-12-31 10:15:16', 'Succès'),
(146, 3, 'Marc Kalenga', 'Gestion matières', 'Page de gestion des matières ouverte', '2025-12-31 10:17:20', 'Succès'),
(147, 3, 'Marc Kalenga', 'Gestion programmes', 'Page de gestion des programmes ouverte', '2025-12-31 10:20:39', 'Succès'),
(148, 1, 'System Admin', 'Gestion matières', 'Page de gestion des matières ouverte', '2025-12-31 12:01:35', 'Succès'),
(149, 1, 'System Admin', 'Gestion programmes', 'Page de gestion des programmes ouverte', '2025-12-31 12:01:43', 'Succès'),
(150, 1, 'System Admin', 'Gestion programmes', 'Page de gestion des programmes ouverte', '2025-12-31 12:02:19', 'Succès'),
(151, 1, 'System Admin', 'Gestion matières', 'Page de gestion des matières ouverte', '2025-12-31 12:02:21', 'Succès'),
(152, 1, 'System Admin', 'Consultation utilisateurs', 'Liste des utilisateurs affichée', '2025-12-31 12:02:27', 'Succès'),
(153, 1, 'System Admin', 'Gestion cours', 'Page de gestion des cours ouverte', '2025-12-31 12:19:08', 'Succès'),
(154, 1, 'System Admin', 'Gestion classes', 'Page de gestion des classes ouverte', '2025-12-31 12:19:25', 'Succès'),
(155, 1, 'System Admin', 'Gestion programmes', 'Page de gestion des programmes ouverte', '2025-12-31 12:19:37', 'Succès'),
(156, 1, 'System Admin', 'Gestion matières', 'Page de gestion des matières ouverte', '2025-12-31 12:20:20', 'Succès'),
(157, 1, 'System Admin', 'Gestion programmes', 'Page de gestion des programmes ouverte', '2025-12-31 12:23:13', 'Succès'),
(158, 1, 'System Admin', 'Gestion cours', 'Page de gestion des cours ouverte', '2025-12-31 12:23:54', 'Succès'),
(159, 1, 'System Admin', 'Gestion programmes', 'Page de gestion des programmes ouverte', '2025-12-31 12:25:14', 'Succès'),
(160, 1, 'System Admin', 'Gestion classes', 'Page de gestion des classes ouverte', '2025-12-31 12:25:32', 'Succès'),
(161, 1, 'System Admin', 'Gestion programmes', 'Page de gestion des programmes ouverte', '2025-12-31 12:39:11', 'Succès'),
(162, 1, 'System Admin', 'Gestion matières', 'Page de gestion des matières ouverte', '2025-12-31 12:40:15', 'Succès'),
(163, 1, 'System Admin', 'Gestion établissements', 'Page de gestion des établissements ouverte', '2025-12-31 12:41:07', 'Succès'),
(164, 1, 'System Admin', 'Gestion cours', 'Page de gestion des cours ouverte', '2025-12-31 12:41:15', 'Succès'),
(165, 1, 'System Admin', 'Gestion programmes', 'Page de gestion des programmes ouverte', '2025-12-31 12:43:42', 'Succès'),
(166, 1, 'System Admin', 'Gestion classes', 'Page de gestion des classes ouverte', '2025-12-31 12:52:49', 'Succès'),
(167, 1, 'System Admin', 'Gestion programmes', 'Page de gestion des programmes ouverte', '2025-12-31 13:22:37', 'Succès'),
(168, 1, 'System Admin', 'Gestion matières', 'Page de gestion des matières ouverte', '2025-12-31 13:22:42', 'Succès');

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
  KEY `id_matiere` (`id_matiere`),
  KEY `id_programme` (`id_programme`),
  KEY `fk_cours_classe` (`id_classe`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
