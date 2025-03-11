-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : ven. 23 août 2024 à 16:34
-- Version du serveur : 8.3.0
-- Version de PHP : 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `e-equip`
--

-- --------------------------------------------------------

--
-- Structure de la table `articles_commande`
--

DROP TABLE IF EXISTS `articles_commande`;
CREATE TABLE IF NOT EXISTS `articles_commande` (
  `article_commande_id` int NOT NULL AUTO_INCREMENT,
  `commande_id` int DEFAULT NULL,
  `produit_id` int DEFAULT NULL,
  `quantite` int NOT NULL,
  PRIMARY KEY (`article_commande_id`),
  KEY `commande_id` (`commande_id`),
  KEY `produit_id` (`produit_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `categorie_id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  PRIMARY KEY (`categorie_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`categorie_id`, `nom`) VALUES
(2, 'Ordinateur'),
(3, 'Téléphone'),
(4, 'Périphérique'),
(5, 'Composant');

-- --------------------------------------------------------

--
-- Structure de la table `commandes`
--

DROP TABLE IF EXISTS `commandes`;
CREATE TABLE IF NOT EXISTS `commandes` (
  `commande_id` int NOT NULL AUTO_INCREMENT,
  `utilisateur_id` int DEFAULT NULL,
  `quantite` int NOT NULL,
  `date_commande` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `montant_total` decimal(10,2) NOT NULL,
  `adresse_livraison` text,
  `cree_le` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `modifie_le` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `statut` varchar(20) DEFAULT 'En attente',
  PRIMARY KEY (`commande_id`),
  KEY `utilisateur_id` (`utilisateur_id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `commandes`
--

INSERT INTO `commandes` (`commande_id`, `utilisateur_id`, `quantite`, `date_commande`, `montant_total`, `adresse_livraison`, `cree_le`, `modifie_le`, `statut`) VALUES
(4, 2, 3, '2024-08-20 15:41:08', 600.00, 'Cotonou', '2024-08-20 15:41:08', '2024-08-22 17:22:56', 'Livrée'),
(5, 2, 3, '2024-08-22 17:14:33', 1946346.00, 'Agla', '2024-08-22 17:14:33', '2024-08-23 09:12:05', 'Livrée'),
(7, 2, 2, '2024-08-23 12:04:53', 170000.00, 'Cotonou', '2024-08-23 12:04:53', '2024-08-23 12:33:49', 'Livré'),
(10, 2, 2, '2024-08-23 15:11:20', 864604.00, 'Comé', '2024-08-23 15:11:20', '2024-08-23 15:11:20', 'En attente'),
(9, 2, 2, '2024-08-23 12:35:19', 20000.00, 'Agla', '2024-08-23 12:35:19', '2024-08-23 12:49:20', 'Livré'),
(11, 2, 2, '2024-08-23 15:12:09', 90534.00, 'Agla', '2024-08-23 15:12:09', '2024-08-23 15:12:09', 'En attente');

-- --------------------------------------------------------

--
-- Structure de la table `livraisons`
--

DROP TABLE IF EXISTS `livraisons`;
CREATE TABLE IF NOT EXISTS `livraisons` (
  `livraison_id` int NOT NULL AUTO_INCREMENT,
  `commande_id` int DEFAULT NULL,
  `transporteur` varchar(50) DEFAULT NULL,
  `num_suivi` varchar(50) DEFAULT NULL,
  `date_expedition` datetime DEFAULT NULL,
  `date_livraison` datetime DEFAULT NULL,
  `status` varchar(20) DEFAULT 'En cours',
  `cree_le` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `modifie_le` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`livraison_id`),
  KEY `commande_id` (`commande_id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `livraisons`
--

INSERT INTO `livraisons` (`livraison_id`, `commande_id`, `transporteur`, `num_suivi`, `date_expedition`, `date_livraison`, `status`, `cree_le`, `modifie_le`) VALUES
(1, 4, 'DHL', '1234567890', '2024-08-22 12:52:58', '2024-08-22 12:53:30', 'Livrée', '2024-08-22 11:52:58', '2024-08-22 16:39:22'),
(8, 7, 'DHL', '3766309', '2024-08-23 12:05:59', '2024-08-23 13:19:42', 'Livré', '2024-08-23 12:05:59', '2024-08-23 12:19:42'),
(9, 8, 'DHL', '463569', '2024-08-23 12:24:14', '2024-08-23 13:28:39', 'Livré', '2024-08-23 12:24:14', '2024-08-23 12:28:39'),
(4, 5, 'DHL', '2230154', '2024-07-13 00:00:00', '2024-08-07 00:00:00', 'Livrée', '2024-08-23 09:12:05', '2024-08-23 09:12:05'),
(10, 8, 'DHL', '463569', '2024-08-23 12:28:23', '2024-08-23 13:28:39', 'Livré', '2024-08-23 12:28:23', '2024-08-23 12:28:39'),
(11, 9, 'DHL', '13289245', '2024-08-23 12:48:56', '2024-08-23 13:49:20', 'Livré', '2024-08-23 12:48:56', '2024-08-23 12:49:20');

-- --------------------------------------------------------

--
-- Structure de la table `produits`
--

DROP TABLE IF EXISTS `produits`;
CREATE TABLE IF NOT EXISTS `produits` (
  `produit_id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `prix` decimal(10,2) NOT NULL,
  `categorie` varchar(50) NOT NULL,
  `image` varchar(255) NOT NULL,
  `date_ajout` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `categorie_id` int DEFAULT NULL,
  PRIMARY KEY (`produit_id`),
  KEY `fk_categorie` (`categorie_id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `produits`
--

INSERT INTO `produits` (`produit_id`, `nom`, `description`, `prix`, `categorie`, `image`, `date_ajout`, `categorie_id`) VALUES
(1, 'MSI Optix', '27 pouces en résolution WQHD (2560 x 1440 pixels)', 300.00, 'Ordinateur', 'images/msi_optix.jpg', '2024-08-19 14:52:03', 2),
(9, 'Samsung Galaxy S24 Ultra ', 'Galaxy S24 Ultra 5G, gris, 1 To, 6,8 pouces, Android 14', 250421.00, 'Téléphone', 'images/1724250102-S24 gris.jpg', '2024-08-21 14:21:42', 3),
(3, 'Razer DeathAdder Essential 2021 - Noir', 'Souris gamer, Capteur optique, Filaire, Pour droitier, 6400 dpi, 5 boutons', 10000.00, 'Périphérique', 'images/1724169209-souris.jpg', '2024-08-20 15:53:29', 4),
(4, 'Altyk Le PC Portable L15F-I5P16-N1', 'Bureautique, 15.6\", IPS, Full HD, Core i5-1240P, RAM 16 Go, SSD 960 Go, Windows 11, 1,70 kg', 554318.00, 'Ordinateur', 'images/1724248128-acer.jpg', '2024-08-21 13:48:49', 2),
(5, 'MSI Katana 15', 'PC portable, 15.6\", IPS, 1920 x 1080 (Full HD), 144 Hz, Core i7-13620H, RTX 4070, RAM 32 Go, SSD 1 To, Windows 11 Pro, 2,25 kg', 1048941.00, 'Ordinateur', 'images/1724248451-kata.jpg', '2024-08-21 13:54:11', 2),
(6, 'Apple MacBook Air M3 15 pouces (2024) Gris sidéral', 'PC portable, 15.3\", Apple M3 8 coeurs (GPU 10 coeurs), RAM 16 Go, SSD 512 Go, Mac OS Sonoma, 1,51 kg', 1186700.00, 'Ordinateur', 'images/1724248565-macbook.jpg', '2024-08-21 13:56:05', 2),
(7, 'Lenovo ThinkPad P50 (P50-i7-6820HQ-FHD-B-2980)', 'Intel Core i7-6820HQ 32Go 1To 15,6\" Windows 10 Famille 64bits', 432302.00, 'Ordinateur', 'images/1724248830-lenevo.jpg', '2024-08-21 14:00:30', 2),
(8, ' Backstab - PC Gamer', 'PC de jeu, AMD Ryzen 5 7500F, GeForce RTX 4070 SUPER, SSD NVMe 1 To, 32 Go DDR5, sans OS - Monté et testé dans nos ateliers', 983341.00, 'Ordinateur', 'images/1724249016-pc.jpg', '2024-08-21 14:03:36', 2),
(10, 'Poco C65', 'Poco C65, noir, 128 Go, 6,74 pouces, Android 13 + MIUI 14', 85000.00, 'Téléphone', 'images/1724250232-poco.jpg', '2024-08-21 14:23:52', 3),
(11, 'Motorola Edge', 'Motorola Edge 50 50 Fusion, 5G, Snapdragon 7 Gen 2, RAM 8 Go, 6,7\" 144Hz, 256 Go', 77500.00, 'Téléphone', 'images/1724251012-motorola.jpg', '2024-08-21 14:36:52', 3),
(12, 'MSI MAG 27CQ6PF', '27\" incurvé, Rapid VA, 16:9, 2560 x 1440 (WQHD), 0.5 ms, 180 Hz, HDR, FreeSync, HDMI/DisplayPort', 110000.00, 'Périphérique', 'images/1724251210-msi mag.jpg', '2024-08-21 14:40:10', 4),
(13, 'Asus TUF VG249Q3A', '23.8\", IPS, 16:9, 1920 x 1080 (FHD), 1 ms, 180 Hz, FreeSync, HDMI/DisplayPort', 95000.00, 'Périphérique', 'images/1724251347-asus.jpg', '2024-08-21 14:42:27', 4),
(14, 'Kingston DataTraveler Exodia M - 64 Go', 'Clé USB 64 Go, USB 3.2 Gen 1 (Compatible 2.0, 3.0, 3.1), DTXM/64GB', 6559.00, 'Périphérique', 'images/1724251494-kingston.jpg', '2024-08-21 14:44:54', 4),
(15, 'Corsair Vengeance Black', 'Kit RAM DDR5, 32 Go, 6000 MHz, PC48000, CL36-44-44-96, 1,4 Volts, CMK32GX5M2E6000C36', 45267.00, 'Composant', 'images/1724252077-corsaire ram.jpg', '2024-08-21 14:54:38', 5),
(16, 'AeroCool CS', 'Boîtier PC vitré, Micro ATX / Mini ITX, 3 ventilateurs 120 mm FRGB fournis', 19023.00, 'Composant', 'images/1724252186-boitier aerocool.jpg', '2024-08-21 14:56:26', 5),
(17, 'QNAP NAS TS-433', 'Boitier 4 baies, Livré sans disque (boitier nu), Pour disque 2,5\" ou 3,5\", SATA III, ARM Cortex-A55 à 2 GHz (Quad-Core), 4 Go', 294543.00, 'Composant', 'images/1724252435-server qnap.jpg', '2024-08-21 15:00:35', 5),
(18, 'Kit combiné', 'Ensemble de câbles, clé UBS, disque dur et carte SD', 25000.00, 'Périphérique', 'images/1724256416-assecoire.jpg', '2024-08-21 16:06:56', 4),
(19, 'Apple iPhone 15 Pro', 'iPhone 15 Pro, Titane bleu, 128 Go, 6,1 pouces, iOS 17', 648782.00, 'Téléphone', 'images/1724256550-15Pro.jpg', '2024-08-21 16:09:10', 3);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

DROP TABLE IF EXISTS `utilisateurs`;
CREATE TABLE IF NOT EXISTS `utilisateurs` (
  `utilisateur_id` int NOT NULL AUTO_INCREMENT,
  `nom_utilisateur` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  `profil` varchar(50) DEFAULT 'client',
  PRIMARY KEY (`utilisateur_id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`utilisateur_id`, `nom_utilisateur`, `email`, `mot_de_passe`, `profil`) VALUES
(1, 'Admin', 'onlyme@gmail.com', '$2y$10$39aN7d2AXsrvFEC9saZrxu0iUcqrKrS06KWhqiiYeecboQJlBBuE6', 'administrateur'),
(2, 'Danic', 'danic@gmail.com', '$2y$10$GrF7vEQs6nFOwbvv3h0vDO4omUVaumrvCSkGbDZv0KdzIl8N2W/be', 'client'),
(3, 'Amen', 'marie17@gmail.com', '$2y$10$eutzo7GcPSxwpUX.mIJsQOfaZWWwxTc8OaWxjdGltqr36txnNCGyu', 'client');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
