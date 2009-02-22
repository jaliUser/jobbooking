-- phpMyAdmin SQL Dump
-- version 2.10.2
-- http://www.phpmyadmin.net
-- 
-- Vært: localhost
-- Genereringstid: 03/12 2008 kl. 17:06:24
-- Serverversion: 5.0.27
-- PHP-version: 5.2.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- Database: `see2010jobcenter`
-- 

-- --------------------------------------------------------

-- 
-- Struktur-dump for tabellen `area`
-- 

CREATE TABLE IF NOT EXISTS `area` (
  `id` tinyint(4) NOT NULL auto_increment,
  `site_id` tinyint(4) NOT NULL,
  `name` varchar(64) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- 
-- Data dump for tabellen `area`
-- 

INSERT INTO `area` (`id`, `site_id`, `name`, `description`) VALUES 
(1, 1, 'DOT', 'Drift og teknik'),
(2, 1, 'AKT', 'Aktiviteter');

-- --------------------------------------------------------

-- 
-- Struktur-dump for tabellen `days`
-- 

CREATE TABLE IF NOT EXISTS `days` (
  `id` tinyint(4) NOT NULL auto_increment,
  `site_id` tinyint(4) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

-- 
-- Data dump for tabellen `days`
-- 

INSERT INTO `days` (`id`, `site_id`, `date`) VALUES 
(1, 1, '2009-07-24'),
(2, 1, '2009-07-25'),
(3, 1, '2009-07-26'),
(4, 1, '2009-07-27'),
(5, 1, '2009-07-28'),
(6, 1, '2009-07-29'),
(7, 1, '2009-07-30'),
(8, 1, '2009-07-31'),
(9, 1, '2009-08-01');

-- --------------------------------------------------------

-- 
-- Struktur-dump for tabellen `district`
-- 

CREATE TABLE IF NOT EXISTS `district` (
  `id` tinyint(4) NOT NULL auto_increment,
  `site_id` tinyint(4) NOT NULL,
  `name` varchar(64) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- 
-- Data dump for tabellen `district`
-- 

INSERT INTO `district` (`id`, `site_id`, `name`) VALUES 
(1, 1, 'Nordjyske'),
(2, 1, 'Midtjyske');

-- --------------------------------------------------------

-- 
-- Struktur-dump for tabellen `group`
-- 

CREATE TABLE IF NOT EXISTS `group` (
  `id` tinyint(4) NOT NULL auto_increment,
  `site_id` tinyint(4) NOT NULL,
  `name` varchar(64) NOT NULL,
  `district_id` tinyint(4) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `district_id` (`district_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- 
-- Data dump for tabellen `group`
-- 

INSERT INTO `group` (`id`, `site_id`, `name`, `district_id`) VALUES 
(1, 1, 'Lindholm', 1),
(2, 1, 'Knuden', 1),
(3, 1, 'M-grp 1', 2),
(4, 1, 'M-grp 2', 2);

-- --------------------------------------------------------

-- 
-- Struktur-dump for tabellen `job`
-- 

CREATE TABLE IF NOT EXISTS `job` (
  `id` tinyint(4) NOT NULL auto_increment,
  `site_id` tinyint(4) NOT NULL,
  `area_id` tinyint(4) NOT NULL,
  `owner_id` varchar(25) NOT NULL COMMENT 'cal_login',
  `name` varchar(64) NOT NULL,
  `description` varchar(255) NULL,
  `place` varchar(64) NULL,
  `notes` varchar(255) NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

-- 
-- Data dump for tabellen `job`
-- 

INSERT INTO `job` (`id`, `site_id`, `area_id`, `owner_id`, `name`, `description`, `place`, `notes`) VALUES 
(1, 1, 1, 'admin', 'Parkeringsvagt', 'desc', 'Plads A', 'Husk lommelygte'),
(2, 1, 1, 'admin', 'testjob', 'testdesc', 'testplace', 'testnote'),
(3, 1, 1, 'admin', 'testjob', 'testdesc', 'testplace', 'testnote'),
(4, 1, 1, 'admin', 'testjob2', 'testdesc', 'testplace', 'testnote'),
(5, 1, 1, 'admin', 'testjob2', 'testdesc', 'testplace', 'testnote'),
(6, 1, 1, 'admin', 'testjob3', 'testdesc', 'testplace', 'testnote'),
(7, 1, 1, 'admin', 'testjob', 'testdesc', 'testplace', 'testnote'),
(8, 1, 1, 'admin', 'testjob', 'testdesc', 'testplace', 'testnote'),
(9, 1, 1, 'admin', 'testjob', 'testdesc', 'testplace', 'testnote');

-- --------------------------------------------------------

-- 
-- Struktur-dump for tabellen `role`
-- 

CREATE TABLE IF NOT EXISTS `role` (
  `id` tinyint(4) NOT NULL auto_increment,
  `name` varchar(16) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- 
-- Data dump for tabellen `role`
-- 

INSERT INTO `role` (`id`, `name`) VALUES 
(1, 'Admin'),
(2, 'Arbejdsgiver'),
(3, 'Hjælper');

-- --------------------------------------------------------

-- 
-- Struktur-dump for tabellen `site`
-- 

CREATE TABLE IF NOT EXISTS `site` (
  `id` tinyint(4) NOT NULL auto_increment,
  `name` varchar(32) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- 
-- Data dump for tabellen `site`
-- 

INSERT INTO `site` (`id`, `name`) VALUES 
(1, 'SEE 20-10 Jobcenter');

-- --------------------------------------------------------

-- 
-- Struktur-dump for tabellen `subcamp`
-- 

CREATE TABLE IF NOT EXISTS `subcamp` (
  `id` tinyint(4) NOT NULL auto_increment,
  `site_id` tinyint(4) NOT NULL,
  `name` varchar(64) NOT NULL,
  `district_id` tinyint(4) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `district_id` (`district_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- 
-- Data dump for tabellen `subcamp`
-- 

INSERT INTO `subcamp` (`id`, `site_id`, `name`, `district_id`) VALUES 
(1, 1, 'Grøn', 1),
(2, 1, 'Gul', 1);

-- 
-- Begrænsninger for dumpede tabeller
-- 

-- 
-- Begrænsninger for tabel `group`
-- 
ALTER TABLE `group`
  ADD CONSTRAINT `group_ibfk_1` FOREIGN KEY (`district_id`) REFERENCES `district` (`id`);

-- 
-- Begrænsninger for tabel `subcamp`
-- 
ALTER TABLE `subcamp`
  ADD CONSTRAINT `subcamp_ibfk_1` FOREIGN KEY (`district_id`) REFERENCES `district` (`id`);
