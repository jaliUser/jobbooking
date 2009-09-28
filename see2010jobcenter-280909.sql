-- phpMyAdmin SQL Dump
-- version 2.11.5.1
-- http://www.phpmyadmin.net
--
-- Vært: localhost
-- Genereringstid: 28. 09 2009 kl. 09:32:22
-- Serverversion: 5.0.51
-- PHP-version: 5.2.6

SET FOREIGN_KEY_CHECKS=0;

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `dbsee2010jobcenter`
--

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `area`
--

DROP TABLE IF EXISTS `area`;
CREATE TABLE `area` (
  `id` tinyint(4) NOT NULL auto_increment,
  `site_id` tinyint(4) NOT NULL,
  `name` varchar(64) NOT NULL,
  `description` varchar(255) NOT NULL,
  `contact_id` varchar(25) default NULL,
  `def_date` timestamp NULL default NULL,
  `def_user` varchar(25) default NULL,
  `upd_date` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `upd_user` varchar(25) default NULL,
  PRIMARY KEY  (`id`),
  KEY `site_id` (`site_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Data dump for tabellen `area`
--

INSERT INTO `area` (`id`, `site_id`, `name`, `description`, `contact_id`, `def_date`, `def_user`, `upd_date`, `upd_user`) VALUES
(1, 1, 'DOT', 'Drift og teknik', 'hansdaugaard', '2009-09-12 01:51:53', NULL, '2009-09-12 01:51:53', NULL),
(2, 1, 'AKT', 'Aktiviteter', 'jacoblarsen', '2009-09-12 01:51:53', NULL, '2009-09-12 01:51:53', NULL),
(3, 1, 'KLU', 'Korpslejrudvalget', 'joergenpaarup', '2009-09-12 01:53:21', NULL, '2009-09-12 01:53:21', NULL),
(4, 1, 'INT', 'International', 'johnboll', '2009-09-12 01:51:53', NULL, '2009-09-12 01:51:53', NULL),
(5, 1, 'KUL', 'Kultur', 'bebe', '2009-09-12 01:51:53', NULL, '2009-09-12 01:51:53', NULL),
(6, 1, 'LT', 'Landstræf', 'finndybbol', '2009-09-12 01:51:53', NULL, '2009-09-12 01:51:53', NULL),
(7, 1, 'ØKO', 'Økonomi', 'borgemoller', '2009-09-12 01:51:53', NULL, '2009-09-12 01:51:53', NULL),
(8, 1, 'INF', 'Infrastruktur', 'sorenyde', '2009-09-12 01:51:53', NULL, '2009-09-12 01:51:53', NULL),
(9, 1, 'PR', 'PR og kommunikation', 'jesperholm', '2009-09-12 01:51:53', NULL, '2009-09-12 01:51:53', NULL);

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `days`
--

DROP TABLE IF EXISTS `days`;
CREATE TABLE `days` (
  `id` tinyint(4) NOT NULL auto_increment,
  `site_id` tinyint(4) NOT NULL,
  `date` date NOT NULL,
  `time` int(11) default NULL,
  `def_date` timestamp NULL default NULL,
  `def_user` varchar(25) default NULL,
  `upd_date` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `upd_user` varchar(25) default NULL,
  PRIMARY KEY  (`id`),
  KEY `site_id` (`site_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Data dump for tabellen `days`
--

INSERT INTO `days` (`id`, `site_id`, `date`, `time`, `def_date`, `def_user`, `upd_date`, `upd_user`) VALUES
(1, 1, '2009-07-24', 120000, NULL, NULL, '0000-00-00 00:00:00', NULL),
(2, 1, '2009-07-25', NULL, NULL, NULL, '0000-00-00 00:00:00', NULL),
(3, 1, '2009-07-26', NULL, NULL, NULL, '0000-00-00 00:00:00', NULL),
(4, 1, '2009-07-27', NULL, NULL, NULL, '0000-00-00 00:00:00', NULL),
(5, 1, '2009-07-28', NULL, NULL, NULL, '0000-00-00 00:00:00', NULL),
(6, 1, '2009-07-29', NULL, NULL, NULL, '0000-00-00 00:00:00', NULL),
(7, 1, '2009-07-30', NULL, NULL, NULL, '0000-00-00 00:00:00', NULL),
(8, 1, '2009-07-31', NULL, NULL, NULL, '0000-00-00 00:00:00', NULL),
(9, 1, '2009-08-01', 160000, NULL, NULL, '0000-00-00 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `district`
--

DROP TABLE IF EXISTS `district`;
CREATE TABLE `district` (
  `id` tinyint(4) NOT NULL auto_increment,
  `site_id` tinyint(4) NOT NULL,
  `name` varchar(64) NOT NULL,
  `subcamp_id` tinyint(4) NOT NULL,
  `def_date` timestamp NULL default NULL,
  `def_user` varchar(25) default NULL,
  `upd_date` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `upd_user` varchar(25) default NULL,
  PRIMARY KEY  (`id`),
  KEY `site_id` (`site_id`),
  KEY `subcamp_id` (`subcamp_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=37 ;

--
-- Data dump for tabellen `district`
--

INSERT INTO `district` (`id`, `site_id`, `name`, `subcamp_id`, `def_date`, `def_user`, `upd_date`, `upd_user`) VALUES
(1, 1, 'Aalborg Distrikt', 8, NULL, NULL, '0000-00-00 00:00:00', NULL),
(2, 1, 'Aggersborg Distrikt', 4, NULL, NULL, '0000-00-00 00:00:00', NULL),
(3, 1, 'Bastrup Distrikt', 3, NULL, NULL, '0000-00-00 00:00:00', NULL),
(4, 1, 'Bornholms Distrikt', 4, NULL, NULL, '0000-00-00 00:00:00', NULL),
(5, 1, 'Danehof Distrikt', 1, NULL, NULL, '0000-00-00 00:00:00', NULL),
(6, 1, 'Djursland Distrikt', 6, NULL, NULL, '0000-00-00 00:00:00', NULL),
(7, 1, 'Ermelunden Distrikt', 8, NULL, NULL, '0000-00-00 00:00:00', NULL),
(8, 1, 'Fionia Distrikt', 3, NULL, NULL, '0000-00-00 00:00:00', NULL),
(9, 1, 'Gudenå Distrikt', 2, NULL, NULL, '0000-00-00 00:00:00', NULL),
(10, 1, 'Guldhorn Distrikt', 4, NULL, NULL, '0000-00-00 00:00:00', NULL),
(11, 1, 'Hafnia Distrikt', 5, NULL, NULL, '0000-00-00 00:00:00', NULL),
(12, 1, 'Hardsyssel Distrikt', 8, NULL, NULL, '0000-00-00 00:00:00', NULL),
(13, 1, 'Hjorte Distrikt', 2, NULL, NULL, '0000-00-00 00:00:00', NULL),
(14, 1, 'Ho Bugt Distrikt', 8, NULL, NULL, '0000-00-00 00:00:00', NULL),
(15, 1, 'Hærulf Distrikt', 3, NULL, NULL, '0000-00-00 00:00:00', NULL),
(16, 1, 'Hærvejens Distrikt', 2, NULL, NULL, '0000-00-00 00:00:00', NULL),
(17, 1, 'Kongeå Distrikt', 6, NULL, NULL, '0000-00-00 00:00:00', NULL),
(18, 1, 'Lindorm Distrikt', 1, NULL, NULL, '0000-00-00 00:00:00', NULL),
(19, 1, 'Lovring Distrikt', 1, NULL, NULL, '0000-00-00 00:00:00', NULL),
(20, 1, 'Lundenæs Len Distrikt', 5, NULL, NULL, '0000-00-00 00:00:00', NULL),
(21, 1, 'Lyngens Distrikt', 6, NULL, NULL, '0000-00-00 00:00:00', NULL),
(22, 1, 'Marselis Distrikt', 7, NULL, NULL, '0000-00-00 00:00:00', NULL),
(23, 1, 'Midtjyske Distrikt', 1, NULL, NULL, '0000-00-00 00:00:00', NULL),
(24, 1, 'Munkebjerg Distrikt', 5, NULL, NULL, '0000-00-00 00:00:00', NULL),
(25, 1, 'Nordøstjyske Distrikt', 3, NULL, NULL, '0000-00-00 00:00:00', NULL),
(26, 1, 'Nydam Distrikt', 8, NULL, NULL, '0000-00-00 00:00:00', NULL),
(27, 1, 'Odsherred Distrikt', 3, NULL, NULL, '0000-00-00 00:00:00', NULL),
(28, 1, 'Ole Rømer Distrikt', 4, NULL, NULL, '0000-00-00 00:00:00', NULL),
(29, 1, 'Sct. Georg Distrikt', 6, NULL, NULL, '0000-00-00 00:00:00', NULL),
(30, 1, 'Skamling Distrikt', 7, NULL, NULL, '0000-00-00 00:00:00', NULL),
(31, 1, 'Suså Distrikt', 7, NULL, NULL, '0000-00-00 00:00:00', NULL),
(32, 1, 'Thy Distrikt', 1, NULL, NULL, '0000-00-00 00:00:00', NULL),
(33, 1, 'Valdemar Distrikt', 4, NULL, NULL, '0000-00-00 00:00:00', NULL),
(34, 1, 'Vest-Vendsyssel Distrikt', 7, NULL, NULL, '0000-00-00 00:00:00', NULL),
(35, 1, 'Vestlimfjord Distrikt', 2, NULL, NULL, '0000-00-00 00:00:00', NULL),
(36, 1, 'Østvendsyssel Distrikt', 5, NULL, NULL, '0000-00-00 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `group`
--

DROP TABLE IF EXISTS `group`;
CREATE TABLE `group` (
  `id` smallint(6) NOT NULL auto_increment,
  `site_id` tinyint(4) NOT NULL,
  `name` varchar(64) NOT NULL,
  `district_id` tinyint(4) default NULL,
  `tmp_district_name` varchar(50) default NULL,
  `def_date` timestamp NULL default NULL,
  `def_user` varchar(25) default NULL,
  `upd_date` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `upd_user` varchar(25) default NULL,
  PRIMARY KEY  (`id`),
  KEY `district_id` (`district_id`),
  KEY `site_id` (`site_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9312 ;

--
-- Data dump for tabellen `group`
--

INSERT INTO `group` (`id`, `site_id`, `name`, `district_id`, `tmp_district_name`, `def_date`, `def_user`, `upd_date`, `upd_user`) VALUES
(0, 1, '- Ingen', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', NULL),
(10, 1, 'Gjellerup Gruppe', 21, 'Lyngens Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(11, 1, 'Ans', 9, 'Gudenå Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(603, 1, 'Filip Gruppe', 11, 'Hafnia Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(604, 1, 'Højdevang Gruppe', 11, 'Hafnia Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(609, 1, 'Kastrup Gruppe', 11, 'Hafnia Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(610, 1, 'St.Magleby-Dragør Gruppe', 11, 'Hafnia Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(611, 1, 'Tårnby Gruppe', 11, 'Hafnia Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(612, 1, 'Vestamager Gruppe', 11, 'Hafnia Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(803, 1, 'Klemensker Gruppe', 4, 'Bornholms Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(804, 1, 'Nexø Gruppe', 4, 'Bornholms Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(809, 1, 'Vestermarie/Nylars Gruppe', 4, 'Bornholms Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(810, 1, 'Aakirkeby Gruppe', 4, 'Bornholms Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(902, 1, '1. Frederiksberg Gruppe', 11, 'Hafnia Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(903, 1, '3. Frederiksberg Gruppe', 11, 'Hafnia Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(904, 1, '4. Frederiksberg Gruppe', 11, 'Hafnia Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(905, 1, 'Lindevang Gruppe', 11, 'Hafnia Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(1002, 1, 'Albertslund Gruppe', 28, 'Ole Rømer Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(1004, 1, 'Brøndby-Vallensbæk Gruppe', 28, 'Ole Rømer Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(1005, 1, 'Brøndbyvester Gruppe', 28, 'Ole Rømer Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(1006, 1, 'KNUDEN-Brøndby Gruppe', 28, 'Ole Rømer Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(1007, 1, 'Fløng Gruppe', 28, 'Ole Rømer Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(1009, 1, 'Greve Gruppe', 28, 'Ole Rømer Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(1010, 1, 'Ishøj Gruppe', 28, 'Ole Rømer Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(1011, 1, 'Tåstrup Gruppe', 28, 'Ole Rømer Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(1012, 1, 'Rønnevang-Tåstrup Gruppe', 28, 'Ole Rømer Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(1102, 1, 'Bispebjerg Gruppe', 11, 'Hafnia Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(1105, 1, 'Husumvold Gruppe', 11, 'Hafnia Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(1106, 1, 'Hyltebjerg Gruppe', 11, 'Hafnia Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(1110, 1, 'Sct. Johannes Gruppe', 11, 'Hafnia Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(1111, 1, 'St. Stefans Gruppe', 11, 'Hafnia Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(1115, 1, 'Vigerslev Gruppe', 11, 'Hafnia Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(1202, 1, 'Avedøre Gruppe', 28, 'Ole Rømer Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(1204, 1, 'Hvidovre Gruppe', 28, 'Ole Rømer Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(1205, 1, 'Vigar Stamme Gruppe', 28, 'Ole Rømer Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(1206, 1, 'Hvidovre Syd Gruppe', 28, 'Ole Rømer Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(1207, 1, 'Islev Gruppe', 28, 'Ole Rømer Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(1208, 1, 'Rødovre Gruppe', 28, 'Ole Rømer Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(1302, 1, 'Borggruppen Gruppe', 11, 'Hafnia Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(1303, 1, 'Hans Egede Gruppe', 11, 'Hafnia Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(1304, 1, 'Lundehus Gruppe', 11, 'Hafnia Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(1305, 1, 'Rosenvænget Gruppe', 11, 'Hafnia Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(1306, 1, 'Svanemølle Gruppe', 11, 'Hafnia Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(1502, 1, 'Frederikssund Gruppe', 13, 'Hjorte Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(1505, 1, 'Halsnæs Gruppe', 13, 'Hjorte Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(1506, 1, 'Jægerspris Gruppe', 13, 'Hjorte Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(1509, 1, 'Skævinge Gruppe', 13, 'Hjorte Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(1510, 1, 'Slangerup Gruppe', 13, 'Hjorte Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(1511, 1, 'Stenløse Gruppe', 3, 'Bastrup Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(1513, 1, 'Ølsted Sj. Gruppe', 13, 'Hjorte Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(1602, 1, 'Charlottenlund Gruppe', 7, 'Ermelunden Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(1604, 1, 'Hellerup Gruppe', 7, 'Ermelunden Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(1606, 1, 'Ordrup-Skovshoved Gruppe', 7, 'Ermelunden Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(1607, 1, 'Vangede Gruppe', 7, 'Ermelunden Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(1702, 1, 'Blistrup Gruppe', 13, 'Hjorte Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(1703, 1, 'Esbønderup Gruppe', 13, 'Hjorte Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(1704, 1, 'Espergærde Gruppe', 13, 'Hjorte Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(1705, 1, 'Gilleleje Gruppe', 13, 'Hjorte Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(1706, 1, 'Græsted Gruppe', 13, 'Hjorte Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(1708, 1, 'Tikøb Gruppe', 13, 'Hjorte Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(1802, 1, '2. Bagsværd Gruppe', 3, 'Bastrup Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(1803, 1, 'Buddinge Gruppe', 3, 'Bastrup Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(1808, 1, 'Søborg Gruppe', 3, 'Bastrup Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(1810, 1, 'Ballerup Gruppe', 3, 'Bastrup Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(1811, 1, 'Herlev Gruppe', 3, 'Bastrup Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(1812, 1, 'Klausdal-Hjortespring Gruppe', 3, 'Bastrup Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(1903, 1, '1. Bistrup Gruppe', 3, 'Bastrup Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(1905, 1, 'Hillerød Gruppe', 13, 'Hjorte Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(1906, 1, 'Hørsholm Gruppe', 3, 'Bastrup Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(1907, 1, 'Allerød-Lynge Gruppe', 3, 'Bastrup Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(1908, 1, 'Nivå Gruppe', 3, 'Bastrup Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(2104, 1, '1. Lyngby-Lundtofte', 7, 'Ermelunden Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(2105, 1, '3. Lyngby Gruppe', 7, 'Ermelunden Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(2106, 1, 'Nærum Gruppe', 7, 'Ermelunden Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(2107, 1, 'Vedbæk Gruppe', 7, 'Ermelunden Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(2108, 1, 'Virum-Sorgenfri Gruppe', 7, 'Ermelunden Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(2202, 1, 'Ølstykke Gruppe', 3, 'Bastrup Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(2203, 1, 'Østerhøj-Måløv Gruppe', 3, 'Bastrup Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(2502, 1, 'Buerup Gruppe', 31, 'Suså Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(2503, 1, 'Dianalund Gruppe', 31, 'Suså Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(2504, 1, 'Fjenneslev Gruppe', 31, 'Suså Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(2505, 1, 'Frederiksberg Gruppe', 31, 'Suså Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(2506, 1, 'Høng Gruppe', 31, 'Suså Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(2507, 1, 'Munke Bjergby Gruppe', 31, 'Suså Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(2602, 1, 'Engmose Gruppe', 18, 'Lindorm Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(2603, 1, 'Horbelev Gruppe', 18, 'Lindorm Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(2604, 1, 'Idestrup Gruppe', 18, 'Lindorm Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(2606, 1, 'Nykøbing Falster Gruppe', 18, 'Lindorm Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(2607, 1, 'Toreby Gruppe', 18, 'Lindorm Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(2610, 1, 'Nakskov Gruppe', 18, 'Lindorm Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(2612, 1, 'Ravnsborg Gruppe', 18, 'Lindorm Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(2613, 1, 'Brandstrup Gruppe', 18, 'Lindorm Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(2614, 1, 'Østofte Gruppe', 18, 'Lindorm Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(2702, 1, 'Eskebjerg Gruppe', 27, 'Odsherred Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(2703, 1, 'Holbæk Gruppe', 27, 'Odsherred Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(2705, 1, 'Kr. Eskilstrup Gruppe', 27, 'Odsherred Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(2706, 1, 'Nr. Asmindrup Gruppe', 27, 'Odsherred Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(2707, 1, 'Raklev Gruppe', 27, 'Odsherred Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(2708, 1, 'Svebølle Gruppe', 27, 'Odsherred Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(2709, 1, 'Tuse Bjerg Gruppe', 27, 'Odsherred Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(2710, 1, 'Nykøbing-Sjælland Gruppe', 27, 'Odsherred Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(2712, 1, 'Store Merløse Gruppe', 27, 'Odsherred Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(2713, 1, 'Vallekilde-Hørve Gruppe', 27, 'Odsherred Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(2902, 1, 'Bolund Gruppe', 29, 'Sct. Georg Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(2903, 1, 'Borup Gruppe', 29, 'Sct. Georg Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(2904, 1, 'Walburris', 29, 'Sct. Georg Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(2905, 1, 'Jyllinge Gruppe', 29, 'Sct. Georg Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(2907, 1, 'Karlslunde Gruppe', 29, 'Sct. Georg Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(2908, 1, 'Lejre Gruppe', 29, 'Sct. Georg Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(2910, 1, 'Roskilde Gruppe', 29, 'Sct. Georg Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(2911, 1, 'Svogerslev Gruppe', 29, 'Sct. Georg Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(2912, 1, 'Tune Gruppe', 29, 'Sct. Georg Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(2913, 1, 'Vindinge Gruppe', 29, 'Sct. Georg Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(2914, 1, 'Sct.Jørgen/2.Roskilde Gruppe', 29, 'Sct. Georg Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(2915, 1, 'Trekroner', 29, 'Sct. Georg Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(2916, 1, 'Skuldelev 2', 29, 'Sct. Georg Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(3002, 1, 'Hammer S. Gruppe', 33, 'Valdemar Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(3004, 1, 'Herlufmagle Gruppe', 31, 'Suså Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(3005, 1, 'Herlufsholm Gruppe', 31, 'Suså Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(3006, 1, 'Hyllinge Gruppe', 31, 'Suså Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(3007, 1, 'Kalvehave Gruppe', 33, 'Valdemar Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(3008, 1, 'Karrebæk Gruppe', 31, 'Suså Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(3009, 1, 'Kastrup-Ndr Vindinge Gruppe', 33, 'Valdemar Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(3010, 1, 'Lundby Gruppe', 33, 'Valdemar Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(3011, 1, 'Suså-Næstved Gruppe', 31, 'Suså Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(3012, 1, 'Præstø Gruppe', 33, 'Valdemar Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(3014, 1, 'Toksværd Gruppe', 33, 'Valdemar Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(3015, 1, 'Tybjerg Gruppe', 33, 'Valdemar Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(3016, 1, 'Fensmark Gruppe', 31, 'Suså Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(3017, 1, 'Tappernøje Gruppe', 33, 'Valdemar Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(3018, 1, 'Bogø Gruppe', 18, 'Lindorm Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(3102, 1, 'Fuglebjerg Gruppe', 31, 'Suså Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(3103, 1, 'Glumsø Gruppe', 31, 'Suså Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(3104, 1, '1. Skælskør Gruppe', 31, 'Suså Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(3106, 1, '1. Slagelse Gruppe', 31, 'Suså Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(3107, 1, '2. Slagelse Gruppe', 31, 'Suså Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(3108, 1, 'Stillinge Gruppe', 31, 'Suså Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(3109, 1, 'Sørbymagle Gruppe', 31, 'Suså Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(3110, 1, 'Tårnborg Gruppe', 31, 'Suså Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(3112, 1, 'Tornemark-Sandved Gruppe', 31, 'Suså Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(3203, 1, 'Bjergbakke Gruppe', 33, 'Valdemar Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(3205, 1, 'Ejby Gruppe', 33, 'Valdemar Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(3206, 1, 'Haslev Gruppe', 33, 'Valdemar Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(3207, 1, 'Peder Syv - Hellested Gruppe', 33, 'Valdemar Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(3208, 1, 'Højelse Gruppe', 33, 'Valdemar Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(3209, 1, 'Jersie-Solrød Gruppe', 33, 'Valdemar Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(3211, 1, 'Kongsted Gruppe', 33, 'Valdemar Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(3212, 1, 'Huitfeldt/Køge Gruppe', 33, 'Valdemar Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(3213, 1, 'Havdrup gruppe', 33, 'Valdemar Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(3215, 1, 'Nordrupøster Gruppe', 33, 'Valdemar Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(3216, 1, 'Ringsted Gruppe', 33, 'Valdemar Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(3217, 1, 'Stevns-Nord Gruppe', 33, 'Valdemar Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(3218, 1, 'Sædder Gruppe', 33, 'Valdemar Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(3219, 1, 'Sølvbæk Gruppe', 33, 'Valdemar Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(3220, 1, 'Vallø Gruppe', 33, 'Valdemar Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(3222, 1, 'Ølsemagle Gruppe', 33, 'Valdemar Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(3223, 1, 'Fakse Gruppe', 33, 'Valdemar Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(3602, 1, 'Dalum Gruppe', 8, 'Fionia Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(3603, 1, 'Højby Gruppe', 5, 'Danehof Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(3605, 1, 'Langeskov Gruppe', 5, 'Danehof Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(3606, 1, 'Nr. Lyndelse Gruppe', 5, 'Danehof Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(3607, 1, 'Sct. Knuds gruppe', 8, 'Fionia Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(3610, 1, '6. Odense Gruppe', 5, 'Danehof Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(3612, 1, 'Tornbjerg Gruppe', 8, 'Fionia Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(3613, 1, 'Bellinge Gruppe', 8, 'Fionia Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(3614, 1, 'Gråbrødre/Odense Gruppe', 8, 'Fionia Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(3615, 1, 'Kertinge Gruppe', 5, 'Danehof Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(3616, 1, 'Årslev Gruppe', 5, 'Danehof Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(3702, 1, 'Assens Gruppe', 8, 'Fionia Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(3703, 1, 'Dreslette Gruppe', 8, 'Fionia Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(3704, 1, 'Hårby Gruppe', 8, 'Fionia Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(3705, 1, 'Middelfart Gruppe', 8, 'Fionia Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(3706, 1, 'Nr. Højrup Gruppe', 8, 'Fionia Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(3707, 1, 'Nr. Åby Gruppe', 8, 'Fionia Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(3708, 1, 'Otterup Gruppe', 8, 'Fionia Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(3709, 1, 'Søndersø Gruppe', 8, 'Fionia Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(3710, 1, 'Tommerup Gruppe', 8, 'Fionia Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(3711, 1, 'Verninge Gruppe', 8, 'Fionia Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(3712, 1, 'Vissenbjerg Gruppe', 8, 'Fionia Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(3713, 1, 'Bogense Gruppe', 8, 'Fionia Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(3714, 1, 'Husby-Tanderup Gruppe', 8, 'Fionia Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(3802, 1, 'Brahetrolleborg Gruppe', 5, 'Danehof Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(3803, 1, 'Broby Gruppe', 5, 'Danehof Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(3804, 1, 'Gislev Gruppe', 5, 'Danehof Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(3805, 1, 'Herrested Gruppe', 5, 'Danehof Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(3807, 1, 'Marstal Gruppe', 5, 'Danehof Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(3808, 1, 'Nyborg Gruppe', 5, 'Danehof Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(3809, 1, 'Ringe Gruppe', 5, 'Danehof Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(3810, 1, 'Rise Gruppe', 5, 'Danehof Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(3811, 1, 'Rudkøbing Gruppe', 5, 'Danehof Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(3812, 1, 'Stenstrup Gruppe', 5, 'Danehof Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(3813, 1, 'Svendborg Gruppe', 5, 'Danehof Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(3816, 1, 'Åkilde Gruppe', 5, 'Danehof Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(3817, 1, 'Ådal-Broby Gruppe', 5, 'Danehof Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(3819, 1, 'Kongshøj Gruppe', 5, 'Danehof Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(4102, 1, 'Fynshav Gruppe', 26, 'Nydam Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(4103, 1, 'Hjortspring Gruppe', 26, 'Nydam Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(4104, 1, 'Høruphav Gruppe', 26, 'Nydam Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(4105, 1, 'Kegnæs Gruppe', 26, 'Nydam Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(4106, 1, 'Nordborg Gruppe', 26, 'Nydam Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(4107, 1, 'Sønderborg Gruppe', 26, 'Nydam Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(4109, 1, 'Dybbøl Gruppe', 26, 'Nydam Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(4110, 1, 'Lysabild Gruppe', 26, 'Nydam Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(4202, 1, 'Fole Gruppe', 17, 'Kongeå Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(4204, 1, 'Jels Gruppe', 17, 'Kongeå Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(4205, 1, 'Lintrup Gruppe', 17, 'Kongeå Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(4207, 1, 'Skodborg Gruppe', 17, 'Kongeå Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(4209, 1, 'Tiset/Arnum Gruppe', 17, 'Kongeå Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(4302, 1, 'Abild Gruppe', 10, 'Guldhorn Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(4303, 1, 'Ballum Gruppe', 10, 'Guldhorn Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(4304, 1, 'Bedsted Lø Gruppe', 10, 'Guldhorn Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(4305, 1, 'Brøns Gruppe', 10, 'Guldhorn Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(4306, 1, 'Døstrup Gruppe', 10, 'Guldhorn Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(4307, 1, 'Løgumkloster Gruppe', 10, 'Guldhorn Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(4308, 1, 'Nr. Løgum Gruppe', 10, 'Guldhorn Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(4309, 1, 'Rømø Gruppe', 10, 'Guldhorn Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(4310, 1, 'Visby Gruppe', 10, 'Guldhorn Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(4311, 1, 'Øster Højst Gruppe', 10, 'Guldhorn Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(4312, 1, 'Tønder Gruppe', 10, 'Guldhorn Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(4402, 1, 'Ensted Gruppe', 15, 'Hærulf Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(4403, 1, 'Felsted Gruppe', 26, 'Nydam Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(4405, 1, 'Hjordkær Gruppe', 15, 'Hærulf Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(4407, 1, 'Løjt Kirkeby Gruppe', 15, 'Hærulf Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(4408, 1, 'Rødekro Gruppe', 15, 'Hærulf Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(4409, 1, 'Aabenraa Gruppe', 15, 'Hærulf Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(4502, 1, 'Slogs Herred Gruppe', 10, 'Guldhorn Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(4504, 1, 'Rinkenæs Gruppe', 26, 'Nydam Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(4505, 1, 'Sundeved Gruppe', 26, 'Nydam Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(4506, 1, 'Urnehoved Gruppe', 26, 'Nydam Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(4507, 1, 'Ravsted Gruppe', 10, 'Guldhorn Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(4508, 1, 'Kruså-Kollund Gruppe', 26, 'Nydam Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(4602, 1, 'Haderslev Gruppe', 15, 'Hærulf Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(4603, 1, 'Immervad Gruppe', 15, 'Hærulf Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(4604, 1, 'Sommersted Gruppe', 15, 'Hærulf Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(4605, 1, 'Falke-Starup Gruppe', 15, 'Hærulf Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(4606, 1, 'Vojens Gruppe', 15, 'Hærulf Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(4607, 1, 'Ådals-Hoptrup Gruppe', 15, 'Hærulf Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(4609, 1, 'Gabøl-Nustrup Gruppe', 15, 'Hærulf Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(4610, 1, 'Jegerup Gruppe', 15, 'Hærulf Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(4902, 1, 'Andst Gruppe', 16, 'Hærvejens Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(4903, 1, 'Bække Gruppe', 16, 'Hærvejens Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(4904, 1, 'Egtved Gruppe', 16, 'Hærvejens Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(4906, 1, 'Jordrup Gruppe', 16, 'Hærvejens Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(4907, 1, 'Randbøl Gruppe', 16, 'Hærvejens Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(4908, 1, 'Vejen Gruppe', 16, 'Hærvejens Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(4909, 1, 'Ø.Starup-V.Nebel Gruppe', 16, 'Hærvejens Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(4910, 1, 'Ødsted Gruppe', 16, 'Hærvejens Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(4912, 1, 'Læborg Gruppe', 16, 'Hærvejens Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(5002, 1, 'Alminde-Viuf Gruppe', 30, 'Skamling Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(5003, 1, 'Bramdrup Gruppe', 30, 'Skamling Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(5004, 1, 'Houens Odde Gruppe', 30, 'Skamling Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(5006, 1, '5. Kolding Gruppe', 30, 'Skamling Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(5008, 1, 'Seest Gruppe', 30, 'Skamling Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(5009, 1, 'Vonsild Gruppe', 30, 'Skamling Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(5102, 1, 'Christiansfeld Gruppe', 30, 'Skamling Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(5103, 1, 'Hjarup Gruppe', 30, 'Skamling Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(5104, 1, 'Sdr. Bjert Gruppe', 30, 'Skamling Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(5105, 1, 'Stepping Gruppe', 30, 'Skamling Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(5106, 1, 'Vamdrup Gruppe', 30, 'Skamling Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(5107, 1, 'Ødis Gruppe', 30, 'Skamling Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(5108, 1, 'Sdr. Stenderup Gruppe', 30, 'Skamling Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(5110, 1, 'Fjelstrup Gruppe', 15, 'Hærulf Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(5302, 1, 'Mariesminde Gruppe', 30, 'Skamling Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(5404, 1, '4. Esbjerg Gruppe', 14, 'Ho Bugt Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(5405, 1, 'Fanø Gruppe', 14, 'Ho Bugt Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(5406, 1, 'Bryndum Gruppe', 14, 'Ho Bugt Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(5407, 1, 'Ådalsgruppen Gruppe', 14, 'Ho Bugt Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(5408, 1, 'Kvaglund Gruppe', 14, 'Ho Bugt Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(5410, 1, 'Fourfeld Gruppe', 14, 'Ho Bugt Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(5412, 1, 'Guldager Gruppe', 14, 'Ho Bugt Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(5502, 1, 'Bramming Gruppe', 17, 'Kongeå Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(5503, 1, 'Brørup Gruppe', 17, 'Kongeå Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(5504, 1, 'Gørding Gruppe', 17, 'Kongeå Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(5505, 1, 'Hejnsvig Gruppe', 16, 'Hærvejens Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(5506, 1, 'Holsted-Glejbjerg Gruppe', 17, 'Kongeå Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(5507, 1, 'Lindknud Gruppe', 17, 'Kongeå Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(5508, 1, 'Kongeaadal Gruppe', 17, 'Kongeå Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(5509, 1, 'Ribe-Hviding Gruppe', 17, 'Kongeå Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(5510, 1, 'Vorbasse Gruppe', 16, 'Hærvejens Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(5511, 1, 'Vejrup Gruppe', 17, 'Kongeå Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(5512, 1, 'Føvling Gruppe', 17, 'Kongeå Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(5602, 1, 'Alslev Gruppe', 14, 'Ho Bugt Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(5603, 1, 'Grimstrup-Årre Gruppe', 17, 'Kongeå Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(5604, 1, 'Horne-Tistrup Gruppe', 20, 'Lundenæs Len Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(5605, 1, 'Janderup Gruppe', 14, 'Ho Bugt Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(5606, 1, 'Oksbøl Gruppe', 14, 'Ho Bugt Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(5607, 1, 'Outrup Gruppe', 14, 'Ho Bugt Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(5609, 1, 'Skads Gruppe', 14, 'Ho Bugt Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(5610, 1, 'Skovlund Gruppe', 20, 'Lundenæs Len Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(5611, 1, 'Vester Nebel Gruppe', 14, 'Ho Bugt Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(5612, 1, 'Gårde Gruppe', 20, 'Lundenæs Len Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(5902, 1, 'Brejning Gruppe', 24, 'Munkebjerg Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(5903, 1, 'Børkop Gruppe', 24, 'Munkebjerg Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(5904, 1, 'Gårslev Gruppe', 24, 'Munkebjerg Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(5905, 1, 'Smidstrup Gruppe', 24, 'Munkebjerg Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(6002, 1, 'Bülow Gruppe', 24, 'Munkebjerg Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(6003, 1, 'De Meza Gruppe', 24, 'Munkebjerg Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(6004, 1, 'Peder Griib Gruppe, Erritsø', 24, 'Munkebjerg Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(6005, 1, 'Olaf Rye Gruppe', 24, 'Munkebjerg Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(6006, 1, 'Skærbæk Gruppe', 24, 'Munkebjerg Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(6008, 1, 'Taulov Gruppe', 24, 'Munkebjerg Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(6102, 1, 'Bredballe Gruppe', 24, 'Munkebjerg Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(6103, 1, 'Grejs-Lindved Gruppe', 19, 'Lovring Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(6104, 1, 'Højen Gruppe', 24, 'Munkebjerg Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(6105, 1, 'Vejle Gruppe', 24, 'Munkebjerg Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(6107, 1, 'Runefolket', 19, 'Lovring Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(6109, 1, 'Engum Gruppe', 24, 'Munkebjerg Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(6202, 1, 'Billund Gruppe', 16, 'Hærvejens Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(6203, 1, 'Ejstrupholm Gruppe', 21, 'Lyngens Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(6205, 1, 'Langelund-Karlskov Gruppe', 21, 'Lyngens Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(6206, 1, 'Thyregod-Vester Gruppe', 21, 'Lyngens Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(6207, 1, 'Givskud Gruppe', 21, 'Lyngens Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(6208, 1, 'Hærvejs Gruppe', 21, 'Lyngens Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(6303, 1, 'Gjern Gruppe', 9, 'Gudenå Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(6305, 1, 'Kjellerup Gruppe', 23, 'Midtjyske Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(6306, 1, 'Levring-Højbjerg Gruppe', 23, 'Midtjyske Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(6308, 1, 'Låsby Gruppe', 9, 'Gudenå Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(6309, 1, 'Thorsø Gruppe', 9, 'Gudenå Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(6310, 1, 'Silkeborg Gruppe', 9, 'Gudenå Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(6311, 1, 'Them Gruppe', 9, 'Gudenå Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(6312, 1, 'Ulstrup Gruppe', 23, 'Midtjyske Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(6314, 1, 'Vinderslev Gruppe', 23, 'Midtjyske Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(6316, 1, 'Fårvang Gruppe', 9, 'Gudenå Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(6319, 1, 'Nørreå Gruppe, Viborg', 23, 'Midtjyske Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(6322, 1, 'Gjessø Gruppe', 9, 'Gudenå Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(6324, 1, 'Bjerringbro Gruppe', 23, 'Midtjyske Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(6402, 1, 'Flemming Gruppe', 19, 'Lovring Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(6403, 1, 'Hedensted Gruppe', 19, 'Lovring Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(6404, 1, 'Løsning Gruppe', 19, 'Lovring Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(6405, 1, 'Rårup Gruppe', 19, 'Lovring Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(6406, 1, 'Stouby', 19, 'Lovring Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(6407, 1, 'Tørring Gruppe', 19, 'Lovring Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(6408, 1, 'Voerladegård Gruppe', 19, 'Lovring Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(6409, 1, 'Ølsted Gruppe', 19, 'Lovring Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(6410, 1, 'Øster Snede Gruppe', 19, 'Lovring Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(6411, 1, 'Glud-Snaptun Gruppe', 19, 'Lovring Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(6412, 1, 'Brædstrup Gruppe', 19, 'Lovring Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(6502, 1, 'Egebjerg Gruppe', 19, 'Lovring Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(6503, 1, 'Hatting Gruppe', 19, 'Lovring Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(6504, 1, 'Horsens Gruppe', 19, 'Lovring Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(6505, 1, 'Søvind Gruppe', 19, 'Lovring Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(6506, 1, 'Stensballe Gruppe', 19, 'Lovring Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(6507, 1, 'Bankager Gruppe', 19, 'Lovring Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(6509, 1, 'Lund Gruppe', 19, 'Lovring Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(6802, 1, 'Astrup Gruppe', 20, 'Lundenæs Len Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(6803, 1, 'Bork Gruppe', 20, 'Lundenæs Len Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(6804, 1, 'Hoven Gruppe', 20, 'Lundenæs Len Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(6805, 1, 'Lem Gruppe', 20, 'Lundenæs Len Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(6806, 1, 'Ringkøbing Gruppe', 20, 'Lundenæs Len Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(6807, 1, 'Rækker Mølle Gruppe', 20, 'Lundenæs Len Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(6808, 1, 'Sdr. Vium Gruppe', 20, 'Lundenæs Len Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(6809, 1, 'Tarm Gruppe', 20, 'Lundenæs Len Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(6810, 1, 'Lønborg-Vostrup Gruppe', 20, 'Lundenæs Len Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(6811, 1, 'Stauning-Dejbjerg Gruppe', 20, 'Lundenæs Len Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(6812, 1, 'Vorgod-Barde Gruppe', 20, 'Lundenæs Len Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(6902, 1, 'Borbjerg Gruppe', 12, 'Hardsyssel Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(6904, 1, 'Hodsager Gruppe', 12, 'Hardsyssel Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(6905, 1, '1. Holstebro Gruppe', 12, 'Hardsyssel Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(6907, 1, '3. Holstebro Ellebæk Gruppe', 12, 'Hardsyssel Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(6908, 1, 'Idom-Råsted Gruppe', 12, 'Hardsyssel Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(6909, 1, 'Mejrup Gruppe', 12, 'Hardsyssel Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(6910, 1, 'Ryde-Handbjerg Gruppe', 12, 'Hardsyssel Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(6911, 1, 'Sevel Gruppe', 12, 'Hardsyssel Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(6912, 1, 'Ulfborg Gruppe', 12, 'Hardsyssel Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(6913, 1, 'Vinderup Gruppe', 12, 'Hardsyssel Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(6914, 1, 'Vinding Gruppe', 12, 'Hardsyssel Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(6915, 1, 'Hjelm Hede Gruppe', 12, 'Hardsyssel Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(6916, 1, 'Vemb Gruppe', 12, 'Hardsyssel Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(7004, 1, 'Sct. Johannes Gruppe', 21, 'Lyngens Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(7005, 1, 'Sdr. Felding Gruppe', 21, 'Lyngens Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(7006, 1, 'Snejbjerg Gruppe', 21, 'Lyngens Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(7007, 1, 'Tjørring Gruppe', 21, 'Lyngens Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(7009, 1, 'Vildbjerg Gruppe', 21, 'Lyngens Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(7010, 1, 'Ørre-Sinding Gruppe', 21, 'Lyngens Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(7011, 1, 'Skibbild-Nøvling Gruppe', 21, 'Lyngens Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(7012, 1, 'Fasterholt Gruppe', 21, 'Lyngens Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(7013, 1, 'Ikast Gruppe', 21, 'Lyngens Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(7015, 1, 'Engesvang Gruppe', 21, 'Lyngens Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(7302, 1, 'Allingåbro Gruppe', 6, 'Djursland Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(7303, 1, 'Auning Gruppe', 6, 'Djursland Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(7305, 1, 'Fornæs Gruppe', 6, 'Djursland Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(7306, 1, 'Rønde Gruppe', 6, 'Djursland Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(7307, 1, 'Sivested Gruppe', 6, 'Djursland Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(7308, 1, 'Tirstrup Gruppe', 6, 'Djursland Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(7309, 1, 'Vivild Gruppe', 6, 'Djursland Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(7310, 1, 'Ørum Djurs Gruppe', 6, 'Djursland Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(7315, 1, 'Thorsager Gruppe', 6, 'Djursland Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(7316, 1, 'Vejlby-Grenaa Gruppe', 6, 'Djursland Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(7317, 1, 'Ådalen-Djurs Gruppe', 6, 'Djursland Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(7402, 1, 'Lystrup-Elsted Gruppe', 22, 'Marselis Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(7403, 1, 'Kaløvig Gruppe', 22, 'Marselis Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(7404, 1, 'Spørring-Trige Gruppe', 22, 'Marselis Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(7405, 1, 'Todbjerg-Mejlby Gruppe', 22, 'Marselis Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(7410, 1, '2. Århus Gruppe', 22, 'Marselis Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(7413, 1, 'Skelager Gruppe', 22, 'Marselis Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(7502, 1, 'Brabrand Gruppe', 22, 'Marselis Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(7504, 1, 'Hadsten Gruppe', 9, 'Gudenå Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(7505, 1, 'Hammel Gruppe', 9, 'Gudenå Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(7506, 1, 'Harlev-Framlev Gruppe', 9, 'Gudenå Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(7508, 1, 'Herskind Gruppe', 9, 'Gudenå Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(7510, 1, 'Sabro Gruppe', 9, 'Gudenå Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(7511, 1, 'Skjoldhøj Gruppe', 22, 'Marselis Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(7512, 1, 'Skovby Gruppe', 9, 'Gudenå Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(7513, 1, 'Søften Gruppe', 9, 'Gudenå Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(7514, 1, 'Åbyhøj Gruppe', 22, 'Marselis Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(7515, 1, 'Stjær Gruppe', 9, 'Gudenå Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(7702, 1, 'Dronningborg Gruppe', 25, 'Nordøstjyske Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(7703, 1, 'Gjerlev Gruppe', 25, 'Nordøstjyske Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(7704, 1, 'Havndal Gruppe', 25, 'Nordøstjyske Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(7706, 1, 'Hungstrup Gruppe', 25, 'Nordøstjyske Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(7707, 1, 'Sct. Clemens Gruppe', 25, 'Nordøstjyske Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(7708, 1, 'Spentrup Gruppe', 25, 'Nordøstjyske Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(7709, 1, 'Vorup-Kristrup Gruppe', 25, 'Nordøstjyske Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(7710, 1, 'Råby Gruppe', 25, 'Nordøstjyske Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(7903, 1, '1. Viby J. Gruppe', 22, 'Marselis Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(7904, 1, 'Ejer Baunehøj Gruppe', 19, 'Lovring Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(7905, 1, 'Fredens Sogn Gruppe', 22, 'Marselis Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(7906, 1, 'Hundslund Gruppe', 19, 'Lovring Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(7907, 1, 'Mårslet Gruppe', 22, 'Marselis Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(7909, 1, 'Stautrup Gruppe', 22, 'Marselis Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(7910, 1, 'Stilling Gruppe', 9, 'Gudenå Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(7911, 1, 'Veng Gruppe', 9, 'Gudenå Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(8103, 1, 'Fabjerg Gruppe', 12, 'Hardsyssel Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(8104, 1, 'Tangsø Gruppe', 12, 'Hardsyssel Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(8105, 1, 'Gudum Gruppe', 12, 'Hardsyssel Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(8106, 1, 'Langhøj Gruppe', 12, 'Hardsyssel Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(8107, 1, 'Lemvig Gruppe', 12, 'Hardsyssel Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(8108, 1, 'Lomborg-Rom Gruppe', 12, 'Hardsyssel Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(8109, 1, 'Nr. Nissum Gruppe', 12, 'Hardsyssel Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(8110, 1, 'Resen-Humlum Gruppe', 12, 'Hardsyssel Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(8112, 1, 'Struer Gruppe', 12, 'Hardsyssel Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(8113, 1, 'Dybe-Ramme Gruppe', 12, 'Hardsyssel Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(8202, 1, 'Bedsted Gruppe', 32, 'Thy Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(8203, 1, 'Frøstrup Gruppe', 32, 'Thy Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(8204, 1, 'Hanstholm-Ræhr Gruppe', 32, 'Thy Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(8206, 1, 'Hunstrup-Østerild Gruppe', 32, 'Thy Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(8207, 1, 'Hørdum Gruppe', 32, 'Thy Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(8209, 1, 'Nors Gruppe', 32, 'Thy Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(8210, 1, 'Skjoldborg Gruppe', 32, 'Thy Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(8211, 1, 'Stagstrup Gruppe', 32, 'Thy Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(8212, 1, 'Thisted Gruppe', 32, 'Thy Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(8213, 1, 'Vandet Gruppe', 32, 'Thy Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(8214, 1, 'Vestervig Gruppe', 32, 'Thy Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(8215, 1, 'Sjørring Gruppe', 32, 'Thy Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(8216, 1, 'Boddum/Ydby Gruppe', 32, 'Thy Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(8302, 1, 'Bruddal Gruppe', 35, 'Vestlimfjord Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(8303, 1, 'Durup Gruppe', 35, 'Vestlimfjord Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(8304, 1, 'Frøslev-Mollerup Gruppe', 35, 'Vestlimfjord Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(8305, 1, 'Fur Gruppe', 35, 'Vestlimfjord Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(8307, 1, 'Lem-Brodal Gruppe', 35, 'Vestlimfjord Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(8308, 1, 'Nykøbing Mors Gruppe', 35, 'Vestlimfjord Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(8309, 1, 'Roslev Gruppe', 35, 'Vestlimfjord Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(8310, 1, 'Skivehus Gruppe', 35, 'Vestlimfjord Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(8311, 1, 'Spøttrup Gruppe', 35, 'Vestlimfjord Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(8312, 1, 'Sydvest Mors Gruppe', 35, 'Vestlimfjord Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(8314, 1, 'Vejerslev Gruppe', 35, 'Vestlimfjord Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(8316, 1, 'Flyndersø Gruppe', 35, 'Vestlimfjord Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(8317, 1, 'Balling Gruppe', 35, 'Vestlimfjord Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(8320, 1, 'Jenle Gruppe', 35, 'Vestlimfjord Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(8324, 1, 'Hem Gruppe', 35, 'Vestlimfjord Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(8602, 1, 'Bonderup Gruppe', 2, 'Aggersborg Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(8603, 1, 'Brovst Gruppe', 2, 'Aggersborg Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(8604, 1, 'Fjerritslev Gruppe', 2, 'Aggersborg Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(8605, 1, 'Kettrup Gruppe', 2, 'Aggersborg Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(8606, 1, 'Skovsgård Gruppe', 2, 'Aggersborg Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(8608, 1, 'Tranum Gruppe', 2, 'Aggersborg Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(8609, 1, 'Øland Gruppe', 2, 'Aggersborg Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(8702, 1, 'Klejtrup Gruppe', 23, 'Midtjyske Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(8704, 1, 'Møldrup Gruppe', 23, 'Midtjyske Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(8706, 1, 'Skals Gruppe', 23, 'Midtjyske Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(8708, 1, 'Ulbjerg Gruppe', 23, 'Midtjyske Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(8709, 1, 'Langsø Gruppe', 23, 'Midtjyske Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(8802, 1, 'Farsø Gruppe', 2, 'Aggersborg Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(8803, 1, 'Hvalpsund Gruppe', 2, 'Aggersborg Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(8804, 1, 'Hvam Gruppe', 2, 'Aggersborg Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(8805, 1, 'Mejlby Gruppe', 2, 'Aggersborg Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(8806, 1, 'Fjord-Strandby Gruppe', 2, 'Aggersborg Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(8807, 1, 'Ullits Gruppe', 2, 'Aggersborg Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(8808, 1, 'Vegger Gruppe', 2, 'Aggersborg Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(8809, 1, 'Vesterbølle Gruppe', 2, 'Aggersborg Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(8810, 1, 'Vestrup Gruppe', 2, 'Aggersborg Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(8811, 1, 'Aalestrup Gruppe', 2, 'Aggersborg Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(8902, 1, 'Bindslev Gruppe', 34, 'Vest-Vendsyssel Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(8903, 1, 'Bistrup Gruppe', 34, 'Vest-Vendsyssel Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(8904, 1, 'Bjergby-Mygdal Gruppe', 34, 'Vest-Vendsyssel Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(8905, 1, 'Hirtshals Gruppe', 34, 'Vest-Vendsyssel Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(8906, 1, 'Sct.Catharinae,Hjørring Gruppe', 34, 'Vest-Vendsyssel Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(8907, 1, 'Horne Gruppe', 34, 'Vest-Vendsyssel Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(8908, 1, 'Højene Gruppe', 34, 'Vest-Vendsyssel Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(8909, 1, 'Løkken Gruppe', 34, 'Vest-Vendsyssel Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(8910, 1, 'Rakkeby Gruppe', 34, 'Vest-Vendsyssel Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(8911, 1, 'Skallerup-Vennebjerg Gruppe', 34, 'Vest-Vendsyssel Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(8912, 1, 'Tornby-Vidstrup Gruppe', 34, 'Vest-Vendsyssel Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(8913, 1, 'Vejby Gruppe', 34, 'Vest-Vendsyssel Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(8915, 1, 'Vrå Gruppe', 34, 'Vest-Vendsyssel Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(8916, 1, 'Poulstrup Gruppe', 34, 'Vest-Vendsyssel Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(8917, 1, 'Saltum Gruppe', 34, 'Vest-Vendsyssel Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(8918, 1, 'Kaas-Moseby Gruppe', 34, 'Vest-Vendsyssel Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(9002, 1, 'Bælum-Solbjerg Gruppe', 25, 'Nordøstjyske Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(9003, 1, 'Gerding-Blenstrup Gruppe', 25, 'Nordøstjyske Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(9004, 1, 'Kongerslev Gruppe', 25, 'Nordøstjyske Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(9005, 1, 'Mou Gruppe', 25, 'Nordøstjyske Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(9006, 1, 'Rosendal Gruppe', 25, 'Nordøstjyske Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(9007, 1, 'Valsgård Gruppe', 25, 'Nordøstjyske Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(9103, 1, 'Dybvad Gruppe', 36, 'Østvendsyssel Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(9105, 1, 'Hallund Gruppe', 36, 'Østvendsyssel Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(9106, 1, 'Hørby Gruppe', 36, 'Østvendsyssel Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(9107, 1, 'Jerslev Gruppe', 36, 'Østvendsyssel Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(9113, 1, 'Ousen Gruppe', 36, 'Østvendsyssel Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(9115, 1, 'Serritslev Gruppe', 36, 'Østvendsyssel Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(9118, 1, 'Østervrå Gruppe', 36, 'Østvendsyssel Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(9119, 1, 'Asaa Gruppe', 36, 'Østvendsyssel Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(9120, 1, 'Thorshøj Gruppe', 36, 'Østvendsyssel Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(9121, 1, 'Ulsted Gruppe', 36, 'Østvendsyssel Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(9202, 1, 'Cimbrerne Gruppe', 1, 'Aalborg Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(9205, 1, 'Gjøl Gruppe', 1, 'Aalborg Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(9206, 1, 'Langholt Gruppe', 1, 'Aalborg Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(9207, 1, 'Knuden, Aalborg Gruppe', 1, 'Aalborg Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(9208, 1, 'Lindholm Gruppe', 1, 'Aalborg Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(9209, 1, 'Nørresundby Gruppe', 1, 'Aalborg Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(9210, 1, 'Sct. Jørgen Gruppe', 1, 'Aalborg Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(9211, 1, 'Sulsted-Tylstrup Gruppe', 1, 'Aalborg Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(9212, 1, 'Åbybro Gruppe', 1, 'Aalborg Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL);
INSERT INTO `group` (`id`, `site_id`, `name`, `district_id`, `tmp_district_name`, `def_date`, `def_user`, `upd_date`, `upd_user`) VALUES
(9213, 1, 'Svenstrup Gruppe', 1, 'Aalborg Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(9216, 1, 'Øster Uttrup Gruppe', 1, 'Aalborg Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(9217, 1, 'Flejgdal Gruppe', 1, 'Aalborg Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(9302, 1, 'Frederikshavn Gruppe', 36, 'Østvendsyssel Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(9303, 1, 'Gærum Gruppe', 36, 'Østvendsyssel Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(9304, 1, 'Hørmested Gruppe', 36, 'Østvendsyssel Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(9305, 1, 'Kvissel Gruppe', 36, 'Østvendsyssel Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(9306, 1, 'Lendum Gruppe', 36, 'Østvendsyssel Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(9308, 1, 'Lørslev Gruppe', 34, 'Vest-Vendsyssel Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(9309, 1, 'Mosbjerg Gruppe', 36, 'Østvendsyssel Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(9310, 1, 'Ravnshøj Gruppe', 36, 'Østvendsyssel Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL),
(9311, 1, 'Skagen Gruppe', 36, 'Østvendsyssel Distrikt', NULL, NULL, '0000-00-00 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `job`
--

DROP TABLE IF EXISTS `job`;
CREATE TABLE `job` (
  `id` smallint(6) NOT NULL auto_increment,
  `site_id` tinyint(4) NOT NULL,
  `area_id` tinyint(4) default NULL,
  `owner_id` varchar(25) default NULL COMMENT 'cal_login',
  `name` varchar(64) NOT NULL,
  `description` text,
  `meetplace` varchar(64) default NULL,
  `jobplace` varchar(64) default NULL,
  `notes` text,
  `status` char(1) NOT NULL default 'A' COMMENT 'Waiting/Approved/Deleted',
  `priority` tinyint(4) NOT NULL default '3',
  `def_date` timestamp NULL default NULL,
  `def_user` varchar(25) default NULL,
  `upd_date` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `upd_user` varchar(25) default NULL,
  PRIMARY KEY  (`id`),
  KEY `owner_id` (`owner_id`),
  KEY `site_id` (`site_id`),
  KEY `area_id` (`area_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

--
-- Data dump for tabellen `job`
--

INSERT INTO `job` (`id`, `site_id`, `area_id`, `owner_id`, `name`, `description`, `meetplace`, `jobplace`, `notes`, `status`, `priority`, `def_date`, `def_user`, `upd_date`, `upd_user`) VALUES
(-1, 1, NULL, NULL, 'Blokering', NULL, NULL, NULL, NULL, 'A', 3, NULL, NULL, '0000-00-00 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `jobcategory`
--

DROP TABLE IF EXISTS `jobcategory`;
CREATE TABLE `jobcategory` (
  `id` tinyint(4) NOT NULL auto_increment,
  `name` varchar(32) NOT NULL,
  `site_id` tinyint(4) NOT NULL,
  `def_date` timestamp NULL default NULL,
  `def_user` varchar(25) default NULL,
  `upd_date` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `upd_user` varchar(25) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Data dump for tabellen `jobcategory`
--

INSERT INTO `jobcategory` (`id`, `name`, `site_id`, `def_date`, `def_user`, `upd_date`, `upd_user`) VALUES
(1, 'Aktivitet', 1, NULL, NULL, '0000-00-00 00:00:00', NULL),
(2, 'Vagt', 1, NULL, NULL, '0000-00-00 00:00:00', NULL),
(3, 'Forsyning', 1, NULL, NULL, '0000-00-00 00:00:00', NULL),
(4, 'Handyman', 1, NULL, NULL, '0000-00-00 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `qualification`
--

DROP TABLE IF EXISTS `qualification`;
CREATE TABLE `qualification` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(32) NOT NULL,
  `site_id` int(11) NOT NULL,
  `def_date` timestamp NULL default NULL,
  `def_user` varchar(25) default NULL,
  `upd_date` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `upd_user` varchar(25) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Data dump for tabellen `qualification`
--

INSERT INTO `qualification` (`id`, `name`, `site_id`, `def_date`, `def_user`, `upd_date`, `upd_user`) VALUES
(1, 'Motorsav', 1, NULL, NULL, '0000-00-00 00:00:00', NULL),
(2, 'Kørekort B', 1, NULL, NULL, '0000-00-00 00:00:00', NULL),
(3, 'Stort kørekort', 1, NULL, NULL, '0000-00-00 00:00:00', NULL),
(4, 'Hygiejnekursus', 1, NULL, NULL, '0000-00-00 00:00:00', NULL),
(5, 'Storkøkken', 1, NULL, NULL, '0000-00-00 00:00:00', NULL),
(6, 'VVS', 1, NULL, NULL, '0000-00-00 00:00:00', NULL),
(7, 'Elektriker', 1, NULL, NULL, '0000-00-00 00:00:00', NULL),
(8, 'Tømrer', 1, NULL, NULL, '0000-00-00 00:00:00', NULL),
(9, 'Sygeplejerske', 1, NULL, NULL, '0000-00-00 00:00:00', NULL),
(10, 'IT', 1, NULL, NULL, '0000-00-00 00:00:00', NULL),
(11, 'Kontorarbejde', 1, NULL, NULL, '0000-00-00 00:00:00', NULL),
(12, 'Truck-certifikat', 1, NULL, NULL, '0000-00-00 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `role`
--

DROP TABLE IF EXISTS `role`;
CREATE TABLE `role` (
  `id` tinyint(4) NOT NULL auto_increment,
  `name` varchar(16) NOT NULL,
  `def_date` timestamp NULL default NULL,
  `def_user` varchar(25) default NULL,
  `upd_date` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `upd_user` varchar(25) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Data dump for tabellen `role`
--

INSERT INTO `role` (`id`, `name`, `def_date`, `def_user`, `upd_date`, `upd_user`) VALUES
(1, 'Administrator', NULL, NULL, '0000-00-00 00:00:00', NULL),
(2, 'Arbejdsgiver', NULL, NULL, '0000-00-00 00:00:00', NULL),
(3, 'Hjælper', NULL, NULL, '0000-00-00 00:00:00', NULL),
(4, 'Jobkonsulent', NULL, NULL, '0000-00-00 00:00:00', NULL),
(5, 'Områdeansvarlig', NULL, NULL, '0000-00-00 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `site`
--

DROP TABLE IF EXISTS `site`;
CREATE TABLE `site` (
  `id` tinyint(4) NOT NULL auto_increment,
  `name` varchar(32) NOT NULL,
  `def_date` timestamp NULL default NULL,
  `def_user` varchar(25) default NULL,
  `upd_date` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `upd_user` varchar(25) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Data dump for tabellen `site`
--

INSERT INTO `site` (`id`, `name`, `def_date`, `def_user`, `upd_date`, `upd_user`) VALUES
(1, 'SEE 20:10 Jobcenter', NULL, NULL, '0000-00-00 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `subcamp`
--

DROP TABLE IF EXISTS `subcamp`;
CREATE TABLE `subcamp` (
  `id` tinyint(4) NOT NULL auto_increment,
  `site_id` tinyint(4) NOT NULL,
  `name` varchar(64) NOT NULL,
  `contact_id` varchar(25) default NULL,
  `def_date` timestamp NULL default NULL,
  `def_user` varchar(25) default NULL,
  `upd_date` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `upd_user` varchar(25) default NULL,
  PRIMARY KEY  (`id`),
  KEY `site_id` (`site_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Data dump for tabellen `subcamp`
--

INSERT INTO `subcamp` (`id`, `site_id`, `name`, `contact_id`, `def_date`, `def_user`, `upd_date`, `upd_user`) VALUES
(1, 1, 'Luppen', 'povledvard', '2009-09-12 01:28:16', NULL, '2009-09-12 01:28:16', NULL),
(2, 1, 'Dråben', 'hellesoee', '2009-09-12 01:28:16', NULL, '2009-09-12 01:28:16', NULL),
(3, 1, 'Universet', 'hekjje', '2009-09-12 01:28:16', NULL, '2009-09-12 01:28:16', NULL),
(4, 1, 'Solsikken', 'uffeebenau', '2009-09-12 01:28:16', NULL, '2009-09-12 01:28:16', NULL),
(5, 1, 'Globen', 'mogensbahnsen', '2009-09-12 01:28:16', NULL, '2009-09-12 01:28:16', NULL),
(6, 1, 'Symfonien', 'ireneschmidt', '2009-09-12 01:28:16', NULL, '2009-09-12 01:28:16', NULL),
(7, 1, 'Lanternen', 'jakobbang', '2009-09-12 01:28:16', NULL, '2009-09-12 01:28:16', NULL),
(8, 1, 'Sludderen', 'bothygesen', '2009-09-12 01:28:16', NULL, '2009-09-12 01:28:16', NULL),
(9, 1, 'Farveladen', NULL, NULL, NULL, '0000-00-00 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `user_jobcategory`
--

DROP TABLE IF EXISTS `user_jobcategory`;
CREATE TABLE `user_jobcategory` (
  `cal_login` varchar(25) NOT NULL,
  `jobcategory_id` tinyint(4) NOT NULL,
  `def_date` timestamp NULL default NULL,
  `def_user` varchar(25) default NULL,
  `upd_date` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `upd_user` varchar(25) default NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Data dump for tabellen `user_jobcategory`
--

INSERT INTO `user_jobcategory` (`cal_login`, `jobcategory_id`, `def_date`, `def_user`, `upd_date`, `upd_user`) VALUES
('cfasmer', 1, NULL, NULL, '0000-00-00 00:00:00', NULL),
('cfasmer', 2, NULL, NULL, '0000-00-00 00:00:00', NULL),
('cfasmer', 3, NULL, NULL, '0000-00-00 00:00:00', NULL),
('Jakri9', 1, NULL, NULL, '0000-00-00 00:00:00', NULL),
('Jakri9', 2, NULL, NULL, '0000-00-00 00:00:00', NULL),
('Jakri9', 3, NULL, NULL, '0000-00-00 00:00:00', NULL),
('ChristenFihl', 4, NULL, NULL, '0000-00-00 00:00:00', NULL),
('vinther', 1, NULL, NULL, '0000-00-00 00:00:00', NULL),
('vinther', 2, NULL, NULL, '0000-00-00 00:00:00', NULL),
('vinther', 3, NULL, NULL, '0000-00-00 00:00:00', NULL),
('renenielsen4', 4, NULL, NULL, '0000-00-00 00:00:00', NULL),
('benjamincallesen', 1, NULL, NULL, '2009-09-13 00:17:34', NULL),
('benjamincallesen', 2, NULL, NULL, '2009-09-13 00:17:34', NULL),
('voksam', 1, NULL, NULL, '2009-09-13 15:13:00', NULL),
('voksam', 3, NULL, NULL, '2009-09-13 15:13:00', NULL),
('voksam', 4, NULL, NULL, '2009-09-13 15:13:00', NULL),
('Kristian_weis', 3, NULL, NULL, '2009-09-13 17:31:07', NULL),
('Kristian_weis', 4, NULL, NULL, '2009-09-13 17:31:07', NULL),
('Jonathan_Simmel', 4, NULL, NULL, '2009-09-13 22:31:04', NULL),
('brian', 3, NULL, NULL, '2009-09-15 20:56:10', NULL),
('brian', 4, NULL, NULL, '2009-09-15 20:56:10', NULL),
('cbaarregaard', 3, NULL, NULL, '2009-09-17 01:33:20', NULL),
('Greenscout', 4, NULL, NULL, '2009-09-17 10:07:34', NULL),
('andreas.bastrup', 4, NULL, NULL, '2009-09-18 22:36:07', NULL),
('HanneGlud', 1, NULL, NULL, '2009-09-20 13:52:29', NULL),
('HanneGlud', 3, NULL, NULL, '2009-09-20 13:52:29', NULL),
('Jemmer', 2, NULL, NULL, '2009-09-20 22:21:34', NULL),
('B_Mortensen', 2, NULL, NULL, '2009-09-21 22:38:14', NULL),
('B_Mortensen', 3, NULL, NULL, '2009-09-21 22:38:14', NULL),
('B_Mortensen', 4, NULL, NULL, '2009-09-21 22:38:14', NULL),
('larsgj', 1, NULL, NULL, '2009-09-23 17:11:10', NULL),
('jornbrasmussen', 3, NULL, NULL, '2009-09-23 23:16:46', NULL),
('cdhb', 1, NULL, NULL, '2009-09-25 11:53:17', NULL),
('cdhb', 2, NULL, NULL, '2009-09-25 11:53:17', NULL);

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `user_qualification`
--

DROP TABLE IF EXISTS `user_qualification`;
CREATE TABLE `user_qualification` (
  `cal_login` varchar(25) NOT NULL,
  `qualification_id` int(11) NOT NULL,
  `def_date` timestamp NULL default NULL,
  `def_user` varchar(25) default NULL,
  `upd_date` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `upd_user` varchar(25) default NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Data dump for tabellen `user_qualification`
--

INSERT INTO `user_qualification` (`cal_login`, `qualification_id`, `def_date`, `def_user`, `upd_date`, `upd_user`) VALUES
('DorteJH', 4, NULL, NULL, '0000-00-00 00:00:00', NULL),
('DorteJH', 5, NULL, NULL, '0000-00-00 00:00:00', NULL),
('Morten And', 1, NULL, NULL, '0000-00-00 00:00:00', NULL),
('Morten And', 2, NULL, NULL, '0000-00-00 00:00:00', NULL),
('Morten And', 12, NULL, NULL, '0000-00-00 00:00:00', NULL),
('JakobLykke', 2, NULL, NULL, '0000-00-00 00:00:00', NULL),
('JakobLykke', 3, NULL, NULL, '0000-00-00 00:00:00', NULL),
('JakobLykke', 8, NULL, NULL, '0000-00-00 00:00:00', NULL),
('JakobLykke', 10, NULL, NULL, '0000-00-00 00:00:00', NULL),
('JakobLykke', 12, NULL, NULL, '0000-00-00 00:00:00', NULL),
('jroermose', 1, NULL, NULL, '0000-00-00 00:00:00', NULL),
('jroermose', 2, NULL, NULL, '0000-00-00 00:00:00', NULL),
('jroermose', 3, NULL, NULL, '0000-00-00 00:00:00', NULL),
('Clausw', 2, NULL, NULL, '0000-00-00 00:00:00', NULL),
('Clausw', 11, NULL, NULL, '0000-00-00 00:00:00', NULL),
('cfasmer', 2, NULL, NULL, '0000-00-00 00:00:00', NULL),
('cfasmer', 10, NULL, NULL, '0000-00-00 00:00:00', NULL),
('cfasmer', 11, NULL, NULL, '0000-00-00 00:00:00', NULL),
('Ove', 2, NULL, NULL, '0000-00-00 00:00:00', NULL),
('Ove', 8, NULL, NULL, '0000-00-00 00:00:00', NULL),
('Ove', 12, NULL, NULL, '0000-00-00 00:00:00', NULL),
('ChristenFihl', 2, NULL, NULL, '0000-00-00 00:00:00', NULL),
('ChristenFihl', 10, NULL, NULL, '0000-00-00 00:00:00', NULL),
('vinther', 2, NULL, NULL, '0000-00-00 00:00:00', NULL),
('vinther', 3, NULL, NULL, '0000-00-00 00:00:00', NULL),
('renenielsen4', 2, NULL, NULL, '0000-00-00 00:00:00', NULL),
('cbaarregaard', 2, NULL, NULL, '2009-09-17 01:33:20', 'cbaarregaard'),
('cbaarregaard', 3, NULL, NULL, '2009-09-17 01:33:20', 'cbaarregaard'),
('cbaarregaard', 12, NULL, NULL, '2009-09-17 01:33:20', 'cbaarregaard'),
('andreas.bastrup', 10, NULL, NULL, '2009-09-18 22:36:07', 'andreas.bastrup'),
('andreas.bastrup', 11, NULL, NULL, '2009-09-18 22:36:07', 'andreas.bastrup'),
('Randerup', 2, NULL, NULL, '2009-09-22 17:13:52', 'Randerup'),
('Randerup', 4, NULL, NULL, '2009-09-22 17:13:52', 'Randerup'),
('jesper', 4, NULL, NULL, '2009-09-22 23:17:57', 'jesper'),
('jesper', 5, NULL, NULL, '2009-09-22 23:17:57', 'jesper'),
('jornbrasmussen', 3, NULL, NULL, '2009-09-23 23:16:46', 'jornbrasmussen'),
('__public__', 2, NULL, NULL, '2009-09-25 11:53:18', '__public__');

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `webcal_access_function`
--

DROP TABLE IF EXISTS `webcal_access_function`;
CREATE TABLE `webcal_access_function` (
  `cal_login` varchar(25) NOT NULL,
  `cal_permissions` varchar(64) NOT NULL,
  PRIMARY KEY  (`cal_login`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Data dump for tabellen `webcal_access_function`
--

INSERT INTO `webcal_access_function` (`cal_login`, `cal_permissions`) VALUES
('admin', 'YYYYYYYYYYYYYYYYYYYYYYYYYYY');

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `webcal_access_user`
--

DROP TABLE IF EXISTS `webcal_access_user`;
CREATE TABLE `webcal_access_user` (
  `cal_login` varchar(25) NOT NULL,
  `cal_other_user` varchar(25) NOT NULL,
  `cal_can_view` int(11) NOT NULL default '0',
  `cal_can_edit` int(11) NOT NULL default '0',
  `cal_can_approve` int(11) NOT NULL default '0',
  `cal_can_invite` char(1) default 'Y',
  `cal_can_email` char(1) default 'Y',
  `cal_see_time_only` char(1) default 'N',
  PRIMARY KEY  (`cal_login`,`cal_other_user`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Data dump for tabellen `webcal_access_user`
--


-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `webcal_asst`
--

DROP TABLE IF EXISTS `webcal_asst`;
CREATE TABLE `webcal_asst` (
  `cal_boss` varchar(25) NOT NULL,
  `cal_assistant` varchar(25) NOT NULL,
  PRIMARY KEY  (`cal_boss`,`cal_assistant`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Data dump for tabellen `webcal_asst`
--


-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `webcal_blob`
--

DROP TABLE IF EXISTS `webcal_blob`;
CREATE TABLE `webcal_blob` (
  `cal_blob_id` int(11) NOT NULL,
  `cal_id` int(11) default NULL,
  `cal_login` varchar(25) default NULL,
  `cal_name` varchar(30) default NULL,
  `cal_description` varchar(128) default NULL,
  `cal_size` int(11) default NULL,
  `cal_mime_type` varchar(50) default NULL,
  `cal_type` char(1) NOT NULL,
  `cal_mod_date` int(11) NOT NULL,
  `cal_mod_time` int(11) NOT NULL,
  `cal_blob` longblob,
  PRIMARY KEY  (`cal_blob_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Data dump for tabellen `webcal_blob`
--


-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `webcal_categories`
--

DROP TABLE IF EXISTS `webcal_categories`;
CREATE TABLE `webcal_categories` (
  `cat_id` int(11) NOT NULL,
  `cat_owner` varchar(25) default NULL,
  `cat_name` varchar(80) NOT NULL,
  `cat_color` varchar(8) default NULL,
  PRIMARY KEY  (`cat_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Data dump for tabellen `webcal_categories`
--


-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `webcal_config`
--

DROP TABLE IF EXISTS `webcal_config`;
CREATE TABLE `webcal_config` (
  `cal_setting` varchar(50) NOT NULL,
  `cal_value` varchar(100) default NULL,
  `site_id` tinyint(4) default NULL,
  PRIMARY KEY  (`cal_setting`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Data dump for tabellen `webcal_config`
--

INSERT INTO `webcal_config` (`cal_setting`, `cal_value`, `site_id`) VALUES
('ADD_LINK_IN_VIEWS', 'N', NULL),
('ADMIN_OVERRIDE_UAC', 'Y', NULL),
('ALLOW_ATTACH', 'N', NULL),
('ALLOW_ATTACH_ANY', 'N', NULL),
('ALLOW_ATTACH_PART', 'N', NULL),
('ALLOW_COLOR_CUSTOMIZATION', 'Y', NULL),
('ALLOW_COMMENTS', 'N', NULL),
('ALLOW_COMMENTS_ANY', 'N', NULL),
('ALLOW_COMMENTS_PART', 'N', NULL),
('ALLOW_CONFLICTS', 'N', NULL),
('ALLOW_CONFLICT_OVERRIDE', 'Y', NULL),
('ALLOW_EXTERNAL_HEADER', 'N', NULL),
('ALLOW_EXTERNAL_USERS', 'N', NULL),
('ALLOW_HTML_DESCRIPTION', 'Y', NULL),
('ALLOW_SELF_REGISTRATION', 'N', NULL),
('ALLOW_USER_HEADER', 'N', NULL),
('ALLOW_USER_THEMES', 'Y', NULL),
('ALLOW_VIEW_OTHER', 'Y', NULL),
('APPLICATION_NAME', 'SEE 20:10 Jobcenter', NULL),
('APPROVE_ASSISTANT_EVENT', 'Y', NULL),
('AUTO_REFRESH', 'N', NULL),
('AUTO_REFRESH_TIME', '0', NULL),
('BGCOLOR', '#FFFFFF', NULL),
('BGREPEAT', 'repeat fixed center', NULL),
('BOLD_DAYS_IN_YEAR', 'Y', NULL),
('CAPTIONS', '#B04040', NULL),
('CATEGORIES_ENABLED', 'Y', NULL),
('CELLBG', '#C0C0C0', NULL),
('CONFLICT_REPEAT_MONTHS', '6', NULL),
('CUSTOM_HEADER', 'N', NULL),
('CUSTOM_SCRIPT', 'N', NULL),
('CUSTOM_TRAILER', 'Y', NULL),
('DATE_FORMAT', 'LANGUAGE_DEFINED', NULL),
('DATE_FORMAT_MD', 'LANGUAGE_DEFINED', NULL),
('DATE_FORMAT_MY', 'LANGUAGE_DEFINED', NULL),
('DATE_FORMAT_TASK', 'LANGUAGE_DEFINED', NULL),
('DEMO_MODE', 'N', NULL),
('DISABLE_ACCESS_FIELD', 'N', NULL),
('DISABLE_CROSSDAY_EVENTS', 'N', NULL),
('DISABLE_LOCATION_FIELD', 'N', NULL),
('DISABLE_PARTICIPANTS_FIELD', 'N', NULL),
('DISABLE_POPUPS', 'N', NULL),
('DISABLE_PRIORITY_FIELD', 'N', NULL),
('DISABLE_REMINDER_FIELD', 'N', NULL),
('DISABLE_REPEATING_FIELD', 'N', NULL),
('DISABLE_URL_FIELD', 'Y', NULL),
('DISPLAY_ALL_DAYS_IN_MONTH', 'N', NULL),
('DISPLAY_CREATED_BYPROXY', 'Y', NULL),
('DISPLAY_DESC_PRINT_DAY', 'Y', NULL),
('DISPLAY_END_TIMES', 'N', NULL),
('DISPLAY_LOCATION', 'N', NULL),
('DISPLAY_LONG_DAYS', 'N', NULL),
('DISPLAY_MINUTES', 'N', NULL),
('DISPLAY_MOON_PHASES', 'N', NULL),
('DISPLAY_SM_MONTH', 'Y', NULL),
('DISPLAY_TASKS', 'N', NULL),
('DISPLAY_TASKS_IN_GRID', 'N', NULL),
('DISPLAY_UNAPPROVED', 'Y', NULL),
('DISPLAY_WEEKENDS', 'Y', NULL),
('DISPLAY_WEEKNUMBER', 'Y', NULL),
('EMAIL_ASSISTANT_EVENTS', 'Y', NULL),
('EMAIL_EVENT_ADDED', 'Y', NULL),
('EMAIL_EVENT_CREATE', 'N', NULL),
('EMAIL_EVENT_DELETED', 'Y', NULL),
('EMAIL_EVENT_REJECTED', 'Y', NULL),
('EMAIL_EVENT_UPDATED', 'Y', NULL),
('EMAIL_FALLBACK_FROM', 'youremailhere', NULL),
('EMAIL_HTML', 'N', NULL),
('EMAIL_MAILER', 'mail', NULL),
('EMAIL_REMINDER', 'Y', NULL),
('ENABLE_CAPTCHA', 'N', NULL),
('ENABLE_GRADIENTS', 'N', NULL),
('ENABLE_ICON_UPLOADS', 'N', NULL),
('ENTRY_SLOTS', '144', NULL),
('EXTERNAL_NOTIFICATIONS', 'N', NULL),
('EXTERNAL_REMINDERS', 'N', NULL),
('FONTS', 'Arial, Helvetica, sans-serif', NULL),
('FREEBUSY_ENABLED', 'N', NULL),
('GENERAL_USE_GMT', 'Y', NULL),
('GROUPS_ENABLED', 'N', NULL),
('H2COLOR', '#000000', NULL),
('HASEVENTSBG', '#FFFF33', NULL),
('IMPORT_CATEGORIES', 'Y', NULL),
('JC_MAIL', 'tho@thodata.dk', 1),
('JC_MAIL_FROM', 'SEE 20:10 Jobcenter', 1),
('LANGUAGE', 'none', NULL),
('LIMIT_APPTS', 'N', NULL),
('LIMIT_APPTS_NUMBER', '6', NULL),
('LIMIT_DESCRIPTION_SIZE', 'N', NULL),
('MENU_DATE_TOP', 'Y', NULL),
('MENU_ENABLED', 'Y', NULL),
('MENU_THEME', 'default', NULL),
('MYEVENTS', '#006000', NULL),
('NONUSER_AT_TOP', 'Y', NULL),
('NONUSER_ENABLED', 'Y', NULL),
('OTHERMONTHBG', '#D0D0D0', NULL),
('OVERRIDE_PUBLIC', 'N', NULL),
('OVERRIDE_PUBLIC_TEXT', 'Not available', NULL),
('PARTICIPANTS_IN_POPUP', 'N', NULL),
('PLUGINS_ENABLED', 'N', NULL),
('POPUP_BG', '#FFFFFF', NULL),
('POPUP_FG', '#000000', NULL),
('PUBLIC_ACCESS', 'Y', NULL),
('PUBLIC_ACCESS_ADD_NEEDS_APPROVAL', 'N', NULL),
('PUBLIC_ACCESS_CAN_ADD', 'N', NULL),
('PUBLIC_ACCESS_DEFAULT_SELECTED', 'N', NULL),
('PUBLIC_ACCESS_DEFAULT_VISIBLE', 'N', NULL),
('PUBLIC_ACCESS_OTHERS', 'Y', NULL),
('PUBLIC_ACCESS_VIEW_PART', 'N', NULL),
('PUBLISH_ENABLED', 'Y', NULL),
('PULLDOWN_WEEKNUMBER', 'N', NULL),
('REMEMBER_LAST_LOGIN', 'N', NULL),
('REMINDER_DEFAULT', 'N', NULL),
('REMINDER_OFFSET', '240', NULL),
('REMINDER_WITH_DATE', 'N', NULL),
('REMOTES_ENABLED', 'N', NULL),
('REPORTS_ENABLED', 'N', NULL),
('REQUIRE_APPROVALS', 'Y', NULL),
('RSS_ENABLED', 'N', NULL),
('SELF_REGISTRATION_BLACKLIST', 'N', NULL),
('SELF_REGISTRATION_FULL', 'N', NULL),
('SEND_EMAIL', 'N', NULL),
('SERVER_TIMEZONE', 'Europe/Copenhagen', NULL),
('SERVER_URL', 'http://see2010jobcenter.wh.spejdernet.dk/', NULL),
('SITE_EXTRAS_IN_POPUP', 'N', NULL),
('SMTP_AUTH', 'N', NULL),
('SMTP_HOST', 'localhost', NULL),
('SMTP_PORT', '25', NULL),
('STARTVIEW', 'jc_menu.php', NULL),
('SUMMARY_LENGTH', '80', NULL),
('TABLEBG', '#000000', NULL),
('TEXTCOLOR', '#000000', NULL),
('THBG', '#FFFFFF', NULL),
('THEME', 'none', NULL),
('THFG', '#000000', NULL),
('TIMED_EVT_LEN', 'E', NULL),
('TIMEZONE', 'Europe/Copenhagen', NULL),
('TIME_FORMAT', '24', NULL),
('TIME_SLOTS', '24', NULL),
('TIME_SPACER', '&raquo;&nbsp;', NULL),
('TODAYCELLBG', '#FFFF33', NULL),
('UAC_ENABLED', 'N', NULL),
('UPCOMING_ALLOW_OVR', 'N', NULL),
('UPCOMING_DISPLAY_CAT_ICONS', 'Y', NULL),
('UPCOMING_DISPLAY_LAYERS', 'N', NULL),
('UPCOMING_DISPLAY_LINKS', 'Y', NULL),
('UPCOMING_DISPLAY_POPUPS', 'Y', NULL),
('UPCOMING_EVENTS', 'N', NULL),
('USER_PUBLISH_ENABLED', 'Y', NULL),
('USER_PUBLISH_RW_ENABLED', 'Y', NULL),
('USER_RSS_ENABLED', 'N', NULL),
('USER_SEES_ONLY_HIS_GROUPS', 'Y', NULL),
('USER_SORT_ORDER', 'cal_firstname, cal_lastname', NULL),
('WEBCAL_PROGRAM_VERSION', 'v1.2.0', NULL),
('WEBCAL_TZ_CONVERSION', 'Y', NULL),
('WEEKENDBG', '#D0D0D0', NULL),
('WEEKEND_START', '6', NULL),
('WEEKNUMBER', '#FF6633', NULL),
('WEEK_START', '1', NULL),
('WORK_DAY_END_HOUR', '17', NULL),
('WORK_DAY_START_HOUR', '8', NULL);

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `webcal_entry`
--

DROP TABLE IF EXISTS `webcal_entry`;
CREATE TABLE `webcal_entry` (
  `cal_id` int(11) NOT NULL,
  `cal_group_id` int(11) default NULL,
  `cal_ext_for_id` int(11) default NULL,
  `cal_create_by` varchar(25) NOT NULL,
  `cal_date` int(11) NOT NULL,
  `cal_time` int(11) default NULL,
  `cal_mod_date` int(11) default NULL,
  `cal_mod_time` int(11) default NULL,
  `cal_duration` int(11) NOT NULL,
  `cal_due_date` int(11) default NULL,
  `cal_due_time` int(11) default NULL,
  `cal_priority` int(11) default '5',
  `cal_type` char(1) default 'E',
  `cal_access` char(1) default 'P',
  `cal_name` varchar(80) NOT NULL,
  `cal_location` varchar(100) default NULL,
  `cal_url` varchar(100) default NULL,
  `cal_completed` int(11) default NULL,
  `cal_description` text,
  `job_id` smallint(6) default NULL,
  `person_need` tinyint(4) default '0',
  `contact_id` varchar(25) default NULL,
  `def_date` timestamp NULL default NULL,
  `def_user` varchar(25) default NULL,
  `upd_date` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `upd_user` varchar(25) default NULL,
  PRIMARY KEY  (`cal_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Data dump for tabellen `webcal_entry`
--

INSERT INTO `webcal_entry` (`cal_id`, `cal_group_id`, `cal_ext_for_id`, `cal_create_by`, `cal_date`, `cal_time`, `cal_mod_date`, `cal_mod_time`, `cal_duration`, `cal_due_date`, `cal_due_time`, `cal_priority`, `cal_type`, `cal_access`, `cal_name`, `cal_location`, `cal_url`, `cal_completed`, `cal_description`, `job_id`, `person_need`, `contact_id`, `def_date`, `def_user`, `upd_date`, `upd_user`) VALUES
(28, NULL, NULL, 'testbruger', 20090724, 0, NULL, NULL, 360, NULL, NULL, 5, 'E', 'P', 'autogen', NULL, NULL, NULL, NULL, -1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', NULL),
(29, NULL, NULL, 'testbruger', 20090725, 0, NULL, NULL, 360, NULL, NULL, 5, 'E', 'P', 'autogen', NULL, NULL, NULL, NULL, -1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', NULL),
(30, NULL, NULL, 'testbruger', 20090726, 0, NULL, NULL, 360, NULL, NULL, 5, 'E', 'P', 'autogen', NULL, NULL, NULL, NULL, -1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', NULL),
(31, NULL, NULL, 'testbruger', 20090727, 0, NULL, NULL, 360, NULL, NULL, 5, 'E', 'P', 'autogen', NULL, NULL, NULL, NULL, -1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', NULL),
(32, NULL, NULL, 'testbruger', 20090728, 0, NULL, NULL, 360, NULL, NULL, 5, 'E', 'P', 'autogen', NULL, NULL, NULL, NULL, -1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', NULL),
(33, NULL, NULL, 'testbruger', 20090729, 0, NULL, NULL, 360, NULL, NULL, 5, 'E', 'P', 'autogen', NULL, NULL, NULL, NULL, -1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', NULL),
(34, NULL, NULL, 'testbruger', 20090730, 0, NULL, NULL, 360, NULL, NULL, 5, 'E', 'P', 'autogen', NULL, NULL, NULL, NULL, -1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', NULL),
(35, NULL, NULL, 'testbruger', 20090731, 0, NULL, NULL, 360, NULL, NULL, 5, 'E', 'P', 'autogen', NULL, NULL, NULL, NULL, -1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', NULL),
(36, NULL, NULL, 'testbruger', 20090801, 0, NULL, NULL, 360, NULL, NULL, 5, 'E', 'P', 'autogen', NULL, NULL, NULL, NULL, -1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', NULL),
(37, NULL, NULL, 'testbruger', 20090724, 60000, NULL, NULL, 360, NULL, NULL, 5, 'E', 'P', 'autogen', NULL, NULL, NULL, NULL, -1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', NULL),
(38, NULL, NULL, 'testbruger', 20090725, 60000, NULL, NULL, 360, NULL, NULL, 5, 'E', 'P', 'autogen', NULL, NULL, NULL, NULL, -1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', NULL),
(39, NULL, NULL, 'testbruger', 20090726, 60000, NULL, NULL, 360, NULL, NULL, 5, 'E', 'P', 'autogen', NULL, NULL, NULL, NULL, -1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', NULL),
(40, NULL, NULL, 'testbruger', 20090727, 60000, NULL, NULL, 360, NULL, NULL, 5, 'E', 'P', 'autogen', NULL, NULL, NULL, NULL, -1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', NULL),
(41, NULL, NULL, 'testbruger', 20090728, 60000, NULL, NULL, 360, NULL, NULL, 5, 'E', 'P', 'autogen', NULL, NULL, NULL, NULL, -1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', NULL),
(42, NULL, NULL, 'testbruger', 20090729, 60000, NULL, NULL, 360, NULL, NULL, 5, 'E', 'P', 'autogen', NULL, NULL, NULL, NULL, -1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', NULL),
(43, NULL, NULL, 'testbruger', 20090730, 60000, NULL, NULL, 360, NULL, NULL, 5, 'E', 'P', 'autogen', NULL, NULL, NULL, NULL, -1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', NULL),
(44, NULL, NULL, 'testbruger', 20090731, 60000, NULL, NULL, 360, NULL, NULL, 5, 'E', 'P', 'autogen', NULL, NULL, NULL, NULL, -1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', NULL),
(45, NULL, NULL, 'testbruger', 20090801, 60000, NULL, NULL, 360, NULL, NULL, 5, 'E', 'P', 'autogen', NULL, NULL, NULL, NULL, -1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', NULL),
(46, NULL, NULL, 'testbruger', 20090724, 120000, NULL, NULL, 360, NULL, NULL, 5, 'E', 'P', 'autogen', NULL, NULL, NULL, NULL, -1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', NULL),
(47, NULL, NULL, 'testbruger', 20090725, 120000, NULL, NULL, 360, NULL, NULL, 5, 'E', 'P', 'autogen', NULL, NULL, NULL, NULL, -1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', NULL),
(48, NULL, NULL, 'testbruger', 20090726, 120000, NULL, NULL, 360, NULL, NULL, 5, 'E', 'P', 'autogen', NULL, NULL, NULL, NULL, -1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', NULL),
(49, NULL, NULL, 'testbruger', 20090727, 120000, NULL, NULL, 360, NULL, NULL, 5, 'E', 'P', 'autogen', NULL, NULL, NULL, NULL, -1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', NULL),
(50, NULL, NULL, 'testbruger', 20090728, 120000, NULL, NULL, 360, NULL, NULL, 5, 'E', 'P', 'autogen', NULL, NULL, NULL, NULL, -1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', NULL),
(51, NULL, NULL, 'testbruger', 20090729, 120000, NULL, NULL, 360, NULL, NULL, 5, 'E', 'P', 'autogen', NULL, NULL, NULL, NULL, -1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', NULL),
(52, NULL, NULL, 'testbruger', 20090730, 120000, NULL, NULL, 360, NULL, NULL, 5, 'E', 'P', 'autogen', NULL, NULL, NULL, NULL, -1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', NULL),
(53, NULL, NULL, 'testbruger', 20090731, 120000, NULL, NULL, 360, NULL, NULL, 5, 'E', 'P', 'autogen', NULL, NULL, NULL, NULL, -1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', NULL),
(54, NULL, NULL, 'testbruger', 20090801, 120000, NULL, NULL, 360, NULL, NULL, 5, 'E', 'P', 'autogen', NULL, NULL, NULL, NULL, -1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', NULL),
(55, NULL, NULL, 'testbruger', 20090724, 180000, NULL, NULL, -1080, NULL, NULL, 5, 'E', 'P', 'autogen', NULL, NULL, NULL, NULL, -1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', NULL),
(56, NULL, NULL, 'testbruger', 20090725, 180000, NULL, NULL, -1080, NULL, NULL, 5, 'E', 'P', 'autogen', NULL, NULL, NULL, NULL, -1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', NULL),
(57, NULL, NULL, 'testbruger', 20090726, 180000, NULL, NULL, -1080, NULL, NULL, 5, 'E', 'P', 'autogen', NULL, NULL, NULL, NULL, -1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', NULL),
(58, NULL, NULL, 'testbruger', 20090727, 180000, NULL, NULL, -1080, NULL, NULL, 5, 'E', 'P', 'autogen', NULL, NULL, NULL, NULL, -1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', NULL),
(59, NULL, NULL, 'testbruger', 20090728, 180000, NULL, NULL, -1080, NULL, NULL, 5, 'E', 'P', 'autogen', NULL, NULL, NULL, NULL, -1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', NULL),
(60, NULL, NULL, 'testbruger', 20090729, 180000, NULL, NULL, -1080, NULL, NULL, 5, 'E', 'P', 'autogen', NULL, NULL, NULL, NULL, -1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', NULL),
(61, NULL, NULL, 'testbruger', 20090730, 180000, NULL, NULL, -1080, NULL, NULL, 5, 'E', 'P', 'autogen', NULL, NULL, NULL, NULL, -1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', NULL),
(62, NULL, NULL, 'testbruger', 20090731, 180000, NULL, NULL, -1080, NULL, NULL, 5, 'E', 'P', 'autogen', NULL, NULL, NULL, NULL, -1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', NULL),
(63, NULL, NULL, 'testbruger', 20090801, 180000, NULL, NULL, -1080, NULL, NULL, 5, 'E', 'P', 'autogen', NULL, NULL, NULL, NULL, -1, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `webcal_entry_categories`
--

DROP TABLE IF EXISTS `webcal_entry_categories`;
CREATE TABLE `webcal_entry_categories` (
  `cal_id` int(11) NOT NULL default '0',
  `cat_id` int(11) NOT NULL default '0',
  `cat_order` int(11) NOT NULL default '0',
  `cat_owner` varchar(25) default NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Data dump for tabellen `webcal_entry_categories`
--


-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `webcal_entry_ext_user`
--

DROP TABLE IF EXISTS `webcal_entry_ext_user`;
CREATE TABLE `webcal_entry_ext_user` (
  `cal_id` int(11) NOT NULL default '0',
  `cal_fullname` varchar(50) NOT NULL,
  `cal_email` varchar(75) default NULL,
  PRIMARY KEY  (`cal_id`,`cal_fullname`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Data dump for tabellen `webcal_entry_ext_user`
--


-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `webcal_entry_log`
--

DROP TABLE IF EXISTS `webcal_entry_log`;
CREATE TABLE `webcal_entry_log` (
  `cal_log_id` int(11) NOT NULL,
  `cal_entry_id` int(11) NOT NULL,
  `cal_login` varchar(25) NOT NULL,
  `cal_user_cal` varchar(25) default NULL,
  `cal_type` char(1) NOT NULL,
  `cal_date` int(11) NOT NULL,
  `cal_time` int(11) default NULL,
  `cal_text` text,
  PRIMARY KEY  (`cal_log_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Data dump for tabellen `webcal_entry_log`
--

INSERT INTO `webcal_entry_log` (`cal_log_id`, `cal_entry_id`, `cal_login`, `cal_user_cal`, `cal_type`, `cal_date`, `cal_time`, `cal_text`) VALUES
(1, 1, 'admin', 'admin', 'C', 20081203, 221802, NULL),
(2, 2, 'admin', 'admin', 'C', 20081203, 222035, NULL),
(3, 0, 'system', NULL, 'x', 20081204, 162820, 'Brugernavn: ADMIN, IP: 127.0.0.1'),
(4, 0, 'system', NULL, 'x', 20090222, 150938, 'Brugernavn: tho, IP: 127.0.0.1'),
(5, 0, 'system', NULL, 'x', 20090222, 150943, 'Brugernavn: tho, IP: 127.0.0.1'),
(6, 0, 'system', NULL, 'x', 20090222, 150947, 'Brugernavn: tho, IP: 127.0.0.1'),
(7, 0, 'system', NULL, 'x', 20090222, 150951, 'Brugernavn: tho, IP: 127.0.0.1'),
(8, 0, 'system', NULL, 'x', 20090620, 102046, 'Brugernavn: thea, IP: 127.0.0.1'),
(9, 0, 'system', NULL, 'x', 20090801, 175438, 'Brugernavn: agh, IP: 127.0.0.1'),
(10, 0, 'system', NULL, 'x', 20090801, 175457, 'Brugernavn: agh, IP: 127.0.0.1'),
(11, 0, 'system', NULL, 'x', 20090801, 175508, 'Brugernavn: asdfasdf, IP: 127.0.0.1'),
(12, 0, 'system', NULL, 'x', 20090801, 175723, 'Brugernavn: asdf, IP: 127.0.0.1'),
(13, 0, 'system', NULL, 'x', 20090801, 175731, 'Brugernavn: agh, IP: 127.0.0.1'),
(14, 0, 'system', NULL, 'x', 20090815, 202223, 'Brugernavn: thea, IP: 127.0.0.1'),
(15, 0, 'system', NULL, 'x', 20090816, 22533, 'Brugernavn: thea, IP: 127.0.0.1'),
(16, 0, 'system', NULL, 'x', 20090822, 120347, 'Brugernavn: thea, IP: 127.0.0.1'),
(17, 0, 'system', NULL, 'x', 20090822, 135657, 'Brugernavn: tho, IP: 127.0.0.1'),
(18, 0, 'system', NULL, 'x', 20090824, 214953, 'Brugernavn: tho, IP: 90.185.51.51'),
(19, 0, 'system', NULL, 'x', 20090827, 213728, 'Brugernavn: tho, IP: 90.185.51.51'),
(20, 0, 'system', NULL, 'x', 20090829, 102644, 'Brugernavn: Dortejh, IP: 89.249.12.28'),
(21, 0, 'system', NULL, 'x', 20090829, 102704, 'Brugernavn: Dortejh, IP: 89.249.12.28'),
(22, 0, 'system', NULL, 'x', 20090829, 114113, 'Brugernavn: tho, IP: 90.185.51.51'),
(23, 0, 'system', NULL, 'x', 20090901, 102401, 'Username: AndreasBastrupLarse, IP: 87.54.19.66'),
(24, 0, 'system', NULL, 'x', 20090901, 141540, 'Brugernavn: mortenandersen3, IP: 87.60.245.167'),
(25, 0, 'system', NULL, 'x', 20090901, 161417, 'Brugernavn: carstenclausen, IP: 94.138.86.253'),
(26, 0, 'system', NULL, 'x', 20090903, 120522, 'Brugernavn: laustdalsgaard, IP: 80.62.211.30'),
(27, 0, 'system', NULL, 'x', 20090903, 173034, 'Brugernavn: bosanderpedersen, IP: 83.88.174.86'),
(28, 0, 'system', NULL, 'x', 20090904, 114601, 'Brugernavn: adh, IP: 93.165.152.242'),
(29, 0, 'system', NULL, 'x', 20090904, 114611, 'Brugernavn: agh, IP: 93.165.152.242'),
(30, 0, 'system', NULL, 'x', 20090906, 75759, 'Brugernavn: TinaDavidsen, IP: 87.49.203.150'),
(31, 0, 'system', NULL, 'x', 20090906, 170529, 'Username: kamillavej, IP: 77.215.47.81'),
(32, 0, 'system', NULL, 'x', 20090906, 185708, 'Brugernavn: jesperkroghsoerensen, IP: 85.81.51.9'),
(33, 0, 'system', NULL, 'x', 20090907, 140409, 'Brugernavn: ove, IP: 87.49.148.131'),
(34, 0, 'system', NULL, 'x', 20090908, 120422, 'Brugernavn: jakobkristoffersen, IP: 217.60.160.34'),
(35, 0, 'system', NULL, 'x', 20090908, 124011, 'Brugernavn: jakri9, IP: 217.60.160.34'),
(36, 0, 'system', NULL, 'x', 20090908, 124034, 'Brugernavn: jakri9, IP: 217.60.160.34'),
(37, 0, 'system', NULL, 'x', 20090908, 124120, 'Brugernavn: jakri9, IP: 217.60.160.34'),
(38, 0, 'system', NULL, 'x', 20090908, 124137, 'Brugernavn: jakri9, IP: 217.60.160.34'),
(39, 0, 'system', NULL, 'x', 20090908, 124204, 'Brugernavn: jakri9, IP: 217.60.160.34'),
(40, 0, 'system', NULL, 'x', 20090908, 124322, 'Brugernavn: jakri9, IP: 217.60.160.34'),
(41, 0, 'system', NULL, 'x', 20090908, 124333, 'Brugernavn: jakri9, IP: 217.60.160.34'),
(42, 0, 'system', NULL, 'x', 20090908, 124345, 'Brugernavn: jakri9, IP: 217.60.160.34'),
(43, 0, 'system', NULL, 'x', 20090908, 124355, 'Brugernavn: jakri9, IP: 217.60.160.34'),
(44, 0, 'system', NULL, 'x', 20090908, 145824, 'Brugernavn: BrianPedersen2, IP: 87.116.46.137'),
(45, 0, 'system', NULL, 'x', 20090908, 152428, 'Brugernavn: jakri9, IP: 83.88.247.37'),
(46, 0, 'system', NULL, 'x', 20090908, 152442, 'Brugernavn: jakri9, IP: 83.88.247.37'),
(47, 0, 'system', NULL, 'x', 20090910, 74442, 'Brugernavn: emilbp, IP: 87.116.46.239'),
(48, 0, 'system', NULL, 'x', 20090910, 75314, 'Brugernavn: keldchristiansen, IP: 87.54.192.119'),
(49, 0, 'system', NULL, 'x', 20090910, 190948, 'Brugernavn: dennisgjensen, IP: 85.81.0.52'),
(50, 0, 'system', NULL, 'x', 20090910, 191646, 'Brugernavn: dennisgjensen, IP: 85.81.0.52'),
(51, 0, 'system', NULL, 'x', 20090911, 145115, 'Brugernavn: briannielsen1, IP: 87.55.4.163'),
(52, 0, 'system', NULL, 'x', 20090911, 150757, 'Brugernavn: rasmusmortensen1, IP: 94.145.208.55'),
(53, 0, 'system', NULL, 'x', 20090911, 150822, 'Brugernavn: rasmusmortensen1, IP: 94.145.208.55'),
(54, 0, 'system', NULL, 'x', 20090911, 161439, 'Brugernavn: SimonLading, IP: 212.10.182.35'),
(55, 0, 'system', NULL, 'x', 20090912, 142334, 'Brugernavn: martinthagaardhanse, IP: 92.241.211.222'),
(56, 0, 'system', NULL, 'x', 20090912, 142346, 'Brugernavn: martinthagaardhanse, IP: 92.241.211.222'),
(57, 0, 'system', NULL, 'x', 20090913, 153005, 'Username: boraabjergandersen, IP: 77.68.161.233'),
(58, 0, 'system', NULL, 'x', 20090913, 153157, 'Brugernavn: kristian_weis, IP: 80.164.109.185'),
(59, 0, 'system', NULL, 'x', 20090913, 155231, 'Brugernavn: AndersAChristiansen, IP: 85.81.99.22'),
(60, 0, 'system', NULL, 'x', 20090913, 164107, 'Brugernavn: anitamadsen, IP: 82.143.193.106'),
(61, 0, 'system', NULL, 'x', 20090913, 170454, 'Brugernavn: chape, IP: 87.55.74.5'),
(62, 0, 'system', NULL, 'x', 20090913, 170717, 'Brugernavn: charlotte, IP: 87.55.74.5'),
(63, 0, 'system', NULL, 'x', 20090913, 170727, 'Brugernavn: charlotte, IP: 87.55.74.5'),
(64, 0, 'system', NULL, 'x', 20090913, 183207, 'Username: Katrineskovsgaard, IP: 195.249.91.168'),
(65, 0, 'system', NULL, 'x', 20090913, 233549, 'Brugernavn: BoThygesen, IP: 193.89.254.46'),
(66, 0, 'system', NULL, 'x', 20090914, 84038, 'Brugernavn: tommystub, IP: 62.107.235.13'),
(67, 0, 'system', NULL, 'x', 20090914, 105914, 'Brugernavn: bentthaulovklein, IP: 193.26.218.154'),
(68, 0, 'system', NULL, 'x', 20090914, 105943, 'Brugernavn: BentThaulovKlein, IP: 193.26.218.154'),
(69, 0, 'system', NULL, 'x', 20090914, 183141, 'Brugernavn: HanneLarsen, IP: 80.62.167.49'),
(70, 0, 'system', NULL, 'x', 20090914, 184421, 'Brugernavn: larsmadsen, IP: 87.52.63.238'),
(71, 0, 'system', NULL, 'x', 20090914, 184426, 'Brugernavn: larsmadsen, IP: 87.52.63.238'),
(72, 0, 'system', NULL, 'x', 20090914, 184443, 'Brugernavn: larsmadsen, IP: 87.52.63.238'),
(73, 0, 'system', NULL, 'x', 20090914, 184449, 'Brugernavn: larsmadsen, IP: 87.52.63.238'),
(74, 0, 'system', NULL, 'x', 20090915, 61309, 'Username: flemmingrasmussen, IP: 212.237.68.179'),
(75, 0, 'system', NULL, 'x', 20090915, 95045, 'Brugernavn: gittejakobsen, IP: 87.62.140.110'),
(76, 0, 'system', NULL, 'x', 20090915, 145649, 'Brugernavn: HenrikThansen, IP: 85.83.18.97'),
(77, 0, 'system', NULL, 'x', 20090915, 151426, 'Brugernavn: lassesvarrejakobsen, IP: 212.10.22.208'),
(78, 0, 'system', NULL, 'x', 20090915, 164728, 'Brugernavn: madsmilthers, IP: 62.116.218.23'),
(79, 0, 'system', NULL, 'x', 20090915, 180546, 'Brugernavn: christianbloch, IP: 83.95.215.231'),
(80, 0, 'system', NULL, 'x', 20090915, 184534, 'Username: mikepedersen, IP: 87.54.61.90'),
(81, 0, 'system', NULL, 'x', 20090916, 41926, 'Brugernavn: henrychristensen, IP: 90.185.237.140'),
(82, 0, 'system', NULL, 'x', 20090916, 83417, 'Brugernavn: hansdaugaard, IP: 83.95.137.84'),
(83, 0, 'system', NULL, 'x', 20090916, 83430, 'Brugernavn: hansdaugaard, IP: 83.95.137.84'),
(84, 0, 'system', NULL, 'x', 20090916, 83526, 'Brugernavn: hansdaugaard, IP: 83.95.137.84'),
(85, 0, 'system', NULL, 'x', 20090916, 83824, 'Brugernavn: hansdaugaard, IP: 83.95.137.84'),
(86, 0, 'system', NULL, 'x', 20090916, 153932, 'Brugernavn: jakri9, IP: 83.88.247.47'),
(87, 0, 'system', NULL, 'x', 20090916, 154001, 'Brugernavn: jakri9, IP: 83.88.247.47'),
(88, 0, 'system', NULL, 'x', 20090916, 180150, 'Brugernavn: hansdaugaard, IP: 90.185.51.51'),
(89, 0, 'system', NULL, 'x', 20090916, 180744, 'Brugernavn: hansdaugaard, IP: 90.185.51.51'),
(90, 0, 'system', NULL, 'x', 20090916, 210047, 'Brugernavn: janskovhushansen, IP: 87.104.103.213'),
(91, 0, 'system', NULL, 'x', 20090917, 80421, 'Brugernavn: greenscout, IP: 131.165.102.227'),
(92, 0, 'system', NULL, 'x', 20090917, 80746, 'Brugernavn: greenscout, IP: 131.165.102.227'),
(93, 0, 'system', NULL, 'x', 20090917, 80800, 'Brugernavn: greenscout, IP: 131.165.102.227'),
(94, 0, 'system', NULL, 'x', 20090917, 185650, 'Brugernavn: greenscout, IP: 94.145.208.83'),
(95, 0, 'system', NULL, 'x', 20090918, 83452, 'Brugernavn: jørnbrasmussen, IP: 62.107.235.13'),
(96, 0, 'system', NULL, 'x', 20090918, 153954, 'Brugernavn: oledamkjaer, IP: 89.150.187.185'),
(97, 0, 'system', NULL, 'x', 20090918, 154015, 'Brugernavn: oledamkjaer, IP: 89.150.187.185'),
(98, 0, 'system', NULL, 'x', 20090918, 203447, 'Username: andreasbastrup, IP: 89.239.251.144'),
(99, 0, 'system', NULL, 'x', 20090919, 74826, 'Brugernavn: kennethKMortensen, IP: 80.162.11.141'),
(100, 0, 'system', NULL, 'x', 20090919, 91258, 'Brugernavn: Jakobwedel, IP: 85.81.99.100'),
(101, 0, 'system', NULL, 'x', 20090919, 91402, 'Brugernavn: JakobWedel, IP: 85.81.99.100'),
(102, 0, 'system', NULL, 'x', 20090919, 91412, 'Brugernavn: JakobWedel, IP: 85.81.99.100'),
(103, 0, 'system', NULL, 'x', 20090919, 175747, 'Brugernavn: hanneglud, IP: 87.56.82.139'),
(104, 0, 'system', NULL, 'x', 20090920, 101116, 'Brugernavn: BrianPedersen2, IP: 87.116.46.137'),
(105, 0, 'system', NULL, 'x', 20090920, 162338, 'Brugernavn: kimjensen, IP: 83.91.53.63'),
(106, 0, 'system', NULL, 'x', 20090920, 182732, 'Brugernavn: jesper, IP: 85.24.95.110'),
(107, 0, 'system', NULL, 'x', 20090920, 182758, 'Brugernavn: jesper, IP: 85.24.95.110'),
(108, 0, 'system', NULL, 'x', 20090922, 133230, 'Username: BoThygesen, IP: 193.89.254.46'),
(109, 0, 'system', NULL, 'x', 20090922, 133247, 'Username: BoThygesen, IP: 193.89.254.46'),
(110, 0, 'system', NULL, 'x', 20090922, 133329, 'Username: Bo Thygesen, IP: 193.89.254.46'),
(111, 0, 'system', NULL, 'x', 20090922, 133358, 'Username: BoThygesen, IP: 193.89.254.46'),
(112, 0, 'system', NULL, 'x', 20090922, 133424, 'Username: BoThygesen, IP: 193.89.254.46'),
(113, 0, 'system', NULL, 'x', 20090922, 202002, 'Brugernavn: bjarkemadsen, IP: 87.56.116.128'),
(114, 0, 'system', NULL, 'x', 20090922, 212446, 'Brugernavn: rikkens, IP: 90.185.51.51'),
(115, 0, 'system', NULL, 'x', 20090922, 212501, 'Brugernavn: rikkens, IP: 90.185.51.51'),
(116, 0, 'system', NULL, 'x', 20090923, 150542, 'Username: LarsGJoergensen, IP: 90.185.116.130'),
(117, 0, 'system', NULL, 'x', 20090923, 151126, 'Username: larsgj, IP: 90.185.116.130'),
(118, 0, 'system', NULL, 'x', 20090923, 151131, 'Username: larsgj, IP: 90.185.116.130'),
(119, 0, 'system', NULL, 'x', 20090923, 190449, 'Brugernavn: llll, IP: 87.62.253.68'),
(120, 0, 'system', NULL, 'x', 20090923, 190547, 'Brugernavn: chape, IP: 87.62.253.68'),
(121, 0, 'system', NULL, 'x', 20090923, 211355, 'Brugernavn: jornbrasumssen, IP: 62.107.232.84'),
(122, 0, 'system', NULL, 'x', 20090923, 211424, 'Brugernavn: jornbrasmussen, IP: 62.107.232.84'),
(123, 0, 'system', NULL, 'x', 20090924, 142546, 'Username: larspedersen4, IP: 212.130.8.26'),
(124, 0, 'system', NULL, 'x', 20090925, 53328, 'Brugernavn: DorisMortensen, IP: 87.55.171.66'),
(125, 0, 'system', NULL, 'x', 20090925, 182547, 'Brugernavn: FieWolfbrandtEriksen, IP: 87.55.62.163');

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `webcal_entry_repeats`
--

DROP TABLE IF EXISTS `webcal_entry_repeats`;
CREATE TABLE `webcal_entry_repeats` (
  `cal_id` int(11) NOT NULL default '0',
  `cal_type` varchar(20) default NULL,
  `cal_end` int(11) default NULL,
  `cal_endtime` int(11) default NULL,
  `cal_frequency` int(11) default '1',
  `cal_days` char(7) default NULL,
  `cal_bymonth` varchar(50) default NULL,
  `cal_bymonthday` varchar(100) default NULL,
  `cal_byday` varchar(100) default NULL,
  `cal_bysetpos` varchar(50) default NULL,
  `cal_byweekno` varchar(50) default NULL,
  `cal_byyearday` varchar(50) default NULL,
  `cal_wkst` char(2) default 'MO',
  `cal_count` int(11) default NULL,
  PRIMARY KEY  (`cal_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Data dump for tabellen `webcal_entry_repeats`
--


-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `webcal_entry_repeats_not`
--

DROP TABLE IF EXISTS `webcal_entry_repeats_not`;
CREATE TABLE `webcal_entry_repeats_not` (
  `cal_id` int(11) NOT NULL,
  `cal_date` int(11) NOT NULL,
  `cal_exdate` int(1) NOT NULL default '1',
  PRIMARY KEY  (`cal_id`,`cal_date`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Data dump for tabellen `webcal_entry_repeats_not`
--


-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `webcal_entry_user`
--

DROP TABLE IF EXISTS `webcal_entry_user`;
CREATE TABLE `webcal_entry_user` (
  `cal_id` int(11) NOT NULL default '0',
  `cal_login` varchar(25) NOT NULL,
  `cal_status` char(1) default 'A',
  `cal_category` int(11) default NULL,
  `cal_percent` int(11) NOT NULL default '0',
  `count` int(11) default NULL,
  `notes` varchar(255) default NULL,
  `def_date` timestamp NULL default NULL,
  `def_user` varchar(25) default NULL,
  `upd_date` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `upd_user` varchar(25) default NULL,
  PRIMARY KEY  (`cal_id`,`cal_login`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Data dump for tabellen `webcal_entry_user`
--

INSERT INTO `webcal_entry_user` (`cal_id`, `cal_login`, `cal_status`, `cal_category`, `cal_percent`, `count`, `notes`, `def_date`, `def_user`, `upd_date`, `upd_user`) VALUES
(39, 'DorteJH', 'A', NULL, 0, 1, NULL, '2009-09-13 10:11:30', 'DorteJH', '2009-09-13 10:11:30', 'DorteJH'),
(42, 'DorteJH', 'A', NULL, 0, 1, NULL, '2009-09-13 10:11:30', 'DorteJH', '2009-09-13 10:11:30', 'DorteJH');

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `webcal_group`
--

DROP TABLE IF EXISTS `webcal_group`;
CREATE TABLE `webcal_group` (
  `cal_group_id` int(11) NOT NULL,
  `cal_owner` varchar(25) default NULL,
  `cal_name` varchar(50) NOT NULL,
  `cal_last_update` int(11) NOT NULL,
  PRIMARY KEY  (`cal_group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Data dump for tabellen `webcal_group`
--


-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `webcal_group_user`
--

DROP TABLE IF EXISTS `webcal_group_user`;
CREATE TABLE `webcal_group_user` (
  `cal_group_id` int(11) NOT NULL,
  `cal_login` varchar(25) NOT NULL,
  PRIMARY KEY  (`cal_group_id`,`cal_login`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Data dump for tabellen `webcal_group_user`
--


-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `webcal_import`
--

DROP TABLE IF EXISTS `webcal_import`;
CREATE TABLE `webcal_import` (
  `cal_import_id` int(11) NOT NULL,
  `cal_name` varchar(50) default NULL,
  `cal_date` int(11) NOT NULL,
  `cal_type` varchar(10) NOT NULL,
  `cal_login` varchar(25) default NULL,
  PRIMARY KEY  (`cal_import_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Data dump for tabellen `webcal_import`
--


-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `webcal_import_data`
--

DROP TABLE IF EXISTS `webcal_import_data`;
CREATE TABLE `webcal_import_data` (
  `cal_import_id` int(11) NOT NULL,
  `cal_id` int(11) NOT NULL,
  `cal_login` varchar(25) NOT NULL,
  `cal_import_type` varchar(15) NOT NULL,
  `cal_external_id` varchar(200) default NULL,
  PRIMARY KEY  (`cal_id`,`cal_login`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Data dump for tabellen `webcal_import_data`
--


-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `webcal_nonuser_cals`
--

DROP TABLE IF EXISTS `webcal_nonuser_cals`;
CREATE TABLE `webcal_nonuser_cals` (
  `cal_login` varchar(25) NOT NULL,
  `cal_lastname` varchar(25) default NULL,
  `cal_firstname` varchar(25) default NULL,
  `cal_admin` varchar(25) NOT NULL,
  `cal_is_public` char(1) NOT NULL default 'N',
  `cal_url` varchar(255) default NULL,
  PRIMARY KEY  (`cal_login`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Data dump for tabellen `webcal_nonuser_cals`
--


-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `webcal_reminders`
--

DROP TABLE IF EXISTS `webcal_reminders`;
CREATE TABLE `webcal_reminders` (
  `cal_id` int(11) NOT NULL default '0',
  `cal_date` int(11) NOT NULL default '0',
  `cal_offset` int(11) NOT NULL default '0',
  `cal_related` char(1) NOT NULL default 'S',
  `cal_before` char(1) NOT NULL default 'Y',
  `cal_last_sent` int(11) NOT NULL default '0',
  `cal_repeats` int(11) NOT NULL default '0',
  `cal_duration` int(11) NOT NULL default '0',
  `cal_times_sent` int(11) NOT NULL default '0',
  `cal_action` varchar(12) NOT NULL default 'EMAIL',
  PRIMARY KEY  (`cal_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Data dump for tabellen `webcal_reminders`
--


-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `webcal_report`
--

DROP TABLE IF EXISTS `webcal_report`;
CREATE TABLE `webcal_report` (
  `cal_login` varchar(25) NOT NULL,
  `cal_report_id` int(11) NOT NULL,
  `cal_is_global` char(1) NOT NULL default 'N',
  `cal_report_type` varchar(20) NOT NULL,
  `cal_include_header` char(1) NOT NULL default 'Y',
  `cal_report_name` varchar(50) NOT NULL,
  `cal_time_range` int(11) NOT NULL,
  `cal_user` varchar(25) default NULL,
  `cal_allow_nav` char(1) default 'Y',
  `cal_cat_id` int(11) default NULL,
  `cal_include_empty` char(1) default 'N',
  `cal_show_in_trailer` char(1) default 'N',
  `cal_update_date` int(11) NOT NULL,
  PRIMARY KEY  (`cal_report_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Data dump for tabellen `webcal_report`
--


-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `webcal_report_template`
--

DROP TABLE IF EXISTS `webcal_report_template`;
CREATE TABLE `webcal_report_template` (
  `cal_report_id` int(11) NOT NULL,
  `cal_template_type` char(1) NOT NULL,
  `cal_template_text` text,
  PRIMARY KEY  (`cal_report_id`,`cal_template_type`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Data dump for tabellen `webcal_report_template`
--


-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `webcal_site_extras`
--

DROP TABLE IF EXISTS `webcal_site_extras`;
CREATE TABLE `webcal_site_extras` (
  `cal_id` int(11) NOT NULL default '0',
  `cal_name` varchar(25) NOT NULL,
  `cal_type` int(11) NOT NULL,
  `cal_date` int(11) default '0',
  `cal_remind` int(11) default '0',
  `cal_data` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Data dump for tabellen `webcal_site_extras`
--


-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `webcal_timezones`
--

DROP TABLE IF EXISTS `webcal_timezones`;
CREATE TABLE `webcal_timezones` (
  `tzid` varchar(100) NOT NULL default '',
  `dtstart` varchar(25) default NULL,
  `dtend` varchar(25) default NULL,
  `vtimezone` text,
  PRIMARY KEY  (`tzid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Data dump for tabellen `webcal_timezones`
--


-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `webcal_user`
--

DROP TABLE IF EXISTS `webcal_user`;
CREATE TABLE `webcal_user` (
  `cal_login` varchar(25) NOT NULL,
  `cal_passwd` varchar(32) default NULL,
  `cal_lastname` varchar(25) default NULL,
  `cal_firstname` varchar(25) default NULL,
  `cal_is_admin` char(1) default 'N',
  `cal_email` varchar(75) default NULL,
  `cal_enabled` char(1) default 'Y',
  `cal_telephone` varchar(50) default NULL,
  `cal_address` varchar(75) default NULL,
  `cal_title` varchar(75) default NULL,
  `cal_birthday` int(11) default NULL,
  `cal_last_login` int(11) default NULL,
  `role_id` tinyint(4) default NULL,
  `site_id` tinyint(4) default NULL,
  `group_id` smallint(6) default NULL,
  `count` int(11) default NULL,
  `age_range` varchar(10) default NULL,
  `qualifications` varchar(255) default NULL,
  `notes` varchar(255) default NULL,
  `ext_login` varchar(64) default NULL,
  `def_date` timestamp NULL default NULL,
  `def_user` varchar(25) default NULL,
  `upd_date` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `upd_user` varchar(25) default NULL,
  PRIMARY KEY  (`cal_login`),
  KEY `group_id` (`group_id`),
  KEY `role_id` (`role_id`),
  KEY `site_id` (`site_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Data dump for tabellen `webcal_user`
--

INSERT INTO `webcal_user` (`cal_login`, `cal_passwd`, `cal_lastname`, `cal_firstname`, `cal_is_admin`, `cal_email`, `cal_enabled`, `cal_telephone`, `cal_address`, `cal_title`, `cal_birthday`, `cal_last_login`, `role_id`, `site_id`, `group_id`, `count`, `age_range`, `qualifications`, `notes`, `ext_login`, `def_date`, `def_user`, `upd_date`, `upd_user`) VALUES
('admin', '21232f297a57a5a743894a0e4a801fc3', 'ADMINISTRATOR', 'DEFAULT', 'Y', NULL, 'Y', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', NULL),
('agh', '37ee804a8d31f41305a138d16f41bebc', 'Givskov', 'Anders', 'N', 'agh@spejdernet.dk', 'Y', '61612655', 'andeby', '', NULL, NULL, 1, 1, 0, 1, '1', '', '', '', NULL, NULL, '2009-09-12 01:52:04', 'tho'),
('andreas.bastrup', '626eff808b164f2c941730a13187f50d', 'Larsen', 'Andreas Bastrup', 'N', 'andreas.bastrup@gmail.com', 'Y', '24602588', 'Kastaniely 14, 5690 Tommerup', '', NULL, NULL, 3, 1, 3710, 1, '16', 'Rigtig god til at arbejde med opsætning af computere og servere', '', '', NULL, NULL, '2009-09-18 22:36:07', 'andreas.bastrup'),
('askepot5', '6fae428a808de4480d301ff4a5535764', 'Smedegaard', 'Anitta', 'N', '', 'Y', '21468464', 'Dyrehavegårdsvej 3 1.tv', '', NULL, NULL, 3, 1, 0, 1, '27', 'Fysioterapeut', '', '', '2009-09-13 15:27:55', '__public__', '2009-09-13 15:27:55', '__public__'),
('bebe', '1364cba01e0ee80ef4381175bd6cf0d3', 'Skøtt Bébe', 'Dorthe', 'N', 'db@kfumspejderne.dk', 'Y', '21291767', 'Lykkesvej 7, 7400 Herning', '', NULL, NULL, 5, 1, 0, 1, '1', '', '', '', '2009-09-12 01:37:28', 'tho', '2009-09-12 01:37:28', 'tho'),
('benjamincallesen', 'f8376a822c2eb027138253c3b46fd89c', 'Callesen', 'Benjamin', 'N', 'benjamincallesen@spejdermet.dk', 'Y', '28599525', 'Lokesager 6/6500/Vojens', '', NULL, NULL, 3, 1, 4606, 1, '20', '', '', 'benjamincallesen', '2009-09-13 00:17:34', '__public__', '2009-09-13 00:17:34', '__public__'),
('borgemoller', 'e53a3140c1d4ccf7dc1caf840da64489', 'Møller', 'Børge', 'N', 'boergemoeller@spejdernet.dk', 'Y', '23714355', 'Skovbrynet 42, 8670 Låsby', '', NULL, NULL, 5, 1, 0, 1, '1', '', '', '', '2009-09-12 01:45:25', 'tho', '2009-09-12 01:45:25', 'tho'),
('bothygesen', 'fb3af468fdf58e553f1a9e59983e786e', 'Thygesen', 'Bo', 'N', 'thyges@teknik.dk', 'Y', '40824872', 'Niels Kjeldsens vej 14, 7500 Holstebro', '', NULL, NULL, 4, 1, 0, 1, '36', '', '', '', '2009-09-12 01:22:14', 'tho', '2009-09-14 01:39:38', 'bothygesen'),
('brian', 'ae1ec82448045084a573eef1d607a4cc', 'benzon', 'brian von', 'N', 'bbvb@live.dk', 'Y', '40841533', 'kvinderupvej 24 b', 'klintefolket', NULL, NULL, 3, 1, 1502, 1, '29', 'maskinfører mv', 'forsøger at finde et klanprojekt ellers alene', '', '2009-09-15 20:56:10', '__public__', '2009-09-15 20:56:10', '__public__'),
('B_Mortensen', '1ffc64b720585dc32a0e77f19938b9bb', 'Mortensen', 'Brian', 'N', 'bm@trolderik.dk', 'Y', '26369455', 'Svenstrupvang 11/4622/Havdrup', '', NULL, NULL, 2, 1, 1004, 1, '31', 'Håndværker', 'Bare jeg gør en nytte', 'brianmortensen', '2009-09-21 22:38:14', '__public__', '2009-09-21 22:38:14', '__public__'),
('cbaarregaard', 'ea5150f6272ff584eadac5eadb80fdf4', 'Baarregaard', 'Carsten', 'N', 'baarregaard@hotmail.com', 'Y', '26142208', 'Kungsgatan 30B LGH 4, 21149 Malmö, Sverige', 'toXic', NULL, NULL, 3, 1, 1606, 1, '28', 'Hængerkort CE', 'Madforsynings udkørsel', 'CarstenBaarregaard', '2009-09-17 01:31:44', '__public__', '2009-09-17 01:33:05', 'cbaarregaard'),
('cdhb', '4390e15480ab168693d0fd83168da47a', 'Bunde', 'Camilla', 'N', 'camilla-bunde@hotmail.com', 'Y', '29648227', 'Østerbrogade 44, 2. tv 2100 københavn Ø', '', NULL, NULL, 3, 1, 1302, 1, '21', '', '', 'cdhb', '2009-09-25 11:53:17', '__public__', '2009-09-25 11:53:17', '__public__'),
('cfasmer', 'b2233110c872abddb4cf7e57b2b5f2cb', 'Fasmer', 'Claus', 'N', 'fasmer@gmail.com', 'Y', '23670141', 'Ejlersvej 60, 1.th., 4700 Næstved', '', NULL, NULL, 3, 1, 3005, 1, '41', 'Vagt udd./Scene erfaring', 'Var på sidste lejr i Guldborgsund, lysmand på scenen', NULL, NULL, NULL, '0000-00-00 00:00:00', NULL),
('charlotte', '8f7cced1844059af79a4129dce180f53', 'Pedersen', 'charlotte', 'N', 'lottep77@gmail.com', 'Y', '29824063', '7600 struer', '', NULL, NULL, 3, 1, 0, 1, '32', 'arbejder i en akutmodtagelse', '', '', '2009-09-13 19:06:57', '__public__', '2009-09-13 19:06:57', '__public__'),
('ChristenFihl', '6aa396116d6f4c1585724f99e7378f58', 'Fihl', 'Christen', 'N', 'Christen@Fihl.net', 'Y', '22444877', 'Jellingvej 6, 3650 Ølstykke', '', NULL, NULL, 3, 1, 1511, 1, '54', 'software til alarm, 112, telefoni, gps, ', 'Radioamatør oz1aab. \r\nProfessionel: Software og hardware til alarm, 112, telefoni, gps, ', NULL, NULL, NULL, '0000-00-00 00:00:00', NULL),
('Clausw', 'a6008231fa64ff879ecb286a657b6a99', 'Wistrøm', 'Claus ', 'N', 'cwistrom@gmail.com', 'Y', '61677746', '3000', '', NULL, NULL, 3, 1, 2104, 1, '51', '', '', NULL, NULL, NULL, '0000-00-00 00:00:00', NULL),
('DorteJH', 'b0dbec39bcb9f50de8243e920d11171c', 'Hansen', 'Dorte', 'N', 'djh@bygmarksvej.dk', 'Y', '20861304', 'Bygmarksvej 6, 8800 Tjele', '', NULL, NULL, 3, 1, 8709, 1, '43', 'Køkken ass.', '', NULL, NULL, NULL, '0000-00-00 00:00:00', NULL),
('finndybbol', '97708a9de12bf493c9ee87767f0104c2', 'Dybbøl', 'Finn', 'N', 'fidni@tdc.dk', 'Y', '40302550', 'Baggesensvænge 1, 4700 Næstved', '', NULL, NULL, 5, 1, 0, 1, '1', '', '', '', '2009-09-12 01:38:50', 'tho', '2009-09-12 01:38:50', 'tho'),
('Foghmar', '6b20018464f0d4f3a6586afd589740d2', 'Foghmar', 'Mads', 'N', 'mads@foghmar.dk', 'Y', '24613580', 'Bredager 23 st tv 2605 Brøndby', '', NULL, NULL, 3, 1, 0, 1, '24', '', '', '', '2009-09-22 08:27:00', '__public__', '2009-09-22 08:27:00', '__public__'),
('glv', 'a908318f5a08200c50566a13bbf2a157', 'Kværnø', 'Bjarke', 'N', 'glv@get2net.dk', 'Y', '26680058', 'Baggesensgade 23. tv. 2200 Kbh. N.', '', NULL, NULL, 3, 1, 1111, 1, '35', 'Erfaring med PA og diskotekslyd og opstilling ', '', 'bjarkenorupkvaernoe', '2009-09-24 19:01:20', '__public__', '2009-09-24 19:01:20', '__public__'),
('Greenscout', 'fc547a6eea67e2faaf9c746b3b4ad7f4', 'Kristensen', 'Brian', 'N', 'brikri@sol.dk', 'Y', '22168006', 'skovbrynet 20 9640 farsø', 'Sanitet', NULL, NULL, 2, 1, 8803, 1, '32', 'Embedsmand', 'Går der lort i den, er det noget pis for så er det min skyld...', 'Greenscout', '2009-09-17 10:07:34', '__public__', '2009-09-17 10:07:34', '__public__'),
('Groenfeldt', 'dde9b6cbdb9b68b32c4783b52ccb5561', 'Petersen', 'David Grønfeldt ', 'N', 'davidgroenfeldt@gmail.com', 'Y', '22187022', 'Bækvej 2, 1.th, Varnæs, 6200 Aabenraa', '', NULL, NULL, 2, 1, 6504, 2, '29', '', '', '', '2009-09-12 13:22:46', '__public__', '2009-09-12 13:22:46', '__public__'),
('HanneGlud', 'c5cc9b50ad046d0c20e81d1fea666103', 'Glud', 'Hanne', 'N', 'hanne.glud@ail.dk', 'Y', '28553054', 'Bredgade 15 8850 Bjerringbro', '', NULL, NULL, 3, 1, 6324, 1, '40', '', '', 'HanneGlud', '2009-09-20 13:52:29', '__public__', '2009-09-20 13:52:29', '__public__'),
('hannelang', '6ed4212756611395517bba6252683d30', 'lang', 'hanne', 'N', 'hanne@langsisters.net', 'Y', '23445331', 'Møllegade 36, 8700 Horsens', '', NULL, NULL, 3, 1, 6507, 1, '60', '', 'Ved ikke endnu, om jeg er ledig til hjælp', 'Hanne.Lang', '2009-09-12 21:37:49', '__public__', '2009-09-12 21:37:49', '__public__'),
('hansdaugaard', 'ce070b5266ecb739f16686b4e37b87f7', 'Daugaard', 'Hans', 'N', 'hansludvigdaugaard@spejdernet.dk', 'Y', '22652628', 'Jordrupvej 16, 6600 Vejen', '', NULL, NULL, 5, 1, 0, 1, '42', '', '', '', '2009-09-12 01:42:11', 'tho', '2009-09-16 21:39:43', 'hansdaugaard'),
('hekjje', '379bbef790d302ef85e5a04654a4067d', 'Jepsen', 'Henrik', 'N', 'hekjje@hekjje.dk', 'Y', '23672939', 'Villestoftehaven 51, 5210 Odense NV', '', NULL, NULL, 4, 1, 0, 1, '1', '', '', '', '2009-09-12 01:08:38', 'tho', '2009-09-12 01:08:38', 'tho'),
('hellesoee', '52c64d45b8726f1881be9b5c0d461fa1', 'Hellesøe', 'Claus', 'N', 'Claus@hellesoee.dk', 'Y', '97534225', 'Vejlgårdvej 20, 7800 Skive', '', NULL, NULL, 4, 1, 0, 1, '1', '', '', '', '2009-09-12 01:06:52', 'tho', '2009-09-12 01:06:52', 'tho'),
('ireneschmidt', '0d529a3f28433bd2bfa52f4216bb92d7', 'Schmidt', 'Irene', 'N', 'Fam.schmidt@sport.dk', 'Y', '00000000', 'abcd', '', NULL, NULL, 4, 1, 0, 1, '1', '', '', '', '2009-09-12 01:17:42', 'tho', '2009-09-12 01:17:42', 'tho'),
('jacoblarsen', 'ac608127bfd70911131202adae451623', 'Larsen', 'Jacob', 'N', 'jla@plan.dk', 'Y', '20645442', 'H.C. Ørstedsvej 71, 2.tv, 7400 Herning', '', NULL, NULL, 5, 1, 0, 1, '1', '', '', '', '2009-09-12 01:47:54', 'tho', '2009-09-12 01:47:54', 'tho'),
('jakobbang', 'b946968e8ca33c2758b2e17a970c6a8d', 'A. Bang', 'Jakob', 'N', 'Jakob@spejdernet.dk', 'Y', '26532151', 'Fredensgade 13,2 – 211, 6000 Kolding', '', NULL, NULL, 4, 1, 0, 1, '1', '', '', '', '2009-09-12 01:20:22', 'tho', '2009-09-12 01:20:22', 'tho'),
('JakobLykke', 'b41577db17345eaf18dbf1aeffe9f28b', 'Kirkegaard', 'Jakob', 'N', 'jakob_lk@hotmail.com', 'Y', '51203107', 'Brøndumsgade 33 1 sal.', 'Klan Bubbibjørnene', NULL, NULL, 3, 1, 8320, 3, '23', '', '', NULL, NULL, NULL, '0000-00-00 00:00:00', NULL),
('Jakri9', '709d5dac52c543106857559f9a033bf8', 'Kristoffersen', 'Jakob', 'N', 'jakobkristoffersen@spejdernet.dk', 'Y', '30586597', 'aabylundvænget 5/5580/Nr.Aaby', '', NULL, NULL, 3, 1, 3707, 1, '17', 'kreativ/organiseret/organisator/amatør fotograf', 'altid klar med en hjælpene hånd og er  meget organiseret,kreativ og er altid klar med en hjælpene hånd. elskaer at tage billeder og lave journalistik samt er jeg god til at tale engelsk da jeg har været udvekslingsstudent', NULL, NULL, NULL, '0000-00-00 00:00:00', NULL),
('Jemmer', '31129dded2c0aa02d061f4fb66d449aa', 'Hansen', 'James', 'N', 'james@hjemmer.dk', 'Y', '26209738', 'Gammel Slimmingevej 6, 4100 ringsted', '', NULL, NULL, 3, 1, 3222, 1, '27', '', 'Har trailerkort, truckkort, kan køre de fleste entreprenør maskine, tele læsser mv.\r\nEr ikke elektrikker, men maskinmester med en del el uddandelse. Arbejder dagligt med et større IT net (Mest Cisco, Dslam og serviceprovider tek)\r\n\r\nMin største force er i', 'JamesRuneHansen', '2009-09-20 22:21:34', '__public__', '2009-09-20 22:21:34', '__public__'),
('jesper', 'f510fddcffbd90f55f09eebe5021a4c1', 'pedersen', 'jesper michael', 'N', 'grejs@osterbo-net.dk', 'Y', '22401259', 'parkvej 31, 3th 7100 vejle', '', NULL, NULL, 3, 1, 6103, 1, '34', 'uddannet køkkenassistent', 'Jeg søger job indenfor cafe eller resturant!\r\nJeghar været med som hjælper ved korpslejren 2000 og 2005, samt ved KFUK´s landslejr i 2002 i resturaten, jeg synes det er en stor fornøjelse at hjælpe!!!', '', '2009-09-24 00:35:32', '__public__', '2009-09-24 00:35:32', 'jesper'),
('jesperholm', 'e2d307bb4e65aa61f3ba46f5087b0844', 'Holm Pedersen', 'Jesper', 'N', 'Jesper@kfumspejderne.dk', 'Y', '26796615', 'Møllehaven 69, 3550 Slangerup', '', NULL, NULL, 5, 1, 0, 1, '1', '', '', '', '2009-09-12 01:43:20', 'tho', '2009-09-12 01:43:20', 'tho'),
('JoanAndersen', 'a455349c4972aa959cf5d3ac4868d095', 'Andersen', 'Joan', 'N', '', 'Y', '29933256', '6700', '', NULL, NULL, 3, 1, 0, 1, '23', '', '', '', '2009-09-13 19:12:19', '__public__', '2009-09-13 19:12:19', '__public__'),
('joergenpaarup', '9832fb9394f755d5977a5792af4f2507', 'Paarup', 'Jørgen', 'N', 'paarup@kfumspejderne.dk', 'Y', '51388207', 'Uhrevej 11, 6064 Jordrup', '', NULL, NULL, 5, 1, 0, 1, '1', '', '', '', '2009-09-12 01:33:18', 'tho', '2009-09-12 01:33:18', 'tho'),
('johnboll', '1ad07a5bccd04a42208f180d86678753', 'Boll', 'John', 'N', 'jobo@kfumspejderne.dk', 'Y', '51524380', 'Porsmark 5, Thissinghuse, 7970 Redsted', '', NULL, NULL, 5, 1, 0, 1, '1', '', '', '', '2009-09-12 01:34:58', 'tho', '2009-09-12 01:34:58', 'tho'),
('Jonathan_Simmel', 'ef49c66f32b21aaa6cd94f4ef01087a2', 'Olsen', 'Jonathan Simmel', 'N', 'jsimmel@gmail.com', 'Y', '23698004', 'Pragtstjernevej 21. 2tv 2400 KBH NV', '', NULL, NULL, 3, 1, 1302, 1, '22', '', '', '', '2009-09-13 22:31:04', '__public__', '2009-09-13 22:31:04', '__public__'),
('jornbrasmussen', 'ec34ab51842c0c4dd543d6eb04894c23', 'Rasmussen', 'Jørn', 'N', '', 'Y', '2097 3736', 'Hostrupvænget 3, 5700 Svendborg', '', NULL, NULL, 3, 1, 3813, 2, '65', 'Samme job på Guldsundlejren', 'Kører intern transport', '', '2009-09-18 10:38:32', '__public__', '2009-09-23 23:16:46', 'jornbrasmussen'),
('jroermose', '3eea43baf737879b4577320f4f4d6ab8', 'Rørmose', 'Jakob', 'N', 'jakob@roermose.dk', 'Y', '29227738', 'Fruenshave 10/8732/Hovedgård', '', NULL, NULL, 3, 1, 0, 1, '43', '', '', NULL, NULL, NULL, '0000-00-00 00:00:00', NULL),
('Kristian_weis', 'e6379fff8d68d58db961aaaa85eaa8b0', 'Weis', 'kristian', 'N', 'kgweis@gmail.com', 'Y', '25328984', 'grøfthøjparken 163, 11 tv', 'Klan Flambé', NULL, NULL, 3, 1, 7909, 1, '27', 'uddannet brandmand ved beredskabsstyrelsen (05), førstehjølpskursus ved hjemmeværnet (09)', 'vil gerne i beredskabs afdelingen.', 'KristianGottliebWeis', '2009-09-13 17:31:07', '__public__', '2009-09-13 17:31:07', '__public__'),
('larsgj', 'c32c6f5b26cd3416b4a18847a2a187a5', 'Jørgensen', 'Lars Gjerløw', 'N', 'larsgjerlowjorgensen@gmail.com', 'Y', '20771112', 'Hærvejen 75, 7182 Bredsten', '', NULL, NULL, 3, 1, 4907, 1, '34', 'Undervisning/instruktion (er skolelærer) / radioamatør / knob / tovværksarbejder / koder ', 'Er med som Tropleder / familiefar for 2½-årig+½-årig. Derfor er jeg mest interesseret i aktiviteter der foregår nogle bestemte dage (to-tre) fremfor at være fast ansvarlig hele ugen (så bliver min kone nok lidt træt...)', 'LarsGJoergensen', '2009-09-23 17:11:10', '__public__', '2009-09-23 17:11:10', '__public__'),
('lottep', 'a7b381f53681e2cdf95e7891a8333293', 'pedersen', 'Charlotte', 'N', 'lottep77@gmail.com', 'Y', '29824063', 'Bygmarken 9', 'Resen- Humlum gruppe', NULL, NULL, 3, 1, 8110, 1, '33', '', 'jeg ønsker at arbejde på lejrens hospital', 'lottep', '2009-09-23 21:15:34', '__public__', '2009-09-23 21:17:03', 'lottep'),
('Madchef', '8317e064c240455b79ecfdb5cc3c1c8f', 'Sander', 'Bo', 'N', 'bosander@kfumspejderne.dk', 'Y', '40559037', '6091 Bjert', '', NULL, NULL, 2, 1, 0, 1, 'x', '', '', NULL, NULL, NULL, '0000-00-00 00:00:00', NULL),
('MartinFionia', '2a91d8492e5888c8386e02a5da9aae35', 'Nielsen', 'Martin', 'N', 'martin_nielsen@hostmail.dk', 'Y', '61364284', 'Sportsvej 5', '', NULL, NULL, 2, 1, 3704, 0, '32', '', 'Opretter mig selv herinde, da jeg er drift og teknik ansvarlig i staben i underlejr 3 (ULC Jørgen Jepsen) og ønsker overblik og adgang til så meget data som muligt. Det er nemmere at koordinere ting når man ved hvem der stiller sig til rådighed for lejren', 'martinnielsen1', '2009-09-16 08:09:49', '__public__', '2009-09-16 08:09:49', '__public__'),
('mogensbahnsen', '597b26ec38e3442ed61bc1b74a3d232d', 'Bahnsen', 'Mogens', 'N', 'Mogens.Bahnsen@kfumscout.dk', 'Y', '23286288', 'Bissensvej 32, 7000 Fredericia', '', NULL, NULL, 4, 1, 0, 1, '1', '', '', '', '2009-09-12 01:16:32', 'tho', '2009-09-12 01:16:32', 'tho'),
('Morten And', 'e9794495182459363fb437bd781fe0d0', 'Ravnholt', 'Morten', 'N', '', 'Y', '26200028', 'Skovvej 2 5550 Langeskov', '', NULL, NULL, 3, 1, 3605, 1, '28', 'Uddannet maskinføre, stillads kurser: Drop stillads, fasade stillads, rør og koblinger', '', NULL, NULL, NULL, '0000-00-00 00:00:00', NULL),
('Ove', '84aff1fbedf1a3a2c3cfb85b64dbc911', 'Meier', 'Hans Ove ', 'N', 'meier_hipholm@mail.dk', 'Y', '24629711', 'Hipholm 6, Varnæs, 6200 Aabenraa', '', NULL, NULL, 3, 1, 4402, 1, '44', 'Brandmand', 'Brandberedskab', NULL, NULL, NULL, '0000-00-00 00:00:00', NULL),
('per', '2eec2245df990aa35a2a05db29fbfb06', 'Kousgaard Thomsen', 'Per', 'N', 'pkthomsen@pc.dk', 'Y', '55441671 - 29441671', 'Møllevej 9, 8832 Skals', '', NULL, NULL, 1, 1, 0, 1, '1', '', '', NULL, NULL, NULL, '0000-00-00 00:00:00', NULL),
('povledvard', 'a28263b3b5ac009b09442217f2328a5d', 'Edvard Hansen', 'Povl', 'N', 'povledvard@email.dk', 'Y', '40210940', 'abcd', '', NULL, NULL, 4, 1, 0, 1, '1', '', '', NULL, '2009-09-12 01:10:00', NULL, '2009-09-12 01:10:00', NULL),
('Randerup', '935f099f5e344faddbae2ad5d08b681a', 'Randerup', 'Ole', 'N', 'ore@live.dk', 'Y', '20208044', 'Orevej 3, 4760 Vordingborg', '', NULL, NULL, 3, 1, 0, 1, '39', 'Uddannet Samarit med lederfunktion i Dansk Røde Kors', 'Jeg er gammel grøn spejder, og har bl. andet været gruppeleder i Bogø Gruppe, jeg kunne derfor godt tænke mig at hjælpe inde for det førstehjælpsmessige, jeg er i øjeblikket frivillig Samaritter/førstehjælper med over 120 timers uddannelse og over 11 års ', '', '2009-09-16 23:08:11', '__public__', '2009-09-22 17:13:52', 'Randerup'),
('renenielsen4', 'ea98a8ea17ab7f8003925777a025878a', 'Nielsen', 'Rene', 'N', 'rene_nielsen@dialog.dk', 'Y', '30859484', 'Nygade 112 7430 ikast', '', NULL, NULL, 3, 1, 7015, 1, '26', '', '', NULL, NULL, NULL, '0000-00-00 00:00:00', NULL),
('rikkesn', '69ca9f3803c9ae2b0379165bc608af98', 'S. Neuenschwander', 'Rikke', 'N', 'see2010@kfumspejderne.dk', 'Y', '23285436', 'Jelsvej 10, 4600 Køge', '', NULL, NULL, 5, 1, 0, 1, '1', '', '', '', '2009-09-12 01:44:27', 'tho', '2009-09-22 23:25:59', 'rikkesn'),
('sorenyde', '1c8ae8ebbbfa864945961838a45212f5', 'Yde', 'Søren', 'N', 'sy@kfumspejderne.dk', 'Y', '30950887', 'Ahornvænget 102, 7800 Skive', '', NULL, NULL, 5, 1, 0, 1, '1', '', '', '', '2009-09-12 01:41:11', 'tho', '2009-09-12 01:41:11', 'tho'),
('spejdermanden', '611255cae5f964370d4bb6fe2ef6e9f3', 'Pedersen', 'Brian', 'N', '', 'Y', '25388462', 'Marie bregendahlsvej 90 7430 ikast', '', NULL, NULL, 3, 1, 0, 1, '26', '', '', '', '2009-09-20 12:17:32', '__public__', '2009-09-20 12:17:32', '__public__'),
('steen', '6fa81a1534625d17a213377a53517558', 'Villekold Rasmussen', 'Steen', 'N', 'Steenvr@ofir.dk', 'Y', '24431057', 'Vester Skivevej 2, 7800 Skive', '', NULL, NULL, 1, 1, 0, 1, '1', '', '', NULL, NULL, NULL, '0000-00-00 00:00:00', NULL),
('testarbejdsgiver', 'e9c21c68899c781e31a927acd9a1d42b', 'Arbejdsgiver', 'TestAG', 'N', '', 'Y', '12345678', '1234', '', NULL, NULL, 2, 1, 0, 1, '1', '', '', '', NULL, NULL, '2009-09-12 01:28:27', 'tho'),
('testbruger', '71b7161492b5d45f96b8eac0008ad023', 'Bruger', 'TestB', 'N', '', 'Y', '12345678', '1234', '', NULL, NULL, 3, 1, 0, 1, '1', '', '', NULL, NULL, NULL, '2009-09-12 00:53:03', NULL),
('tho', 'd9eaabe53adedb62bc74b7eb0a9477d4', 'Højgaard Olesen', 'Thorbjørn', 'N', 'tho@thodata.dk', 'Y', '27284500', 'Galstersgade 2, 1, 9400 Nørresundby', 'Klan Rosa', NULL, NULL, 1, 1, 9208, 1, '28', '', '', NULL, NULL, NULL, '0000-00-00 00:00:00', NULL),
('tommystub', '82647f2bcdb9946c6f7ecffdc91a3816', 'Stub', 'Tommy', 'N', 'tommystub@spejdernet.dk', 'Y', '20168145', 'Linkenkærsvej 8, 5700 Svendborg', '', NULL, NULL, 4, 1, 0, 1, '1', '', '', 'tommystub', '2009-09-15 22:44:38', 'tho', '2009-09-15 22:44:38', 'tho'),
('uffeebenau', 'e6b134a0f330163430b4421ddbcaa816', 'Ebenau', 'Uffe', 'N', 'uffeebenau@spejdernet.dk', 'Y', '23868653', 'Dydyrvej 28, 4623 Lille-Skensved', '', NULL, NULL, 4, 1, 0, 1, '1', '', '', 'uffeebenau', '2009-09-12 01:13:08', 'tho', '2009-09-12 01:13:08', 'tho'),
('vinther', '31fad63ccfb5c81515dcbb979845e50c', 'Færch', 'Søren', 'N', 'svfaerch@hotmail.com', 'Y', '40689638', 'Stationsvej 71, 3. tv., 9400, Nørresundby', '', NULL, NULL, 3, 1, 9304, 1, '24', 'Førstehjælpsinstuktør', '', NULL, NULL, NULL, '0000-00-00 00:00:00', NULL),
('voksam', '8278fd9c1457e6432bfcd21899d40488', 'maskov', 'lennart', 'N', 'lennart@maskov.dk', 'Y', '22804266', 'Hovvej 88, C10 - 8370 Hadsten', '', NULL, NULL, 3, 1, 5008, 1, '35', 'Deltids brandmand', 'Hej.\r\nDa jeg ikke har nogen direkte tilknytning til børnene i seest gruppe, men rigtig gerne vil med på korpslejr. Så tænkte jeg på om ikke at jeg kunne komme med som brandmand, da jeg er deltids brandmand i Hadsten, udover dette er jeg også uddannet vvs''', 'lennartmaskov', '2009-09-13 15:09:06', '__public__', '2009-09-13 15:13:00', 'voksam');

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `webcal_user_layers`
--

DROP TABLE IF EXISTS `webcal_user_layers`;
CREATE TABLE `webcal_user_layers` (
  `cal_layerid` int(11) NOT NULL default '0',
  `cal_login` varchar(25) NOT NULL,
  `cal_layeruser` varchar(25) NOT NULL,
  `cal_color` varchar(25) default NULL,
  `cal_dups` char(1) default 'N',
  PRIMARY KEY  (`cal_login`,`cal_layeruser`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Data dump for tabellen `webcal_user_layers`
--


-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `webcal_user_pref`
--

DROP TABLE IF EXISTS `webcal_user_pref`;
CREATE TABLE `webcal_user_pref` (
  `cal_login` varchar(25) NOT NULL,
  `cal_setting` varchar(25) NOT NULL,
  `cal_value` varchar(100) default NULL,
  PRIMARY KEY  (`cal_login`,`cal_setting`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Data dump for tabellen `webcal_user_pref`
--

INSERT INTO `webcal_user_pref` (`cal_login`, `cal_setting`, `cal_value`) VALUES
('admin', 'LANGUAGE', 'English-US'),
('agh', 'LANGUAGE', 'Danish'),
('andreas.bastrup', 'LANGUAGE', 'English-US'),
('askepot5', 'LANGUAGE', 'Danish'),
('benjamincallesen', 'LANGUAGE', 'English-US'),
('bothygesen', 'LANGUAGE', 'Danish'),
('brian', 'LANGUAGE', 'Danish'),
('B_Mortensen', 'LANGUAGE', 'Danish'),
('cbaarregaard', 'LANGUAGE', 'Danish'),
('cdhb', 'LANGUAGE', 'Danish'),
('cfasmer', 'LANGUAGE', 'Danish'),
('ChristenFihl', 'LANGUAGE', 'Danish'),
('Clausw', 'LANGUAGE', 'Danish'),
('DorteJH', 'LANGUAGE', 'Danish'),
('Foghmar', 'LANGUAGE', 'Danish'),
('glv', 'LANGUAGE', 'Danish'),
('Groenfeldt', 'LANGUAGE', 'Danish'),
('HanneGlud', 'LANGUAGE', 'Danish'),
('hannelang', 'LANGUAGE', 'Danish'),
('hansdaugaard', 'LANGUAGE', 'Danish'),
('jacoblarsen', 'LANGUAGE', 'Danish'),
('JakobLykke', 'LANGUAGE', 'English-US'),
('Jemmer', 'LANGUAGE', 'English-US'),
('jesper', 'LANGUAGE', 'Danish'),
('JoanAndersen', 'LANGUAGE', 'Danish'),
('Jonathan_Simmel', 'LANGUAGE', 'Danish'),
('jornbrasmussen', 'LANGUAGE', 'Danish'),
('jroermose', 'LANGUAGE', 'Danish'),
('Kristian_weis', 'LANGUAGE', 'Danish'),
('larsgj', 'LANGUAGE', 'English-US'),
('lottep', 'LANGUAGE', 'Danish'),
('MartinFionia', 'LANGUAGE', 'Danish'),
('Morten And', 'LANGUAGE', 'Danish'),
('Ove', 'LANGUAGE', 'Danish'),
('Randerup', 'LANGUAGE', 'Danish'),
('renenielsen4', 'LANGUAGE', 'Danish'),
('rikkesn', 'LANGUAGE', 'Danish'),
('spejdermanden', 'LANGUAGE', 'Danish'),
('steen', 'LANGUAGE', 'Danish'),
('testarbejdsgiver', 'LANGUAGE', 'Danish'),
('testbruger', 'LANGUAGE', 'Danish'),
('testbruger2', 'LANGUAGE', 'Danish'),
('tho', 'LANGUAGE', 'Danish'),
('tommystub', 'LANGUAGE', 'Danish'),
('vinther', 'LANGUAGE', 'Danish'),
('voksam', 'LANGUAGE', 'Danish');

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `webcal_user_template`
--

DROP TABLE IF EXISTS `webcal_user_template`;
CREATE TABLE `webcal_user_template` (
  `cal_login` varchar(25) NOT NULL,
  `cal_type` char(1) NOT NULL,
  `cal_template_text` text,
  PRIMARY KEY  (`cal_login`,`cal_type`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Data dump for tabellen `webcal_user_template`
--

INSERT INTO `webcal_user_template` (`cal_login`, `cal_type`, `cal_template_text`) VALUES
('__system__', 'T', '<div><a href="jc_menu.php">JobCenter Menu</a></div>');

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `webcal_view`
--

DROP TABLE IF EXISTS `webcal_view`;
CREATE TABLE `webcal_view` (
  `cal_view_id` int(11) NOT NULL,
  `cal_owner` varchar(25) NOT NULL,
  `cal_name` varchar(50) NOT NULL,
  `cal_view_type` char(1) default NULL,
  `cal_is_global` char(1) NOT NULL default 'N',
  PRIMARY KEY  (`cal_view_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Data dump for tabellen `webcal_view`
--


-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `webcal_view_user`
--

DROP TABLE IF EXISTS `webcal_view_user`;
CREATE TABLE `webcal_view_user` (
  `cal_view_id` int(11) NOT NULL,
  `cal_login` varchar(25) NOT NULL,
  PRIMARY KEY  (`cal_view_id`,`cal_login`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Data dump for tabellen `webcal_view_user`
--


--
-- Begrænsninger for dumpede tabeller
--

--
-- Begrænsninger for tabel `area`
--
ALTER TABLE `area`
  ADD CONSTRAINT `area_ibfk_1` FOREIGN KEY (`site_id`) REFERENCES `site` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Begrænsninger for tabel `days`
--
ALTER TABLE `days`
  ADD CONSTRAINT `days_ibfk_1` FOREIGN KEY (`site_id`) REFERENCES `site` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Begrænsninger for tabel `district`
--
ALTER TABLE `district`
  ADD CONSTRAINT `district_ibfk_1` FOREIGN KEY (`site_id`) REFERENCES `site` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `district_ibfk_2` FOREIGN KEY (`subcamp_id`) REFERENCES `subcamp` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Begrænsninger for tabel `group`
--
ALTER TABLE `group`
  ADD CONSTRAINT `group_ibfk_2` FOREIGN KEY (`site_id`) REFERENCES `site` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `group_ibfk_3` FOREIGN KEY (`district_id`) REFERENCES `district` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Begrænsninger for tabel `job`
--
ALTER TABLE `job`
  ADD CONSTRAINT `job_ibfk_1` FOREIGN KEY (`site_id`) REFERENCES `site` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `job_ibfk_2` FOREIGN KEY (`area_id`) REFERENCES `area` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `job_ibfk_3` FOREIGN KEY (`owner_id`) REFERENCES `webcal_user` (`cal_login`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Begrænsninger for tabel `subcamp`
--
ALTER TABLE `subcamp`
  ADD CONSTRAINT `subcamp_ibfk_2` FOREIGN KEY (`site_id`) REFERENCES `site` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Begrænsninger for tabel `webcal_user`
--
ALTER TABLE `webcal_user`
  ADD CONSTRAINT `webcal_user_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `webcal_user_ibfk_2` FOREIGN KEY (`site_id`) REFERENCES `site` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `webcal_user_ibfk_3` FOREIGN KEY (`group_id`) REFERENCES `group` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

SET FOREIGN_KEY_CHECKS=1;
