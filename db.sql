-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 08, 2014 at 02:09 PM
-- Server version: 5.5.34
-- PHP Version: 5.3.10-1ubuntu3.10
-- Typical database table schemas that work with scoop app

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `scoop app`
--

-- --------------------------------------------------------

--
-- Basic table structure for table typical scoop app `users`
-- Works with session class and controller->logs

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(20) NOT NULL,
  `last_name` varchar(20) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(192) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;



-- --------------------------------------------------------

--
-- Basic table structure for table `logs`
-- Works with controller->logs

CREATE TABLE IF NOT EXISTS `logs` (
  `log_id` int(11) NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(64) NOT NULL DEFAULT '0.0.0.0',
  `event` varchar(254) NOT NULL,
  `controller` varchar(200) NOT NULL,
  `user_id` int(11) NOT NULL,
  `browser_agent` varchar(200) NOT NULL,
  `browser_os` varchar(200) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`log_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

