-- --------------------------------------------------------
-- Hôte:                         127.0.0.1
-- Version du serveur:           8.0.30 - MySQL Community Server - GPL
-- SE du serveur:                Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Listage de la structure de la base pour forumlecam
CREATE DATABASE IF NOT EXISTS `forumlecam` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `forumlecam`;

-- Listage de la structure de table forumlecam. category
CREATE TABLE IF NOT EXISTS `category` (
  `id_category` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  PRIMARY KEY (`id_category`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table forumlecam.category : ~4 rows (environ)
INSERT IGNORE INTO `category` (`id_category`, `name`, `description`) VALUES
	(1, 'Jeu-Video', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed posuere vel velit sit amet ultrices. Proin nisl est, aliquet non dolor at, fringilla porttitor tellus. Curabitur convallis, nunc at mattis congue, tortor diam malesuada neque, at consectetur diam purus ut felis. '),
	(2, 'Chaussures', 'Nullam sit amet sem nec mauris venenatis malesuada vel non nisl. Maecenas turpis est, euismod a facilisis quis, pulvinar id leo. Nullam semper blandit placerat. '),
	(3, 'Chaussettes', 'Phasellus sed velit et quam eleifend ultrices eget et sapien. Donec nec pellentesque est. Quisque luctus, lorem vel consectetur hendrerit, sem mauris convallis felis, a viverra felis turpis quis neque. Nullam blandit vestibulum ante quis ullamcorper. Proin rutrum ultricies lacinia. Ut mauris mi, blandit a enim id, maximus egestas felis.'),
	(4, 'Médical', 'Donec ut eleifend erat, ac rutrum odio. Maecenas sed ullamcorper arcu, vitae faucibus lorem. Duis urna dolor, semper tincidunt est imperdiet, aliquam facilisis enim. Quisque gravida velit sed nisi faucibus ultricies. ');

-- Listage de la structure de table forumlecam. post
CREATE TABLE IF NOT EXISTS `post` (
  `id_post` int NOT NULL AUTO_INCREMENT,
  `message` text NOT NULL,
  `topic_id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `creationDate` datetime NOT NULL,
  PRIMARY KEY (`id_post`),
  KEY `FK_post_topic` (`topic_id`),
  KEY `FK_post_user` (`user_id`),
  CONSTRAINT `FK_post_topic` FOREIGN KEY (`topic_id`) REFERENCES `topic` (`id_topic`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_post_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id_user`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table forumlecam.post : ~17 rows (environ)
INSERT IGNORE INTO `post` (`id_post`, `message`, `topic_id`, `user_id`, `creationDate`) VALUES
	(1, 'Age of empire est dead', 1, 1, '2024-07-11 13:39:41'),
	(2, 'Age of empire est pas mort enfaite ! ', 1, 1, '2024-07-11 13:40:20'),
	(3, 'Dofus a son economie cassée', 2, 1, '2024-07-11 13:41:07'),
	(4, '&lt;p&gt;On en pense quoi des cartes de verres ?&lt;/p&gt;', 4, 1, '2024-07-12 09:05:24'),
	(5, '&lt;p&gt;J&#039;ai des boutons et j&#039;ai peur que ca soit de l&#039;herp&egrave;s&lt;/p&gt;', 5, 1, '2024-07-12 09:15:02'),
	(6, '&lt;p&gt;On en pense quoi de Teemo ?&lt;/p&gt;', 6, 4, '2024-07-18 11:25:33'),
	(7, '&#60;p&#62;Teemo est trop nul mdr&#60;/p&#62;', 6, 4, '2024-07-18 11:25:51'),
	(10, '&lt;p&gt;&lt;strong&gt;sqdsqjhdbqsdlkqsndqlksd&lt;/strong&gt;&lt;/p&gt;\r\n&lt;p&gt;qsokdfsdfs&lt;/p&gt;\r\n&lt;p&gt;sq&ocirc;lkfj,s&lt;/p&gt;', 1, 4, '2024-07-18 13:41:52'),
	(17, '&#60;p style=&#34;text-align: right;&#34;&#62;Ah chaud ...&#60;/p&#62;', 5, 4, '2024-07-20 08:20:02'),
	(18, '&#60;p&#62;dqz&#60;/p&#62;', 4, 4, '2024-07-22 17:30:47'),
	(19, '&#60;p&#62;zqdqzd&#60;/p&#62;', 4, 4, '2024-07-22 17:30:51'),
	(20, '&#60;p&#62;qzdqsd&#60;/p&#62;', 4, 4, '2024-07-22 17:30:55'),
	(21, '&#60;p&#62;qzdqdqsd&#60;/p&#62;', 4, 4, '2024-07-22 17:30:58'),
	(22, '&#60;p&#62;qzdsqdqzd&#60;/p&#62;', 4, 4, '2024-07-22 17:31:01'),
	(23, '&#60;p&#62;qzdqsdqzdqd&#60;/p&#62;', 4, 4, '2024-07-22 17:31:04'),
	(24, '&#60;p&#62;qdqzdsqzdq&#60;/p&#62;', 4, 4, '2024-07-22 17:31:08'),
	(25, '&#60;p&#62;qzdqsdqzdqd&#60;/p&#62;', 4, 4, '2024-07-22 17:31:11'),
	(26, 'xckv,nxclkgn,cxlknfcxlknxc,lbnclxk jgfcgj  fxcjgi xklc', 3, NULL, '2024-07-24 19:53:30');

-- Listage de la structure de table forumlecam. topic
CREATE TABLE IF NOT EXISTS `topic` (
  `id_topic` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `user_id` int DEFAULT NULL,
  `category_id` int NOT NULL,
  `creationDate` datetime NOT NULL,
  `closed` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_topic`),
  KEY `FK_topic_user` (`user_id`),
  KEY `FK_topic_category` (`category_id`),
  CONSTRAINT `FK_topic_category` FOREIGN KEY (`category_id`) REFERENCES `category` (`id_category`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_topic_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id_user`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table forumlecam.topic : ~6 rows (environ)
INSERT IGNORE INTO `topic` (`id_topic`, `title`, `user_id`, `category_id`, `creationDate`, `closed`) VALUES
	(1, 'Age of empire 2', 1, 1, '2024-07-09 00:00:00', 0),
	(2, 'Dofus', 1, 1, '2024-07-11 00:00:00', 0),
	(3, 'Jules', 1, 2, '2024-07-11 13:42:52', 0),
	(4, 'Balatro', 1, 1, '2024-07-12 09:05:24', 0),
	(5, 'Herp&egrave;s', 1, 4, '2024-07-12 09:15:02', 0),
	(6, 'LoL', 4, 1, '2024-07-18 11:25:33', 0);

-- Listage de la structure de table forumlecam. user
CREATE TABLE IF NOT EXISTS `user` (
  `id_user` int NOT NULL AUTO_INCREMENT,
  `nickName` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'USER',
  `banned` datetime DEFAULT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table forumlecam.user : ~4 rows (environ)
INSERT IGNORE INTO `user` (`id_user`, `nickName`, `password`, `email`, `role`, `banned`) VALUES
	(1, 'Ikaz35', '', 'dsfsqf@ffrg.fr', 'USER', '2024-07-19 08:23:50'),
	(2, 'dsqdqsda', '$2y$10$trcCknlOS1kJPfoGEEBKreprT7Tl1lJ9AzNR5nC/T6C6KOe3OKTwm', 'skdfjhfds@dgds.fr', 'USER', NULL),
	(3, 'dsqdqsda', '$2y$10$27Z6IMNlNUM4TcGlRPJmNO84O.Pbl/CrAg07SiwY/cV/61t/z59SO', 'skdfjhfssds@dgds.fr', 'USER', NULL),
	(4, 'Yanouh', '$2y$10$5dFwFtcfHsztGDdzYjMNy.Prltoz/JvxgXbsEXRnKsBvKUuXJN85.', 'yannick.lecam1@gmail.com', 'ADMIN', NULL);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
