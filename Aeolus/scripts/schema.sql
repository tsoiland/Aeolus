-- phpMyAdmin SQL Dump
-- version 3.3.7deb5build0.10.10.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 14, 2011 at 01:03 PM
-- Server version: 5.1.49
-- PHP Version: 5.3.3-1ubuntu9.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `aeolus`
--
DROP DATABASE `aeolus`;
CREATE DATABASE `aeolus` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `aeolus`;

-- --------------------------------------------------------

--
-- Table structure for table `incident`
--

DROP TABLE IF EXISTS `incident`;
CREATE TABLE IF NOT EXISTS `incident` (
  `title` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `latitude` float NOT NULL,
  `longitude` float NOT NULL,
  `verified` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `incident`
--

INSERT INTO `incident` (`title`, `description`, `id`, `latitude`, `longitude`, `verified`) VALUES
('Testtitle', 'This is the test description', 1, -34.397, 150.644, 0),
('trdfg', 'sdg', 2, -35.397, 150.644, 0),
('fdsg', 'sdfg', 3, -33.27, 151.792, 0),
('hello', 'test', 4, -33.2792, 149.595, 0),
('rwer', 'wer', 5, -23.0333, 145.969, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `salt` varchar(50) NOT NULL,
  `role` varchar(50) NOT NULL,
  `date_created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `salt`, `role`, `date_created`) VALUES
(1, 'admin', '45d0122d11b30012eb0111b09181712f16620a7a', 'ce8d96d579d389e783f95b3772785783ea1a9854', 'admin', '2011-04-05 09:47:36');
