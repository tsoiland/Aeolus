-- phpMyAdmin SQL Dump
-- version 3.3.7deb5build0.10.10.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 22, 2011 at 08:43 PM
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
DROP DATABASE IF EXISTS `aeolus`;
CREATE DATABASE `aeolus` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `aeolus`;

-- --------------------------------------------------------

--
-- Table structure for table `incidents`
--

CREATE TABLE IF NOT EXISTS `incidents` (
  `title` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `latitude` float DEFAULT NULL,
  `longitude` float DEFAULT NULL,
  `verified` tinyint(1) NOT NULL,
  `twitter_id` bigint(20) DEFAULT NULL,
  `sensitive_description` text NOT NULL,
  `creation_time` bigint(20) DEFAULT NULL,
  `verify_time` bigint(20) DEFAULT NULL,
  `first_assignment_time` bigint(20) DEFAULT NULL,
  `close_time` bigint(20) DEFAULT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=117 ;

--
-- Dumping data for table `incidents`
--

INSERT INTO `incidents` (`title`, `description`, `id`, `latitude`, `longitude`, `verified`, `twitter_id`, `sensitive_description`, `creation_time`, `verify_time`, `first_assignment_time`, `close_time`, `status`) VALUES
('Tornado', 'A tornado is tearing through the southern suburbs', 10, -17.5792, 145.453, 1, NULL, 'A bunch of people died, but don''t tell the public yet. We don''t want people to panic just yet.', 1306044732, 1306045732, 1306046732, 1306047732, 1),
('Fire', 'There is a fire in brisbane city', 8, -27.5454, 152.924, 1, NULL, 'None', 0, 0, 1306052742, 0, 0),
('Flood', 'there is a flood in northern brisbane', 9, -27.3445, 152.993, 1, NULL, 'None', 1306030137, 1306032137, 1306034137, 1306036137, 1),
('#AeolusDMS Fire spreads throughout western Queensl', '#AeolusDMS Fire spreads throughout western Queensland', 107, NULL, NULL, 0, 67744124652109824, '', 0, 0, 0, 0, 0),
('#AeolusDMS check 1 2', '#AeolusDMS check 1 2', 108, NULL, NULL, 0, 67742390806519808, '', 0, 0, 0, 0, 0),
('#aeolusdms Test for uni project.', '#aeolusdms Test for uni project.', 109, 0, 0, 1, NULL, '#aeolusdms Test for uni project.', 0, 1305973953, 0, 0, 0),
('t', 't', 116, 0, 0, 0, NULL, 't', 1306044732, NULL, 1306052770, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_incident`
--

CREATE TABLE IF NOT EXISTS `user_incident` (
  `user_id` int(11) NOT NULL,
  `incident_id` int(11) NOT NULL,
  PRIMARY KEY (`user_id`,`incident_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_incident`
--

INSERT INTO `user_incident` (`user_id`, `incident_id`) VALUES
(1, 8),
(1, 10),
(1, 113),
(6, 1),
(7, 8),
(7, 9),
(7, 10),
(7, 116),
(8, 8),
(8, 10),
(8, 111),
(8, 116),
(10, 9),
(10, 111),
(10, 116),
(14, 9),
(14, 116);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `salt` varchar(50) NOT NULL,
  `role` varchar(50) NOT NULL,
  `clock_in_time` bigint(20) DEFAULT NULL,
  `clock_out_time` bigint(20) DEFAULT NULL,
  `realname` varchar(50) NOT NULL,
  `location` varchar(50) NOT NULL,
  `phone_nr` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `salt`, `role`, `clock_in_time`, `clock_out_time`, `realname`, `location`, `phone_nr`) VALUES
(1, 'admin', '8ad09ae2f3a7e1b570c945f4db0a75797942c61c', 'ce8d96d579d389e783f95b3772785783ea1a9854', 'admin', 1306032557, 1306032558, 'Administrator', 'Brisbanea', '0412345678'),
(7, 'bc', '1aa041d2578ae762cd3bd848b5540b56c9423dc1', 'ce8d96d579d389e783f95b3772785783ea1a9854', 'field_personnel', NULL, NULL, 'Bill Cunnigham', '', '0'),
(8, 'jl', '45d0122d11b30012eb0111b09181712f16620a7a', 'ce8d96d579d389e783f95b3772785783ea1a9854', 'field_personnel', NULL, NULL, 'James Lear', '', '0'),
(10, 'chleo tank - ambulance attendant', '82faa401915339b1a7d1f09ab6d64a9c4f71a503', 'ce8d96d579d389e783f95b3772785783ea1a9854', 'field_personell', NULL, NULL, '', '', '0'),
(14, 't', '2d78e50393e1c273526fa5056d7f032836a191be', 'ce8d96d579d389e783f95b3772785783ea1a9854', 'guest', NULL, NULL, 'te', 'test', '345');