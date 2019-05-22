-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 22, 2019 at 09:59 AM
-- Server version: 5.7.24
-- PHP Version: 7.2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hl_contacts_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `hl_user_details`
--

DROP TABLE IF EXISTS `hl_user_details`;
CREATE TABLE IF NOT EXISTS `hl_user_details` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `full_name` varchar(100) NOT NULL,
  `email_id` varchar(50) NOT NULL,
  `password` varchar(200) NOT NULL,
  `date_time` datetime NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hl_user_details`
--

INSERT INTO `hl_user_details` (`user_id`, `full_name`, `email_id`, `password`, `date_time`) VALUES
(1, 'Ravishankar Kawathale', 'ravishankarkawathale@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', '2019-05-22 14:59:57');

-- --------------------------------------------------------

--
-- Table structure for table `user_contact_details`
--

DROP TABLE IF EXISTS `user_contact_details`;
CREATE TABLE IF NOT EXISTS `user_contact_details` (
  `contact_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `middle_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `primary_phone` varchar(13) NOT NULL,
  `secondary_phone` varchar(13) NOT NULL,
  `email_id` varchar(100) NOT NULL,
  `photo` varchar(100) NOT NULL,
  `delete_status` tinyint(4) NOT NULL,
  `created_date_time` datetime NOT NULL,
  PRIMARY KEY (`contact_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_shared_contacts`
--

DROP TABLE IF EXISTS `user_shared_contacts`;
CREATE TABLE IF NOT EXISTS `user_shared_contacts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `shared_by_user` int(11) NOT NULL,
  `shared_with_user` int(11) NOT NULL,
  `contact_id` int(11) NOT NULL,
  `shared_on` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
