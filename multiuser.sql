-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 31, 2024 at 07:22 PM
-- Server version: 8.2.0
-- PHP Version: 8.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `multiuser`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `recipe_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `recipe_id` (`recipe_id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf16;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `recipe_id`) VALUES
(20, 'Veggie', NULL),
(7, 'Vegan', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ingredients`
--

DROP TABLE IF EXISTS `ingredients`;
CREATE TABLE IF NOT EXISTS `ingredients` (
  `ingredient_id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `quantity` varchar(255) DEFAULT NULL,
  `recipe_id` int DEFAULT NULL,
  PRIMARY KEY (`ingredient_id`),
  KEY `recipe_id` (`recipe_id`)
) ENGINE=MyISAM AUTO_INCREMENT=56 DEFAULT CHARSET=utf16;

--
-- Dumping data for table `ingredients`
--

INSERT INTO `ingredients` (`ingredient_id`, `name`, `quantity`, `recipe_id`) VALUES
(26, 'fdsfds', '1', 17),
(27, 'fsfds', '1', 17),
(28, 'fdsfdsf', '1', 17),
(29, 'gfdgdfgfd', '1', 17),
(30, 'fdsfdsfsd', '2', 17),
(31, 'ewrewr', '`', 18),
(32, 'ewrewr', '`', 19),
(33, 'ffsfs', '1', 20),
(34, '1e dwdsad', '1', 21),
(35, '2', 'fdgfdg', 22),
(36, '2', 'tet', 23),
(37, 'test', '1', 24),
(38, 'test', '1', 25),
(39, 'sdfdsf', '1', 26),
(40, 'njkn', '1', 27),
(41, 'njkn', '1', 28),
(42, 'njknjk', '1', 29),
(43, '1', 'j', 30),
(44, 'huhkjjk', '1', 31),
(45, 'FGFGFH', '1', 32),
(46, 'cfghbjnk', 't', 33),
(47, 'bhjklm', '2', 34),
(48, 'gbjhkl', '3', 35),
(49, 'ujik', '3', 36),
(50, 'jnkjnj', '3', 37),
(51, 'kmlmkl', '3', 38),
(52, 'mklmlk', '3', 40),
(53, 'njnkjn', '2', 42),
(54, 'njknkjn', '2', 43),
(55, 'njknkj', '21', 44);

-- --------------------------------------------------------

--
-- Table structure for table `preparationsteps`
--

DROP TABLE IF EXISTS `preparationsteps`;
CREATE TABLE IF NOT EXISTS `preparationsteps` (
  `step_id` int NOT NULL AUTO_INCREMENT,
  `step_number` int NOT NULL,
  `description` text,
  `recipe_id` int DEFAULT NULL,
  PRIMARY KEY (`step_id`),
  KEY `recipe_id` (`recipe_id`)
) ENGINE=MyISAM AUTO_INCREMENT=57 DEFAULT CHARSET=utf16;

--
-- Dumping data for table `preparationsteps`
--

INSERT INTO `preparationsteps` (`step_id`, `step_number`, `description`, `recipe_id`) VALUES
(26, 1, 'dsfsfddf', 20),
(27, 1, 'dsadsad', 21),
(28, 3, 'gfdgdg', 22),
(29, 4, 'gdgdfg', 23),
(30, 1, 'dxvxvcxv ', 24),
(31, 1, 'dxvxvcxv ', 25),
(32, 1, 'jnknkjn', 26),
(33, 1, 'nknkn', 27),
(34, 1, 'nknkn', 28),
(35, 1, 'nknkj', 29),
(36, 1, 'njknk', 30),
(37, 1, 'njkjnkj', 31),
(38, 1, 'GHGJ', 32),
(39, 1, 'ghjkl;', 33),
(40, 2, 'buhjnikml', 34),
(41, 2, 'buhjnikml', 34),
(42, 3, 'njkml;', 35),
(43, 3, 'njkml;', 35),
(44, 2, 'hjnkm', 36),
(45, 2, 'hjnkm', 36),
(46, 1, 'njnkjn', 37),
(47, 1, 'njnkjn', 37),
(48, 1, 'njknjknk', 38),
(49, 1, 'njknjknk', 38),
(50, 1, 'mklml', 40),
(51, 1, 'mklml', 40),
(52, 2, 'njknjk', 42),
(53, 2, 'jknnjnk', 43),
(54, 2, 'jknnjnk', 43),
(55, 1, 'jknkj', 44),
(56, 1, 'jknkj', 44);

-- --------------------------------------------------------

--
-- Table structure for table `recipes`
--

DROP TABLE IF EXISTS `recipes`;
CREATE TABLE IF NOT EXISTS `recipes` (
  `recipe_id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text,
  `instructions` text,
  `files` longblob,
  `prep_time` int DEFAULT NULL,
  `cook_time` int DEFAULT NULL,
  `total_time` int DEFAULT NULL,
  `serving_size` int DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `category_id` int DEFAULT NULL,
  PRIMARY KEY (`recipe_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=45 DEFAULT CHARSET=utf16;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `uname` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `upwd` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `added_date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `uname`, `upwd`, `role`, `added_date`) VALUES
(3, 'admin', 'admin', 'admin', '0000-00-00 00:00:00'),
(7, 'chef', '1111', 'chef', '2024-03-13 07:18:35'),
(8, 'user', 'mytest', 'RecipeSeeker', '2024-03-13 07:19:42');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
