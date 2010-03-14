-- phpMyAdmin SQL Dump
-- version 2.10.2
-- http://www.phpmyadmin.net
-- 
-- Vært: localhost
-- Genereringstid: 23/08 2009 kl. 15:54:31
-- Serverversion: 5.0.27
-- PHP-version: 5.2.0

SET FOREIGN_KEY_CHECKS=0;

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- Database: `see2010jobcenter`
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
  PRIMARY KEY  (`id`),
  KEY `site_id` (`site_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

-- 
-- Data dump for tabellen `area`
-- 

INSERT INTO `area` (`id`, `site_id`, `name`, `description`, `contact_id`) VALUES 
(1, 1, 'DOT', 'Drift og teknik', 'tho'),
(2, 1, 'AKT', 'Aktiviteter', 'agh'),
(3, 1, 'KLU', 'Korpslejrudvalget', NULL),
(4, 1, 'INT', 'International', NULL),
(5, 1, 'KUL', 'Kultur', NULL),
(6, 1, 'LT', 'Landstræf', NULL),
(7, 1, 'ØKO', 'Økonomi', NULL),
(8, 1, 'INF', 'Infrastruktur', NULL),
(9, 1, 'PR', 'PR og kommunikation', NULL);

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
  PRIMARY KEY  (`id`),
  KEY `site_id` (`site_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

-- 
-- Data dump for tabellen `days`
-- 

INSERT INTO `days` (`id`, `site_id`, `date`, `time`) VALUES 
(1, 1, '2009-07-24', 120000),
(2, 1, '2009-07-25', NULL),
(3, 1, '2009-07-26', NULL),
(4, 1, '2009-07-27', NULL),
(5, 1, '2009-07-28', NULL),
(6, 1, '2009-07-29', NULL),
(7, 1, '2009-07-30', NULL),
(8, 1, '2009-07-31', NULL),
(9, 1, '2009-08-01', 160000);

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
  PRIMARY KEY  (`id`),
  KEY `site_id` (`site_id`),
  KEY `subcamp_id` (`subcamp_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=37 ;

-- 
-- Data dump for tabellen `district`
-- 

INSERT INTO `district` (`id`, `site_id`, `name`, `subcamp_id`) VALUES 
(1, 1, 'Aalborg Distrikt', 8),
(2, 1, 'Aggersborg Distrikt', 4),
(3, 1, 'Bastrup Distrikt', 3),
(4, 1, 'Bornholms Distrikt', 4),
(5, 1, 'Danehof Distrikt', 1),
(6, 1, 'Djursland Distrikt', 6),
(7, 1, 'Ermelunden Distrikt', 8),
(8, 1, 'Fionia Distrikt', 3),
(9, 1, 'Gudenå Distrikt', 2),
(10, 1, 'Guldhorn Distrikt', 4),
(11, 1, 'Hafnia Distrikt', 5),
(12, 1, 'Hardsyssel Distrikt', 8),
(13, 1, 'Hjorte Distrikt', 2),
(14, 1, 'Ho Bugt Distrikt', 8),
(15, 1, 'Hærulf Distrikt', 3),
(16, 1, 'Hærvejens Distrikt', 2),
(17, 1, 'Kongeå Distrikt', 6),
(18, 1, 'Lindorm Distrikt', 1),
(19, 1, 'Lovring Distrikt', 1),
(20, 1, 'Lundenæs Len Distrikt', 5),
(21, 1, 'Lyngens Distrikt', 6),
(22, 1, 'Marselis Distrikt', 7),
(23, 1, 'Midtjyske Distrikt', 1),
(24, 1, 'Munkebjerg Distrikt', 5),
(25, 1, 'Nordøstjyske Distrikt', 3),
(26, 1, 'Nydam Distrikt', 8),
(27, 1, 'Odsherred Distrikt', 3),
(28, 1, 'Ole Rømer Distrikt', 4),
(29, 1, 'Sct. Georg Distrikt', 6),
(30, 1, 'Skamling Distrikt', 7),
(31, 1, 'Suså Distrikt', 7),
(32, 1, 'Thy Distrikt', 1),
(33, 1, 'Valdemar Distrikt', 4),
(34, 1, 'Vest-Vendsyssel Distrikt', 7),
(35, 1, 'Vestlimfjord Distrikt', 2),
(36, 1, 'Østvendsyssel Distrikt', 5);

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
  PRIMARY KEY  (`id`),
  KEY `district_id` (`district_id`),
  KEY `site_id` (`site_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=9312 ;

-- 
-- Data dump for tabellen `group`
-- 

INSERT INTO `group` (`id`, `site_id`, `name`, `district_id`, `tmp_district_name`) VALUES 
(0, 1, '- Ingen', NULL, NULL),
(10, 1, 'Gjellerup Gruppe', 21, 'Lyngens Distrikt'),
(11, 1, 'Ans', 9, 'Gudenå Distrikt'),
(603, 1, 'Filip Gruppe', 11, 'Hafnia Distrikt'),
(604, 1, 'Højdevang Gruppe', 11, 'Hafnia Distrikt'),
(609, 1, 'Kastrup Gruppe', 11, 'Hafnia Distrikt'),
(610, 1, 'St.Magleby-Dragør Gruppe', 11, 'Hafnia Distrikt'),
(611, 1, 'Tårnby Gruppe', 11, 'Hafnia Distrikt'),
(612, 1, 'Vestamager Gruppe', 11, 'Hafnia Distrikt'),
(803, 1, 'Klemensker Gruppe', 4, 'Bornholms Distrikt'),
(804, 1, 'Nexø Gruppe', 4, 'Bornholms Distrikt'),
(809, 1, 'Vestermarie/Nylars Gruppe', 4, 'Bornholms Distrikt'),
(810, 1, 'Aakirkeby Gruppe', 4, 'Bornholms Distrikt'),
(902, 1, '1. Frederiksberg Gruppe', 11, 'Hafnia Distrikt'),
(903, 1, '3. Frederiksberg Gruppe', 11, 'Hafnia Distrikt'),
(904, 1, '4. Frederiksberg Gruppe', 11, 'Hafnia Distrikt'),
(905, 1, 'Lindevang Gruppe', 11, 'Hafnia Distrikt'),
(1002, 1, 'Albertslund Gruppe', 28, 'Ole Rømer Distrikt'),
(1004, 1, 'Brøndby-Vallensbæk Gruppe', 28, 'Ole Rømer Distrikt'),
(1005, 1, 'Brøndbyvester Gruppe', 28, 'Ole Rømer Distrikt'),
(1006, 1, 'KNUDEN-Brøndby Gruppe', 28, 'Ole Rømer Distrikt'),
(1007, 1, 'Fløng Gruppe', 28, 'Ole Rømer Distrikt'),
(1009, 1, 'Greve Gruppe', 28, 'Ole Rømer Distrikt'),
(1010, 1, 'Ishøj Gruppe', 28, 'Ole Rømer Distrikt'),
(1011, 1, 'Tåstrup Gruppe', 28, 'Ole Rømer Distrikt'),
(1012, 1, 'Rønnevang-Tåstrup Gruppe', 28, 'Ole Rømer Distrikt'),
(1102, 1, 'Bispebjerg Gruppe', 11, 'Hafnia Distrikt'),
(1105, 1, 'Husumvold Gruppe', 11, 'Hafnia Distrikt'),
(1106, 1, 'Hyltebjerg Gruppe', 11, 'Hafnia Distrikt'),
(1110, 1, 'Sct. Johannes Gruppe', 11, 'Hafnia Distrikt'),
(1111, 1, 'St. Stefans Gruppe', 11, 'Hafnia Distrikt'),
(1115, 1, 'Vigerslev Gruppe', 11, 'Hafnia Distrikt'),
(1202, 1, 'Avedøre Gruppe', 28, 'Ole Rømer Distrikt'),
(1204, 1, 'Hvidovre Gruppe', 28, 'Ole Rømer Distrikt'),
(1205, 1, 'Vigar Stamme Gruppe', 28, 'Ole Rømer Distrikt'),
(1206, 1, 'Hvidovre Syd Gruppe', 28, 'Ole Rømer Distrikt'),
(1207, 1, 'Islev Gruppe', 28, 'Ole Rømer Distrikt'),
(1208, 1, 'Rødovre Gruppe', 28, 'Ole Rømer Distrikt'),
(1302, 1, 'Borggruppen Gruppe', 11, 'Hafnia Distrikt'),
(1303, 1, 'Hans Egede Gruppe', 11, 'Hafnia Distrikt'),
(1304, 1, 'Lundehus Gruppe', 11, 'Hafnia Distrikt'),
(1305, 1, 'Rosenvænget Gruppe', 11, 'Hafnia Distrikt'),
(1306, 1, 'Svanemølle Gruppe', 11, 'Hafnia Distrikt'),
(1502, 1, 'Frederikssund Gruppe', 13, 'Hjorte Distrikt'),
(1505, 1, 'Halsnæs Gruppe', 13, 'Hjorte Distrikt'),
(1506, 1, 'Jægerspris Gruppe', 13, 'Hjorte Distrikt'),
(1509, 1, 'Skævinge Gruppe', 13, 'Hjorte Distrikt'),
(1510, 1, 'Slangerup Gruppe', 13, 'Hjorte Distrikt'),
(1511, 1, 'Stenløse Gruppe', 3, 'Bastrup Distrikt'),
(1513, 1, 'Ølsted Sj. Gruppe', 13, 'Hjorte Distrikt'),
(1602, 1, 'Charlottenlund Gruppe', 7, 'Ermelunden Distrikt'),
(1604, 1, 'Hellerup Gruppe', 7, 'Ermelunden Distrikt'),
(1606, 1, 'Ordrup-Skovshoved Gruppe', 7, 'Ermelunden Distrikt'),
(1607, 1, 'Vangede Gruppe', 7, 'Ermelunden Distrikt'),
(1702, 1, 'Blistrup Gruppe', 13, 'Hjorte Distrikt'),
(1703, 1, 'Esbønderup Gruppe', 13, 'Hjorte Distrikt'),
(1704, 1, 'Espergærde Gruppe', 13, 'Hjorte Distrikt'),
(1705, 1, 'Gilleleje Gruppe', 13, 'Hjorte Distrikt'),
(1706, 1, 'Græsted Gruppe', 13, 'Hjorte Distrikt'),
(1708, 1, 'Tikøb Gruppe', 13, 'Hjorte Distrikt'),
(1802, 1, '2. Bagsværd Gruppe', 3, 'Bastrup Distrikt'),
(1803, 1, 'Buddinge Gruppe', 3, 'Bastrup Distrikt'),
(1808, 1, 'Søborg Gruppe', 3, 'Bastrup Distrikt'),
(1810, 1, 'Ballerup Gruppe', 3, 'Bastrup Distrikt'),
(1811, 1, 'Herlev Gruppe', 3, 'Bastrup Distrikt'),
(1812, 1, 'Klausdal-Hjortespring Gruppe', 3, 'Bastrup Distrikt'),
(1903, 1, '1. Bistrup Gruppe', 3, 'Bastrup Distrikt'),
(1905, 1, 'Hillerød Gruppe', 13, 'Hjorte Distrikt'),
(1906, 1, 'Hørsholm Gruppe', 3, 'Bastrup Distrikt'),
(1907, 1, 'Allerød-Lynge Gruppe', 3, 'Bastrup Distrikt'),
(1908, 1, 'Nivå Gruppe', 3, 'Bastrup Distrikt'),
(2104, 1, '1. Lyngby-Lundtofte', 7, 'Ermelunden Distrikt'),
(2105, 1, '3. Lyngby Gruppe', 7, 'Ermelunden Distrikt'),
(2106, 1, 'Nærum Gruppe', 7, 'Ermelunden Distrikt'),
(2107, 1, 'Vedbæk Gruppe', 7, 'Ermelunden Distrikt'),
(2108, 1, 'Virum-Sorgenfri Gruppe', 7, 'Ermelunden Distrikt'),
(2202, 1, 'Ølstykke Gruppe', 3, 'Bastrup Distrikt'),
(2203, 1, 'Østerhøj-Måløv Gruppe', 3, 'Bastrup Distrikt'),
(2502, 1, 'Buerup Gruppe', 31, 'Suså Distrikt'),
(2503, 1, 'Dianalund Gruppe', 31, 'Suså Distrikt'),
(2504, 1, 'Fjenneslev Gruppe', 31, 'Suså Distrikt'),
(2505, 1, 'Frederiksberg Gruppe', 31, 'Suså Distrikt'),
(2506, 1, 'Høng Gruppe', 31, 'Suså Distrikt'),
(2507, 1, 'Munke Bjergby Gruppe', 31, 'Suså Distrikt'),
(2602, 1, 'Engmose Gruppe', 18, 'Lindorm Distrikt'),
(2603, 1, 'Horbelev Gruppe', 18, 'Lindorm Distrikt'),
(2604, 1, 'Idestrup Gruppe', 18, 'Lindorm Distrikt'),
(2606, 1, 'Nykøbing Falster Gruppe', 18, 'Lindorm Distrikt'),
(2607, 1, 'Toreby Gruppe', 18, 'Lindorm Distrikt'),
(2610, 1, 'Nakskov Gruppe', 18, 'Lindorm Distrikt'),
(2612, 1, 'Ravnsborg Gruppe', 18, 'Lindorm Distrikt'),
(2613, 1, 'Brandstrup Gruppe', 18, 'Lindorm Distrikt'),
(2614, 1, 'Østofte Gruppe', 18, 'Lindorm Distrikt'),
(2702, 1, 'Eskebjerg Gruppe', 27, 'Odsherred Distrikt'),
(2703, 1, 'Holbæk Gruppe', 27, 'Odsherred Distrikt'),
(2705, 1, 'Kr. Eskilstrup Gruppe', 27, 'Odsherred Distrikt'),
(2706, 1, 'Nr. Asmindrup Gruppe', 27, 'Odsherred Distrikt'),
(2707, 1, 'Raklev Gruppe', 27, 'Odsherred Distrikt'),
(2708, 1, 'Svebølle Gruppe', 27, 'Odsherred Distrikt'),
(2709, 1, 'Tuse Bjerg Gruppe', 27, 'Odsherred Distrikt'),
(2710, 1, 'Nykøbing-Sjælland Gruppe', 27, 'Odsherred Distrikt'),
(2712, 1, 'Store Merløse Gruppe', 27, 'Odsherred Distrikt'),
(2713, 1, 'Vallekilde-Hørve Gruppe', 27, 'Odsherred Distrikt'),
(2902, 1, 'Bolund Gruppe', 29, 'Sct. Georg Distrikt'),
(2903, 1, 'Borup Gruppe', 29, 'Sct. Georg Distrikt'),
(2904, 1, 'Walburris', 29, 'Sct. Georg Distrikt'),
(2905, 1, 'Jyllinge Gruppe', 29, 'Sct. Georg Distrikt'),
(2907, 1, 'Karlslunde Gruppe', 29, 'Sct. Georg Distrikt'),
(2908, 1, 'Lejre Gruppe', 29, 'Sct. Georg Distrikt'),
(2910, 1, 'Roskilde Gruppe', 29, 'Sct. Georg Distrikt'),
(2911, 1, 'Svogerslev Gruppe', 29, 'Sct. Georg Distrikt'),
(2912, 1, 'Tune Gruppe', 29, 'Sct. Georg Distrikt'),
(2913, 1, 'Vindinge Gruppe', 29, 'Sct. Georg Distrikt'),
(2914, 1, 'Sct.Jørgen/2.Roskilde Gruppe', 29, 'Sct. Georg Distrikt'),
(2915, 1, 'Trekroner', 29, 'Sct. Georg Distrikt'),
(2916, 1, 'Skuldelev 2', 29, 'Sct. Georg Distrikt'),
(3002, 1, 'Hammer S. Gruppe', 33, 'Valdemar Distrikt'),
(3004, 1, 'Herlufmagle Gruppe', 31, 'Suså Distrikt'),
(3005, 1, 'Herlufsholm Gruppe', 31, 'Suså Distrikt'),
(3006, 1, 'Hyllinge Gruppe', 31, 'Suså Distrikt'),
(3007, 1, 'Kalvehave Gruppe', 33, 'Valdemar Distrikt'),
(3008, 1, 'Karrebæk Gruppe', 31, 'Suså Distrikt'),
(3009, 1, 'Kastrup-Ndr Vindinge Gruppe', 33, 'Valdemar Distrikt'),
(3010, 1, 'Lundby Gruppe', 33, 'Valdemar Distrikt'),
(3011, 1, 'Suså-Næstved Gruppe', 31, 'Suså Distrikt'),
(3012, 1, 'Præstø Gruppe', 33, 'Valdemar Distrikt'),
(3014, 1, 'Toksværd Gruppe', 33, 'Valdemar Distrikt'),
(3015, 1, 'Tybjerg Gruppe', 33, 'Valdemar Distrikt'),
(3016, 1, 'Fensmark Gruppe', 31, 'Suså Distrikt'),
(3017, 1, 'Tappernøje Gruppe', 33, 'Valdemar Distrikt'),
(3018, 1, 'Bogø Gruppe', 18, 'Lindorm Distrikt'),
(3102, 1, 'Fuglebjerg Gruppe', 31, 'Suså Distrikt'),
(3103, 1, 'Glumsø Gruppe', 31, 'Suså Distrikt'),
(3104, 1, '1. Skælskør Gruppe', 31, 'Suså Distrikt'),
(3106, 1, '1. Slagelse Gruppe', 31, 'Suså Distrikt'),
(3107, 1, '2. Slagelse Gruppe', 31, 'Suså Distrikt'),
(3108, 1, 'Stillinge Gruppe', 31, 'Suså Distrikt'),
(3109, 1, 'Sørbymagle Gruppe', 31, 'Suså Distrikt'),
(3110, 1, 'Tårnborg Gruppe', 31, 'Suså Distrikt'),
(3112, 1, 'Tornemark-Sandved Gruppe', 31, 'Suså Distrikt'),
(3203, 1, 'Bjergbakke Gruppe', 33, 'Valdemar Distrikt'),
(3205, 1, 'Ejby Gruppe', 33, 'Valdemar Distrikt'),
(3206, 1, 'Haslev Gruppe', 33, 'Valdemar Distrikt'),
(3207, 1, 'Peder Syv - Hellested Gruppe', 33, 'Valdemar Distrikt'),
(3208, 1, 'Højelse Gruppe', 33, 'Valdemar Distrikt'),
(3209, 1, 'Jersie-Solrød Gruppe', 33, 'Valdemar Distrikt'),
(3211, 1, 'Kongsted Gruppe', 33, 'Valdemar Distrikt'),
(3212, 1, 'Huitfeldt/Køge Gruppe', 33, 'Valdemar Distrikt'),
(3213, 1, 'Havdrup gruppe', 33, 'Valdemar Distrikt'),
(3215, 1, 'Nordrupøster Gruppe', 33, 'Valdemar Distrikt'),
(3216, 1, 'Ringsted Gruppe', 33, 'Valdemar Distrikt'),
(3217, 1, 'Stevns-Nord Gruppe', 33, 'Valdemar Distrikt'),
(3218, 1, 'Sædder Gruppe', 33, 'Valdemar Distrikt'),
(3219, 1, 'Sølvbæk Gruppe', 33, 'Valdemar Distrikt'),
(3220, 1, 'Vallø Gruppe', 33, 'Valdemar Distrikt'),
(3222, 1, 'Ølsemagle Gruppe', 33, 'Valdemar Distrikt'),
(3223, 1, 'Fakse Gruppe', 33, 'Valdemar Distrikt'),
(3602, 1, 'Dalum Gruppe', 8, 'Fionia Distrikt'),
(3603, 1, 'Højby Gruppe', 5, 'Danehof Distrikt'),
(3605, 1, 'Langeskov Gruppe', 5, 'Danehof Distrikt'),
(3606, 1, 'Nr. Lyndelse Gruppe', 5, 'Danehof Distrikt'),
(3607, 1, 'Sct. Knuds gruppe', 8, 'Fionia Distrikt'),
(3610, 1, '6. Odense Gruppe', 5, 'Danehof Distrikt'),
(3612, 1, 'Tornbjerg Gruppe', 8, 'Fionia Distrikt'),
(3613, 1, 'Bellinge Gruppe', 8, 'Fionia Distrikt'),
(3614, 1, 'Gråbrødre/Odense Gruppe', 8, 'Fionia Distrikt'),
(3615, 1, 'Kertinge Gruppe', 5, 'Danehof Distrikt'),
(3616, 1, 'Årslev Gruppe', 5, 'Danehof Distrikt'),
(3702, 1, 'Assens Gruppe', 8, 'Fionia Distrikt'),
(3703, 1, 'Dreslette Gruppe', 8, 'Fionia Distrikt'),
(3704, 1, 'Hårby Gruppe', 8, 'Fionia Distrikt'),
(3705, 1, 'Middelfart Gruppe', 8, 'Fionia Distrikt'),
(3706, 1, 'Nr. Højrup Gruppe', 8, 'Fionia Distrikt'),
(3707, 1, 'Nr. Åby Gruppe', 8, 'Fionia Distrikt'),
(3708, 1, 'Otterup Gruppe', 8, 'Fionia Distrikt'),
(3709, 1, 'Søndersø Gruppe', 8, 'Fionia Distrikt'),
(3710, 1, 'Tommerup Gruppe', 8, 'Fionia Distrikt'),
(3711, 1, 'Verninge Gruppe', 8, 'Fionia Distrikt'),
(3712, 1, 'Vissenbjerg Gruppe', 8, 'Fionia Distrikt'),
(3713, 1, 'Bogense Gruppe', 8, 'Fionia Distrikt'),
(3714, 1, 'Husby-Tanderup Gruppe', 8, 'Fionia Distrikt'),
(3802, 1, 'Brahetrolleborg Gruppe', 5, 'Danehof Distrikt'),
(3803, 1, 'Broby Gruppe', 5, 'Danehof Distrikt'),
(3804, 1, 'Gislev Gruppe', 5, 'Danehof Distrikt'),
(3805, 1, 'Herrested Gruppe', 5, 'Danehof Distrikt'),
(3807, 1, 'Marstal Gruppe', 5, 'Danehof Distrikt'),
(3808, 1, 'Nyborg Gruppe', 5, 'Danehof Distrikt'),
(3809, 1, 'Ringe Gruppe', 5, 'Danehof Distrikt'),
(3810, 1, 'Rise Gruppe', 5, 'Danehof Distrikt'),
(3811, 1, 'Rudkøbing Gruppe', 5, 'Danehof Distrikt'),
(3812, 1, 'Stenstrup Gruppe', 5, 'Danehof Distrikt'),
(3813, 1, 'Svendborg Gruppe', 5, 'Danehof Distrikt'),
(3816, 1, 'Åkilde Gruppe', 5, 'Danehof Distrikt'),
(3817, 1, 'Ådal-Broby Gruppe', 5, 'Danehof Distrikt'),
(3819, 1, 'Kongshøj Gruppe', 5, 'Danehof Distrikt'),
(4102, 1, 'Fynshav Gruppe', 26, 'Nydam Distrikt'),
(4103, 1, 'Hjortspring Gruppe', 26, 'Nydam Distrikt'),
(4104, 1, 'Høruphav Gruppe', 26, 'Nydam Distrikt'),
(4105, 1, 'Kegnæs Gruppe', 26, 'Nydam Distrikt'),
(4106, 1, 'Nordborg Gruppe', 26, 'Nydam Distrikt'),
(4107, 1, 'Sønderborg Gruppe', 26, 'Nydam Distrikt'),
(4109, 1, 'Dybbøl Gruppe', 26, 'Nydam Distrikt'),
(4110, 1, 'Lysabild Gruppe', 26, 'Nydam Distrikt'),
(4202, 1, 'Fole Gruppe', 17, 'Kongeå Distrikt'),
(4204, 1, 'Jels Gruppe', 17, 'Kongeå Distrikt'),
(4205, 1, 'Lintrup Gruppe', 17, 'Kongeå Distrikt'),
(4207, 1, 'Skodborg Gruppe', 17, 'Kongeå Distrikt'),
(4209, 1, 'Tiset/Arnum Gruppe', 17, 'Kongeå Distrikt'),
(4302, 1, 'Abild Gruppe', 10, 'Guldhorn Distrikt'),
(4303, 1, 'Ballum Gruppe', 10, 'Guldhorn Distrikt'),
(4304, 1, 'Bedsted Lø Gruppe', 10, 'Guldhorn Distrikt'),
(4305, 1, 'Brøns Gruppe', 10, 'Guldhorn Distrikt'),
(4306, 1, 'Døstrup Gruppe', 10, 'Guldhorn Distrikt'),
(4307, 1, 'Løgumkloster Gruppe', 10, 'Guldhorn Distrikt'),
(4308, 1, 'Nr. Løgum Gruppe', 10, 'Guldhorn Distrikt'),
(4309, 1, 'Rømø Gruppe', 10, 'Guldhorn Distrikt'),
(4310, 1, 'Visby Gruppe', 10, 'Guldhorn Distrikt'),
(4311, 1, 'Øster Højst Gruppe', 10, 'Guldhorn Distrikt'),
(4312, 1, 'Tønder Gruppe', 10, 'Guldhorn Distrikt'),
(4402, 1, 'Ensted Gruppe', 15, 'Hærulf Distrikt'),
(4403, 1, 'Felsted Gruppe', 26, 'Nydam Distrikt'),
(4405, 1, 'Hjordkær Gruppe', 15, 'Hærulf Distrikt'),
(4407, 1, 'Løjt Kirkeby Gruppe', 15, 'Hærulf Distrikt'),
(4408, 1, 'Rødekro Gruppe', 15, 'Hærulf Distrikt'),
(4409, 1, 'Aabenraa Gruppe', 15, 'Hærulf Distrikt'),
(4502, 1, 'Slogs Herred Gruppe', 10, 'Guldhorn Distrikt'),
(4504, 1, 'Rinkenæs Gruppe', 26, 'Nydam Distrikt'),
(4505, 1, 'Sundeved Gruppe', 26, 'Nydam Distrikt'),
(4506, 1, 'Urnehoved Gruppe', 26, 'Nydam Distrikt'),
(4507, 1, 'Ravsted Gruppe', 10, 'Guldhorn Distrikt'),
(4508, 1, 'Kruså-Kollund Gruppe', 26, 'Nydam Distrikt'),
(4602, 1, 'Haderslev Gruppe', 15, 'Hærulf Distrikt'),
(4603, 1, 'Immervad Gruppe', 15, 'Hærulf Distrikt'),
(4604, 1, 'Sommersted Gruppe', 15, 'Hærulf Distrikt'),
(4605, 1, 'Falke-Starup Gruppe', 15, 'Hærulf Distrikt'),
(4606, 1, 'Vojens Gruppe', 15, 'Hærulf Distrikt'),
(4607, 1, 'Ådals-Hoptrup Gruppe', 15, 'Hærulf Distrikt'),
(4609, 1, 'Gabøl-Nustrup Gruppe', 15, 'Hærulf Distrikt'),
(4610, 1, 'Jegerup Gruppe', 15, 'Hærulf Distrikt'),
(4902, 1, 'Andst Gruppe', 16, 'Hærvejens Distrikt'),
(4903, 1, 'Bække Gruppe', 16, 'Hærvejens Distrikt'),
(4904, 1, 'Egtved Gruppe', 16, 'Hærvejens Distrikt'),
(4906, 1, 'Jordrup Gruppe', 16, 'Hærvejens Distrikt'),
(4907, 1, 'Randbøl Gruppe', 16, 'Hærvejens Distrikt'),
(4908, 1, 'Vejen Gruppe', 16, 'Hærvejens Distrikt'),
(4909, 1, 'Ø.Starup-V.Nebel Gruppe', 16, 'Hærvejens Distrikt'),
(4910, 1, 'Ødsted Gruppe', 16, 'Hærvejens Distrikt'),
(4912, 1, 'Læborg Gruppe', 16, 'Hærvejens Distrikt'),
(5002, 1, 'Alminde-Viuf Gruppe', 30, 'Skamling Distrikt'),
(5003, 1, 'Bramdrup Gruppe', 30, 'Skamling Distrikt'),
(5004, 1, 'Houens Odde Gruppe', 30, 'Skamling Distrikt'),
(5006, 1, '5. Kolding Gruppe', 30, 'Skamling Distrikt'),
(5008, 1, 'Seest Gruppe', 30, 'Skamling Distrikt'),
(5009, 1, 'Vonsild Gruppe', 30, 'Skamling Distrikt'),
(5102, 1, 'Christiansfeld Gruppe', 30, 'Skamling Distrikt'),
(5103, 1, 'Hjarup Gruppe', 30, 'Skamling Distrikt'),
(5104, 1, 'Sdr. Bjert Gruppe', 30, 'Skamling Distrikt'),
(5105, 1, 'Stepping Gruppe', 30, 'Skamling Distrikt'),
(5106, 1, 'Vamdrup Gruppe', 30, 'Skamling Distrikt'),
(5107, 1, 'Ødis Gruppe', 30, 'Skamling Distrikt'),
(5108, 1, 'Sdr. Stenderup Gruppe', 30, 'Skamling Distrikt'),
(5110, 1, 'Fjelstrup Gruppe', 15, 'Hærulf Distrikt'),
(5302, 1, 'Mariesminde Gruppe', 30, 'Skamling Distrikt'),
(5404, 1, '4. Esbjerg Gruppe', 14, 'Ho Bugt Distrikt'),
(5405, 1, 'Fanø Gruppe', 14, 'Ho Bugt Distrikt'),
(5406, 1, 'Bryndum Gruppe', 14, 'Ho Bugt Distrikt'),
(5407, 1, 'Ådalsgruppen Gruppe', 14, 'Ho Bugt Distrikt'),
(5408, 1, 'Kvaglund Gruppe', 14, 'Ho Bugt Distrikt'),
(5410, 1, 'Fourfeld Gruppe', 14, 'Ho Bugt Distrikt'),
(5412, 1, 'Guldager Gruppe', 14, 'Ho Bugt Distrikt'),
(5502, 1, 'Bramming Gruppe', 17, 'Kongeå Distrikt'),
(5503, 1, 'Brørup Gruppe', 17, 'Kongeå Distrikt'),
(5504, 1, 'Gørding Gruppe', 17, 'Kongeå Distrikt'),
(5505, 1, 'Hejnsvig Gruppe', 16, 'Hærvejens Distrikt'),
(5506, 1, 'Holsted-Glejbjerg Gruppe', 17, 'Kongeå Distrikt'),
(5507, 1, 'Lindknud Gruppe', 17, 'Kongeå Distrikt'),
(5508, 1, 'Kongeaadal Gruppe', 17, 'Kongeå Distrikt'),
(5509, 1, 'Ribe-Hviding Gruppe', 17, 'Kongeå Distrikt'),
(5510, 1, 'Vorbasse Gruppe', 16, 'Hærvejens Distrikt'),
(5511, 1, 'Vejrup Gruppe', 17, 'Kongeå Distrikt'),
(5512, 1, 'Føvling Gruppe', 17, 'Kongeå Distrikt'),
(5602, 1, 'Alslev Gruppe', 14, 'Ho Bugt Distrikt'),
(5603, 1, 'Grimstrup-Årre Gruppe', 17, 'Kongeå Distrikt'),
(5604, 1, 'Horne-Tistrup Gruppe', 20, 'Lundenæs Len Distrikt'),
(5605, 1, 'Janderup Gruppe', 14, 'Ho Bugt Distrikt'),
(5606, 1, 'Oksbøl Gruppe', 14, 'Ho Bugt Distrikt'),
(5607, 1, 'Outrup Gruppe', 14, 'Ho Bugt Distrikt'),
(5609, 1, 'Skads Gruppe', 14, 'Ho Bugt Distrikt'),
(5610, 1, 'Skovlund Gruppe', 20, 'Lundenæs Len Distrikt'),
(5611, 1, 'Vester Nebel Gruppe', 14, 'Ho Bugt Distrikt'),
(5612, 1, 'Gårde Gruppe', 20, 'Lundenæs Len Distrikt'),
(5902, 1, 'Brejning Gruppe', 24, 'Munkebjerg Distrikt'),
(5903, 1, 'Børkop Gruppe', 24, 'Munkebjerg Distrikt'),
(5904, 1, 'Gårslev Gruppe', 24, 'Munkebjerg Distrikt'),
(5905, 1, 'Smidstrup Gruppe', 24, 'Munkebjerg Distrikt'),
(6002, 1, 'Bülow Gruppe', 24, 'Munkebjerg Distrikt'),
(6003, 1, 'De Meza Gruppe', 24, 'Munkebjerg Distrikt'),
(6004, 1, 'Peder Griib Gruppe, Erritsø', 24, 'Munkebjerg Distrikt'),
(6005, 1, 'Olaf Rye Gruppe', 24, 'Munkebjerg Distrikt'),
(6006, 1, 'Skærbæk Gruppe', 24, 'Munkebjerg Distrikt'),
(6008, 1, 'Taulov Gruppe', 24, 'Munkebjerg Distrikt'),
(6102, 1, 'Bredballe Gruppe', 24, 'Munkebjerg Distrikt'),
(6103, 1, 'Grejs-Lindved Gruppe', 19, 'Lovring Distrikt'),
(6104, 1, 'Højen Gruppe', 24, 'Munkebjerg Distrikt'),
(6105, 1, 'Vejle Gruppe', 24, 'Munkebjerg Distrikt'),
(6107, 1, 'Runefolket', 19, 'Lovring Distrikt'),
(6109, 1, 'Engum Gruppe', 24, 'Munkebjerg Distrikt'),
(6202, 1, 'Billund Gruppe', 16, 'Hærvejens Distrikt'),
(6203, 1, 'Ejstrupholm Gruppe', 21, 'Lyngens Distrikt'),
(6205, 1, 'Langelund-Karlskov Gruppe', 21, 'Lyngens Distrikt'),
(6206, 1, 'Thyregod-Vester Gruppe', 21, 'Lyngens Distrikt'),
(6207, 1, 'Givskud Gruppe', 21, 'Lyngens Distrikt'),
(6208, 1, 'Hærvejs Gruppe', 21, 'Lyngens Distrikt'),
(6303, 1, 'Gjern Gruppe', 9, 'Gudenå Distrikt'),
(6305, 1, 'Kjellerup Gruppe', 23, 'Midtjyske Distrikt'),
(6306, 1, 'Levring-Højbjerg Gruppe', 23, 'Midtjyske Distrikt'),
(6308, 1, 'Låsby Gruppe', 9, 'Gudenå Distrikt'),
(6309, 1, 'Thorsø Gruppe', 9, 'Gudenå Distrikt'),
(6310, 1, 'Silkeborg Gruppe', 9, 'Gudenå Distrikt'),
(6311, 1, 'Them Gruppe', 9, 'Gudenå Distrikt'),
(6312, 1, 'Ulstrup Gruppe', 23, 'Midtjyske Distrikt'),
(6314, 1, 'Vinderslev Gruppe', 23, 'Midtjyske Distrikt'),
(6316, 1, 'Fårvang Gruppe', 9, 'Gudenå Distrikt'),
(6319, 1, 'Nørreå Gruppe, Viborg', 23, 'Midtjyske Distrikt'),
(6322, 1, 'Gjessø Gruppe', 9, 'Gudenå Distrikt'),
(6324, 1, 'Bjerringbro Gruppe', 23, 'Midtjyske Distrikt'),
(6402, 1, 'Flemming Gruppe', 19, 'Lovring Distrikt'),
(6403, 1, 'Hedensted Gruppe', 19, 'Lovring Distrikt'),
(6404, 1, 'Løsning Gruppe', 19, 'Lovring Distrikt'),
(6405, 1, 'Rårup Gruppe', 19, 'Lovring Distrikt'),
(6406, 1, 'Stouby', 19, 'Lovring Distrikt'),
(6407, 1, 'Tørring Gruppe', 19, 'Lovring Distrikt'),
(6408, 1, 'Voerladegård Gruppe', 19, 'Lovring Distrikt'),
(6409, 1, 'Ølsted Gruppe', 19, 'Lovring Distrikt'),
(6410, 1, 'Øster Snede Gruppe', 19, 'Lovring Distrikt'),
(6411, 1, 'Glud-Snaptun Gruppe', 19, 'Lovring Distrikt'),
(6412, 1, 'Brædstrup Gruppe', 19, 'Lovring Distrikt'),
(6502, 1, 'Egebjerg Gruppe', 19, 'Lovring Distrikt'),
(6503, 1, 'Hatting Gruppe', 19, 'Lovring Distrikt'),
(6504, 1, 'Horsens Gruppe', 19, 'Lovring Distrikt'),
(6505, 1, 'Søvind Gruppe', 19, 'Lovring Distrikt'),
(6506, 1, 'Stensballe Gruppe', 19, 'Lovring Distrikt'),
(6507, 1, 'Bankager Gruppe', 19, 'Lovring Distrikt'),
(6509, 1, 'Lund Gruppe', 19, 'Lovring Distrikt'),
(6802, 1, 'Astrup Gruppe', 20, 'Lundenæs Len Distrikt'),
(6803, 1, 'Bork Gruppe', 20, 'Lundenæs Len Distrikt'),
(6804, 1, 'Hoven Gruppe', 20, 'Lundenæs Len Distrikt'),
(6805, 1, 'Lem Gruppe', 20, 'Lundenæs Len Distrikt'),
(6806, 1, 'Ringkøbing Gruppe', 20, 'Lundenæs Len Distrikt'),
(6807, 1, 'Rækker Mølle Gruppe', 20, 'Lundenæs Len Distrikt'),
(6808, 1, 'Sdr. Vium Gruppe', 20, 'Lundenæs Len Distrikt'),
(6809, 1, 'Tarm Gruppe', 20, 'Lundenæs Len Distrikt'),
(6810, 1, 'Lønborg-Vostrup Gruppe', 20, 'Lundenæs Len Distrikt'),
(6811, 1, 'Stauning-Dejbjerg Gruppe', 20, 'Lundenæs Len Distrikt'),
(6812, 1, 'Vorgod-Barde Gruppe', 20, 'Lundenæs Len Distrikt'),
(6902, 1, 'Borbjerg Gruppe', 12, 'Hardsyssel Distrikt'),
(6904, 1, 'Hodsager Gruppe', 12, 'Hardsyssel Distrikt'),
(6905, 1, '1. Holstebro Gruppe', 12, 'Hardsyssel Distrikt'),
(6907, 1, '3. Holstebro Ellebæk Gruppe', 12, 'Hardsyssel Distrikt'),
(6908, 1, 'Idom-Råsted Gruppe', 12, 'Hardsyssel Distrikt'),
(6909, 1, 'Mejrup Gruppe', 12, 'Hardsyssel Distrikt'),
(6910, 1, 'Ryde-Handbjerg Gruppe', 12, 'Hardsyssel Distrikt'),
(6911, 1, 'Sevel Gruppe', 12, 'Hardsyssel Distrikt'),
(6912, 1, 'Ulfborg Gruppe', 12, 'Hardsyssel Distrikt'),
(6913, 1, 'Vinderup Gruppe', 12, 'Hardsyssel Distrikt'),
(6914, 1, 'Vinding Gruppe', 12, 'Hardsyssel Distrikt'),
(6915, 1, 'Hjelm Hede Gruppe', 12, 'Hardsyssel Distrikt'),
(6916, 1, 'Vemb Gruppe', 12, 'Hardsyssel Distrikt'),
(7004, 1, 'Sct. Johannes Gruppe', 21, 'Lyngens Distrikt'),
(7005, 1, 'Sdr. Felding Gruppe', 21, 'Lyngens Distrikt'),
(7006, 1, 'Snejbjerg Gruppe', 21, 'Lyngens Distrikt'),
(7007, 1, 'Tjørring Gruppe', 21, 'Lyngens Distrikt'),
(7009, 1, 'Vildbjerg Gruppe', 21, 'Lyngens Distrikt'),
(7010, 1, 'Ørre-Sinding Gruppe', 21, 'Lyngens Distrikt'),
(7011, 1, 'Skibbild-Nøvling Gruppe', 21, 'Lyngens Distrikt'),
(7012, 1, 'Fasterholt Gruppe', 21, 'Lyngens Distrikt'),
(7013, 1, 'Ikast Gruppe', 21, 'Lyngens Distrikt'),
(7015, 1, 'Engesvang Gruppe', 21, 'Lyngens Distrikt'),
(7302, 1, 'Allingåbro Gruppe', 6, 'Djursland Distrikt'),
(7303, 1, 'Auning Gruppe', 6, 'Djursland Distrikt'),
(7305, 1, 'Fornæs Gruppe', 6, 'Djursland Distrikt'),
(7306, 1, 'Rønde Gruppe', 6, 'Djursland Distrikt'),
(7307, 1, 'Sivested Gruppe', 6, 'Djursland Distrikt'),
(7308, 1, 'Tirstrup Gruppe', 6, 'Djursland Distrikt'),
(7309, 1, 'Vivild Gruppe', 6, 'Djursland Distrikt'),
(7310, 1, 'Ørum Djurs Gruppe', 6, 'Djursland Distrikt'),
(7315, 1, 'Thorsager Gruppe', 6, 'Djursland Distrikt'),
(7316, 1, 'Vejlby-Grenaa Gruppe', 6, 'Djursland Distrikt'),
(7317, 1, 'Ådalen-Djurs Gruppe', 6, 'Djursland Distrikt'),
(7402, 1, 'Lystrup-Elsted Gruppe', 22, 'Marselis Distrikt'),
(7403, 1, 'Kaløvig Gruppe', 22, 'Marselis Distrikt'),
(7404, 1, 'Spørring-Trige Gruppe', 22, 'Marselis Distrikt'),
(7405, 1, 'Todbjerg-Mejlby Gruppe', 22, 'Marselis Distrikt'),
(7410, 1, '2. Århus Gruppe', 22, 'Marselis Distrikt'),
(7413, 1, 'Skelager Gruppe', 22, 'Marselis Distrikt'),
(7502, 1, 'Brabrand Gruppe', 22, 'Marselis Distrikt'),
(7504, 1, 'Hadsten Gruppe', 9, 'Gudenå Distrikt'),
(7505, 1, 'Hammel Gruppe', 9, 'Gudenå Distrikt'),
(7506, 1, 'Harlev-Framlev Gruppe', 9, 'Gudenå Distrikt'),
(7508, 1, 'Herskind Gruppe', 9, 'Gudenå Distrikt'),
(7510, 1, 'Sabro Gruppe', 9, 'Gudenå Distrikt'),
(7511, 1, 'Skjoldhøj Gruppe', 22, 'Marselis Distrikt'),
(7512, 1, 'Skovby Gruppe', 9, 'Gudenå Distrikt'),
(7513, 1, 'Søften Gruppe', 9, 'Gudenå Distrikt'),
(7514, 1, 'Åbyhøj Gruppe', 22, 'Marselis Distrikt'),
(7515, 1, 'Stjær Gruppe', 9, 'Gudenå Distrikt'),
(7702, 1, 'Dronningborg Gruppe', 25, 'Nordøstjyske Distrikt'),
(7703, 1, 'Gjerlev Gruppe', 25, 'Nordøstjyske Distrikt'),
(7704, 1, 'Havndal Gruppe', 25, 'Nordøstjyske Distrikt'),
(7706, 1, 'Hungstrup Gruppe', 25, 'Nordøstjyske Distrikt'),
(7707, 1, 'Sct. Clemens Gruppe', 25, 'Nordøstjyske Distrikt'),
(7708, 1, 'Spentrup Gruppe', 25, 'Nordøstjyske Distrikt'),
(7709, 1, 'Vorup-Kristrup Gruppe', 25, 'Nordøstjyske Distrikt'),
(7710, 1, 'Råby Gruppe', 25, 'Nordøstjyske Distrikt'),
(7903, 1, '1. Viby J. Gruppe', 22, 'Marselis Distrikt'),
(7904, 1, 'Ejer Baunehøj Gruppe', 19, 'Lovring Distrikt'),
(7905, 1, 'Fredens Sogn Gruppe', 22, 'Marselis Distrikt'),
(7906, 1, 'Hundslund Gruppe', 19, 'Lovring Distrikt'),
(7907, 1, 'Mårslet Gruppe', 22, 'Marselis Distrikt'),
(7909, 1, 'Stautrup Gruppe', 22, 'Marselis Distrikt'),
(7910, 1, 'Stilling Gruppe', 9, 'Gudenå Distrikt'),
(7911, 1, 'Veng Gruppe', 9, 'Gudenå Distrikt'),
(8103, 1, 'Fabjerg Gruppe', 12, 'Hardsyssel Distrikt'),
(8104, 1, 'Tangsø Gruppe', 12, 'Hardsyssel Distrikt'),
(8105, 1, 'Gudum Gruppe', 12, 'Hardsyssel Distrikt'),
(8106, 1, 'Langhøj Gruppe', 12, 'Hardsyssel Distrikt'),
(8107, 1, 'Lemvig Gruppe', 12, 'Hardsyssel Distrikt'),
(8108, 1, 'Lomborg-Rom Gruppe', 12, 'Hardsyssel Distrikt'),
(8109, 1, 'Nr. Nissum Gruppe', 12, 'Hardsyssel Distrikt'),
(8110, 1, 'Resen-Humlum Gruppe', 12, 'Hardsyssel Distrikt'),
(8112, 1, 'Struer Gruppe', 12, 'Hardsyssel Distrikt'),
(8113, 1, 'Dybe-Ramme Gruppe', 12, 'Hardsyssel Distrikt'),
(8202, 1, 'Bedsted Gruppe', 32, 'Thy Distrikt'),
(8203, 1, 'Frøstrup Gruppe', 32, 'Thy Distrikt'),
(8204, 1, 'Hanstholm-Ræhr Gruppe', 32, 'Thy Distrikt'),
(8206, 1, 'Hunstrup-Østerild Gruppe', 32, 'Thy Distrikt'),
(8207, 1, 'Hørdum Gruppe', 32, 'Thy Distrikt'),
(8209, 1, 'Nors Gruppe', 32, 'Thy Distrikt'),
(8210, 1, 'Skjoldborg Gruppe', 32, 'Thy Distrikt'),
(8211, 1, 'Stagstrup Gruppe', 32, 'Thy Distrikt'),
(8212, 1, 'Thisted Gruppe', 32, 'Thy Distrikt'),
(8213, 1, 'Vandet Gruppe', 32, 'Thy Distrikt'),
(8214, 1, 'Vestervig Gruppe', 32, 'Thy Distrikt'),
(8215, 1, 'Sjørring Gruppe', 32, 'Thy Distrikt'),
(8216, 1, 'Boddum/Ydby Gruppe', 32, 'Thy Distrikt'),
(8302, 1, 'Bruddal Gruppe', 35, 'Vestlimfjord Distrikt'),
(8303, 1, 'Durup Gruppe', 35, 'Vestlimfjord Distrikt'),
(8304, 1, 'Frøslev-Mollerup Gruppe', 35, 'Vestlimfjord Distrikt'),
(8305, 1, 'Fur Gruppe', 35, 'Vestlimfjord Distrikt'),
(8307, 1, 'Lem-Brodal Gruppe', 35, 'Vestlimfjord Distrikt'),
(8308, 1, 'Nykøbing Mors Gruppe', 35, 'Vestlimfjord Distrikt'),
(8309, 1, 'Roslev Gruppe', 35, 'Vestlimfjord Distrikt'),
(8310, 1, 'Skivehus Gruppe', 35, 'Vestlimfjord Distrikt'),
(8311, 1, 'Spøttrup Gruppe', 35, 'Vestlimfjord Distrikt'),
(8312, 1, 'Sydvest Mors Gruppe', 35, 'Vestlimfjord Distrikt'),
(8314, 1, 'Vejerslev Gruppe', 35, 'Vestlimfjord Distrikt'),
(8316, 1, 'Flyndersø Gruppe', 35, 'Vestlimfjord Distrikt'),
(8317, 1, 'Balling Gruppe', 35, 'Vestlimfjord Distrikt'),
(8320, 1, 'Jenle Gruppe', 35, 'Vestlimfjord Distrikt'),
(8324, 1, 'Hem Gruppe', 35, 'Vestlimfjord Distrikt'),
(8602, 1, 'Bonderup Gruppe', 2, 'Aggersborg Distrikt'),
(8603, 1, 'Brovst Gruppe', 2, 'Aggersborg Distrikt'),
(8604, 1, 'Fjerritslev Gruppe', 2, 'Aggersborg Distrikt'),
(8605, 1, 'Kettrup Gruppe', 2, 'Aggersborg Distrikt'),
(8606, 1, 'Skovsgård Gruppe', 2, 'Aggersborg Distrikt'),
(8608, 1, 'Tranum Gruppe', 2, 'Aggersborg Distrikt'),
(8609, 1, 'Øland Gruppe', 2, 'Aggersborg Distrikt'),
(8702, 1, 'Klejtrup Gruppe', 23, 'Midtjyske Distrikt'),
(8704, 1, 'Møldrup Gruppe', 23, 'Midtjyske Distrikt'),
(8706, 1, 'Skals Gruppe', 23, 'Midtjyske Distrikt'),
(8708, 1, 'Ulbjerg Gruppe', 23, 'Midtjyske Distrikt'),
(8709, 1, 'Langsø Gruppe', 23, 'Midtjyske Distrikt'),
(8802, 1, 'Farsø Gruppe', 2, 'Aggersborg Distrikt'),
(8803, 1, 'Hvalpsund Gruppe', 2, 'Aggersborg Distrikt'),
(8804, 1, 'Hvam Gruppe', 2, 'Aggersborg Distrikt'),
(8805, 1, 'Mejlby Gruppe', 2, 'Aggersborg Distrikt'),
(8806, 1, 'Fjord-Strandby Gruppe', 2, 'Aggersborg Distrikt'),
(8807, 1, 'Ullits Gruppe', 2, 'Aggersborg Distrikt'),
(8808, 1, 'Vegger Gruppe', 2, 'Aggersborg Distrikt'),
(8809, 1, 'Vesterbølle Gruppe', 2, 'Aggersborg Distrikt'),
(8810, 1, 'Vestrup Gruppe', 2, 'Aggersborg Distrikt'),
(8811, 1, 'Aalestrup Gruppe', 2, 'Aggersborg Distrikt'),
(8902, 1, 'Bindslev Gruppe', 34, 'Vest-Vendsyssel Distrikt'),
(8903, 1, 'Bistrup Gruppe', 34, 'Vest-Vendsyssel Distrikt'),
(8904, 1, 'Bjergby-Mygdal Gruppe', 34, 'Vest-Vendsyssel Distrikt'),
(8905, 1, 'Hirtshals Gruppe', 34, 'Vest-Vendsyssel Distrikt'),
(8906, 1, 'Sct.Catharinae,Hjørring Gruppe', 34, 'Vest-Vendsyssel Distrikt'),
(8907, 1, 'Horne Gruppe', 34, 'Vest-Vendsyssel Distrikt'),
(8908, 1, 'Højene Gruppe', 34, 'Vest-Vendsyssel Distrikt'),
(8909, 1, 'Løkken Gruppe', 34, 'Vest-Vendsyssel Distrikt'),
(8910, 1, 'Rakkeby Gruppe', 34, 'Vest-Vendsyssel Distrikt'),
(8911, 1, 'Skallerup-Vennebjerg Gruppe', 34, 'Vest-Vendsyssel Distrikt'),
(8912, 1, 'Tornby-Vidstrup Gruppe', 34, 'Vest-Vendsyssel Distrikt'),
(8913, 1, 'Vejby Gruppe', 34, 'Vest-Vendsyssel Distrikt'),
(8915, 1, 'Vrå Gruppe', 34, 'Vest-Vendsyssel Distrikt'),
(8916, 1, 'Poulstrup Gruppe', 34, 'Vest-Vendsyssel Distrikt'),
(8917, 1, 'Saltum Gruppe', 34, 'Vest-Vendsyssel Distrikt'),
(8918, 1, 'Kaas-Moseby Gruppe', 34, 'Vest-Vendsyssel Distrikt'),
(9002, 1, 'Bælum-Solbjerg Gruppe', 25, 'Nordøstjyske Distrikt'),
(9003, 1, 'Gerding-Blenstrup Gruppe', 25, 'Nordøstjyske Distrikt'),
(9004, 1, 'Kongerslev Gruppe', 25, 'Nordøstjyske Distrikt'),
(9005, 1, 'Mou Gruppe', 25, 'Nordøstjyske Distrikt'),
(9006, 1, 'Rosendal Gruppe', 25, 'Nordøstjyske Distrikt'),
(9007, 1, 'Valsgård Gruppe', 25, 'Nordøstjyske Distrikt'),
(9103, 1, 'Dybvad Gruppe', 36, 'Østvendsyssel Distrikt'),
(9105, 1, 'Hallund Gruppe', 36, 'Østvendsyssel Distrikt'),
(9106, 1, 'Hørby Gruppe', 36, 'Østvendsyssel Distrikt'),
(9107, 1, 'Jerslev Gruppe', 36, 'Østvendsyssel Distrikt'),
(9113, 1, 'Ousen Gruppe', 36, 'Østvendsyssel Distrikt'),
(9115, 1, 'Serritslev Gruppe', 36, 'Østvendsyssel Distrikt'),
(9118, 1, 'Østervrå Gruppe', 36, 'Østvendsyssel Distrikt'),
(9119, 1, 'Asaa Gruppe', 36, 'Østvendsyssel Distrikt'),
(9120, 1, 'Thorshøj Gruppe', 36, 'Østvendsyssel Distrikt'),
(9121, 1, 'Ulsted Gruppe', 36, 'Østvendsyssel Distrikt'),
(9202, 1, 'Cimbrerne Gruppe', 1, 'Aalborg Distrikt'),
(9205, 1, 'Gjøl Gruppe', 1, 'Aalborg Distrikt'),
(9206, 1, 'Langholt Gruppe', 1, 'Aalborg Distrikt'),
(9207, 1, 'Knuden, Aalborg Gruppe', 1, 'Aalborg Distrikt'),
(9208, 1, 'Lindholm Gruppe', 1, 'Aalborg Distrikt'),
(9209, 1, 'Nørresundby Gruppe', 1, 'Aalborg Distrikt'),
(9210, 1, 'Sct. Jørgen Gruppe', 1, 'Aalborg Distrikt'),
(9211, 1, 'Sulsted-Tylstrup Gruppe', 1, 'Aalborg Distrikt'),
(9212, 1, 'Åbybro Gruppe', 1, 'Aalborg Distrikt'),
(9213, 1, 'Svenstrup Gruppe', 1, 'Aalborg Distrikt'),
(9216, 1, 'Øster Uttrup Gruppe', 1, 'Aalborg Distrikt'),
(9217, 1, 'Flejgdal Gruppe', 1, 'Aalborg Distrikt'),
(9302, 1, 'Frederikshavn Gruppe', 36, 'Østvendsyssel Distrikt'),
(9303, 1, 'Gærum Gruppe', 36, 'Østvendsyssel Distrikt'),
(9304, 1, 'Hørmested Gruppe', 36, 'Østvendsyssel Distrikt'),
(9305, 1, 'Kvissel Gruppe', 36, 'Østvendsyssel Distrikt'),
(9306, 1, 'Lendum Gruppe', 36, 'Østvendsyssel Distrikt'),
(9308, 1, 'Lørslev Gruppe', 34, 'Vest-Vendsyssel Distrikt'),
(9309, 1, 'Mosbjerg Gruppe', 36, 'Østvendsyssel Distrikt'),
(9310, 1, 'Ravnshøj Gruppe', 36, 'Østvendsyssel Distrikt'),
(9311, 1, 'Skagen Gruppe', 36, 'Østvendsyssel Distrikt');

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
  `place` varchar(64) default NULL,
  `notes` text,
  `status` char(1) NOT NULL default 'A' COMMENT 'Waiting/Approved/Deleted',
  `priority` tinyint(4) NOT NULL default '3',
  PRIMARY KEY  (`id`),
  KEY `owner_id` (`owner_id`),
  KEY `site_id` (`site_id`),
  KEY `area_id` (`area_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

-- 
-- Data dump for tabellen `job`
-- 

INSERT INTO `job` (`id`, `site_id`, `area_id`, `owner_id`, `name`, `description`, `place`, `notes`, `status`, `priority`) VALUES 
(-1, 1, NULL, NULL, 'Blokering', NULL, NULL, NULL, 'A', 3),
(17, 1, 2, 'testarbejdsgiver', 'Test megaaktivitet', 'Meget lang beskrivelse... Meget lang beskrivelse... Meget lang beskrivelse... Meget lang beskrivelse... Meget lang beskrivelse... Meget lang beskrivelse... Meget lang beskrivelse... Meget lang beskrivelse... Meget lang beskrivelse... Meget lang beskrivelse... Meget lang beskrivelse... Meget lang beskrivelse... Meget lang beskrivelse... Meget lang beskrivelse... Meget lang beskrivelse... Meget lang beskrivelse... Meget lang beskrivelse... Meget lang beskrivelse... Meget lang beskrivelse... Meget lang beskrivelse... Meget lang beskrivelse... Meget lang beskrivelse... Meget lang beskrivelse... Meget lang beskrivelse... Meget lang beskrivelse... Meget lang beskrivelse... Meget lang beskrivelse... Meget lang beskrivelse... Meget lang beskrivelse... Meget lang beskrivelse... Meget lang beskrivelse... ', 'Parkeringspladsen', 'F.eks. noget om:\r\n- drikkevarer\r\n- særlig beklædning\r\n- transport', 'W', 3);

-- --------------------------------------------------------

-- 
-- Struktur-dump for tabellen `jobcategory`
-- 

DROP TABLE IF EXISTS `jobcategory`;
CREATE TABLE `jobcategory` (
  `id` tinyint(4) NOT NULL auto_increment,
  `name` varchar(32) NOT NULL,
  `site_id` tinyint(4) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- 
-- Data dump for tabellen `jobcategory`
-- 

INSERT INTO `jobcategory` (`id`, `name`, `site_id`) VALUES 
(1, 'Aktivitet', 1),
(2, 'Vagt', 1),
(3, 'Forsyning', 1),
(4, 'Handyman', 1);

-- --------------------------------------------------------

-- 
-- Struktur-dump for tabellen `qualification`
-- 

DROP TABLE IF EXISTS `qualification`;
CREATE TABLE `qualification` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(32) NOT NULL,
  `site_id` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

-- 
-- Data dump for tabellen `qualification`
-- 

INSERT INTO `qualification` (`id`, `name`, `site_id`) VALUES 
(1, 'Motorsav', 1),
(2, 'Kørekort B', 1),
(3, 'Stort kørekort', 1),
(4, 'Hygiejnekursus', 1),
(5, 'Storkøkken', 1),
(6, 'VVS', 1),
(7, 'Elektriker', 1),
(8, 'Tømrer', 1),
(9, 'Sygeplejerske', 1),
(10, 'IT', 1),
(11, 'Kontorarbejde', 1),
(12, 'Truck-certifikat', 1);

-- --------------------------------------------------------

-- 
-- Struktur-dump for tabellen `role`
-- 

DROP TABLE IF EXISTS `role`;
CREATE TABLE `role` (
  `id` tinyint(4) NOT NULL auto_increment,
  `name` varchar(16) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- 
-- Data dump for tabellen `role`
-- 

INSERT INTO `role` (`id`, `name`) VALUES 
(1, 'Admin'),
(2, 'Arbejdsgiver'),
(3, 'Hjælper'),
(4, 'Jobkonsulent');

-- --------------------------------------------------------

-- 
-- Struktur-dump for tabellen `site`
-- 

DROP TABLE IF EXISTS `site`;
CREATE TABLE `site` (
  `id` tinyint(4) NOT NULL auto_increment,
  `name` varchar(32) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- 
-- Data dump for tabellen `site`
-- 

INSERT INTO `site` (`id`, `name`) VALUES 
(1, 'SEE 20:10 Jobcenter');

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
  PRIMARY KEY  (`id`),
  KEY `site_id` (`site_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

-- 
-- Data dump for tabellen `subcamp`
-- 

INSERT INTO `subcamp` (`id`, `site_id`, `name`, `contact_id`) VALUES 
(1, 1, 'Luppen', NULL),
(2, 1, 'Dråben', NULL),
(3, 1, 'Universet', NULL),
(4, 1, 'Solsikken', NULL),
(5, 1, 'Globen', NULL),
(6, 1, 'Symfonien', NULL),
(7, 1, 'Lanternen', NULL),
(8, 1, 'Sludderen', NULL),
(9, 1, 'Farveladen', NULL);

-- --------------------------------------------------------

-- 
-- Struktur-dump for tabellen `user_jobcategory`
-- 

DROP TABLE IF EXISTS `user_jobcategory`;
CREATE TABLE `user_jobcategory` (
  `cal_login` varchar(25) NOT NULL,
  `jobcategory_id` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- 
-- Data dump for tabellen `user_jobcategory`
-- 


-- --------------------------------------------------------

-- 
-- Struktur-dump for tabellen `user_qualification`
-- 

DROP TABLE IF EXISTS `user_qualification`;
CREATE TABLE `user_qualification` (
  `cal_login` varchar(25) NOT NULL,
  `qualification_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- 
-- Data dump for tabellen `user_qualification`
-- 

INSERT INTO `user_qualification` (`cal_login`, `qualification_id`) VALUES 
('tho', 2);

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
  PRIMARY KEY  (`cal_setting`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- 
-- Data dump for tabellen `webcal_config`
-- 

INSERT INTO `webcal_config` (`cal_setting`, `cal_value`) VALUES 
('ADD_LINK_IN_VIEWS', 'N'),
('ADMIN_OVERRIDE_UAC', 'Y'),
('ALLOW_ATTACH', 'N'),
('ALLOW_ATTACH_ANY', 'N'),
('ALLOW_ATTACH_PART', 'N'),
('ALLOW_COLOR_CUSTOMIZATION', 'Y'),
('ALLOW_COMMENTS', 'N'),
('ALLOW_COMMENTS_ANY', 'N'),
('ALLOW_COMMENTS_PART', 'N'),
('ALLOW_CONFLICTS', 'N'),
('ALLOW_CONFLICT_OVERRIDE', 'Y'),
('ALLOW_EXTERNAL_HEADER', 'N'),
('ALLOW_EXTERNAL_USERS', 'N'),
('ALLOW_HTML_DESCRIPTION', 'Y'),
('ALLOW_SELF_REGISTRATION', 'N'),
('ALLOW_USER_HEADER', 'N'),
('ALLOW_USER_THEMES', 'Y'),
('ALLOW_VIEW_OTHER', 'Y'),
('APPLICATION_NAME', 'SEE 20:10 Jobcenter'),
('APPROVE_ASSISTANT_EVENT', 'Y'),
('AUTO_REFRESH', 'N'),
('AUTO_REFRESH_TIME', '0'),
('BGCOLOR', '#FFFFFF'),
('BGREPEAT', 'repeat fixed center'),
('BOLD_DAYS_IN_YEAR', 'Y'),
('CAPTIONS', '#B04040'),
('CATEGORIES_ENABLED', 'Y'),
('CELLBG', '#C0C0C0'),
('CONFLICT_REPEAT_MONTHS', '6'),
('CUSTOM_HEADER', 'N'),
('CUSTOM_SCRIPT', 'N'),
('CUSTOM_TRAILER', 'Y'),
('DATE_FORMAT', 'LANGUAGE_DEFINED'),
('DATE_FORMAT_MD', 'LANGUAGE_DEFINED'),
('DATE_FORMAT_MY', 'LANGUAGE_DEFINED'),
('DATE_FORMAT_TASK', 'LANGUAGE_DEFINED'),
('DEMO_MODE', 'N'),
('DISABLE_ACCESS_FIELD', 'N'),
('DISABLE_CROSSDAY_EVENTS', 'N'),
('DISABLE_LOCATION_FIELD', 'N'),
('DISABLE_PARTICIPANTS_FIELD', 'N'),
('DISABLE_POPUPS', 'N'),
('DISABLE_PRIORITY_FIELD', 'N'),
('DISABLE_REMINDER_FIELD', 'N'),
('DISABLE_REPEATING_FIELD', 'N'),
('DISABLE_URL_FIELD', 'Y'),
('DISPLAY_ALL_DAYS_IN_MONTH', 'N'),
('DISPLAY_CREATED_BYPROXY', 'Y'),
('DISPLAY_DESC_PRINT_DAY', 'Y'),
('DISPLAY_END_TIMES', 'N'),
('DISPLAY_LOCATION', 'N'),
('DISPLAY_LONG_DAYS', 'N'),
('DISPLAY_MINUTES', 'N'),
('DISPLAY_MOON_PHASES', 'N'),
('DISPLAY_SM_MONTH', 'Y'),
('DISPLAY_TASKS', 'N'),
('DISPLAY_TASKS_IN_GRID', 'N'),
('DISPLAY_UNAPPROVED', 'Y'),
('DISPLAY_WEEKENDS', 'Y'),
('DISPLAY_WEEKNUMBER', 'Y'),
('EMAIL_ASSISTANT_EVENTS', 'Y'),
('EMAIL_EVENT_ADDED', 'Y'),
('EMAIL_EVENT_CREATE', 'N'),
('EMAIL_EVENT_DELETED', 'Y'),
('EMAIL_EVENT_REJECTED', 'Y'),
('EMAIL_EVENT_UPDATED', 'Y'),
('EMAIL_FALLBACK_FROM', 'youremailhere'),
('EMAIL_HTML', 'N'),
('EMAIL_MAILER', 'mail'),
('EMAIL_REMINDER', 'Y'),
('ENABLE_CAPTCHA', 'N'),
('ENABLE_GRADIENTS', 'N'),
('ENABLE_ICON_UPLOADS', 'N'),
('ENTRY_SLOTS', '144'),
('EXTERNAL_NOTIFICATIONS', 'N'),
('EXTERNAL_REMINDERS', 'N'),
('FONTS', 'Arial, Helvetica, sans-serif'),
('FREEBUSY_ENABLED', 'N'),
('GENERAL_USE_GMT', 'Y'),
('GROUPS_ENABLED', 'N'),
('H2COLOR', '#000000'),
('HASEVENTSBG', '#FFFF33'),
('IMPORT_CATEGORIES', 'Y'),
('LANGUAGE', 'none'),
('LIMIT_APPTS', 'N'),
('LIMIT_APPTS_NUMBER', '6'),
('LIMIT_DESCRIPTION_SIZE', 'N'),
('MENU_DATE_TOP', 'Y'),
('MENU_ENABLED', 'Y'),
('MENU_THEME', 'default'),
('MYEVENTS', '#006000'),
('NONUSER_AT_TOP', 'Y'),
('NONUSER_ENABLED', 'Y'),
('OTHERMONTHBG', '#D0D0D0'),
('OVERRIDE_PUBLIC', 'N'),
('OVERRIDE_PUBLIC_TEXT', 'Not available'),
('PARTICIPANTS_IN_POPUP', 'N'),
('PLUGINS_ENABLED', 'N'),
('POPUP_BG', '#FFFFFF'),
('POPUP_FG', '#000000'),
('PUBLIC_ACCESS', 'Y'),
('PUBLIC_ACCESS_ADD_NEEDS_APPROVAL', 'N'),
('PUBLIC_ACCESS_CAN_ADD', 'N'),
('PUBLIC_ACCESS_DEFAULT_SELECTED', 'N'),
('PUBLIC_ACCESS_DEFAULT_VISIBLE', 'N'),
('PUBLIC_ACCESS_OTHERS', 'Y'),
('PUBLIC_ACCESS_VIEW_PART', 'N'),
('PUBLISH_ENABLED', 'Y'),
('PULLDOWN_WEEKNUMBER', 'N'),
('REMEMBER_LAST_LOGIN', 'N'),
('REMINDER_DEFAULT', 'N'),
('REMINDER_OFFSET', '240'),
('REMINDER_WITH_DATE', 'N'),
('REMOTES_ENABLED', 'N'),
('REPORTS_ENABLED', 'N'),
('REQUIRE_APPROVALS', 'Y'),
('RSS_ENABLED', 'N'),
('SELF_REGISTRATION_BLACKLIST', 'N'),
('SELF_REGISTRATION_FULL', 'N'),
('SEND_EMAIL', 'N'),
('SERVER_TIMEZONE', 'Europe/Copenhagen'),
('SERVER_URL', 'http://see2010jobcenter.wh.spejdernet.dk/'),
('SITE_EXTRAS_IN_POPUP', 'N'),
('SMTP_AUTH', 'N'),
('SMTP_HOST', 'localhost'),
('SMTP_PORT', '25'),
('STARTVIEW', 'jc_menu.php'),
('SUMMARY_LENGTH', '80'),
('TABLEBG', '#000000'),
('TEXTCOLOR', '#000000'),
('THBG', '#FFFFFF'),
('THEME', 'none'),
('THFG', '#000000'),
('TIMED_EVT_LEN', 'E'),
('TIMEZONE', 'Europe/Copenhagen'),
('TIME_FORMAT', '24'),
('TIME_SLOTS', '24'),
('TIME_SPACER', '&raquo;&nbsp;'),
('TODAYCELLBG', '#FFFF33'),
('UAC_ENABLED', 'N'),
('UPCOMING_ALLOW_OVR', 'N'),
('UPCOMING_DISPLAY_CAT_ICONS', 'Y'),
('UPCOMING_DISPLAY_LAYERS', 'N'),
('UPCOMING_DISPLAY_LINKS', 'Y'),
('UPCOMING_DISPLAY_POPUPS', 'Y'),
('UPCOMING_EVENTS', 'N'),
('USER_PUBLISH_ENABLED', 'Y'),
('USER_PUBLISH_RW_ENABLED', 'Y'),
('USER_RSS_ENABLED', 'N'),
('USER_SEES_ONLY_HIS_GROUPS', 'Y'),
('USER_SORT_ORDER', 'cal_firstname, cal_lastname'),
('WEBCAL_PROGRAM_VERSION', 'v1.2.0'),
('WEBCAL_TZ_CONVERSION', 'Y'),
('WEEKENDBG', '#D0D0D0'),
('WEEKEND_START', '6'),
('WEEKNUMBER', '#FF6633'),
('WEEK_START', '1'),
('WORK_DAY_END_HOUR', '17'),
('WORK_DAY_START_HOUR', '8');

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
  PRIMARY KEY  (`cal_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- 
-- Data dump for tabellen `webcal_entry`
-- 

INSERT INTO `webcal_entry` (`cal_id`, `cal_group_id`, `cal_ext_for_id`, `cal_create_by`, `cal_date`, `cal_time`, `cal_mod_date`, `cal_mod_time`, `cal_duration`, `cal_due_date`, `cal_due_time`, `cal_priority`, `cal_type`, `cal_access`, `cal_name`, `cal_location`, `cal_url`, `cal_completed`, `cal_description`, `job_id`, `person_need`, `contact_id`) VALUES 
(1, NULL, NULL, 'testarbejdsgiver', 20090724, 80000, NULL, NULL, 60, NULL, NULL, 5, 'E', 'P', 'autogen', NULL, NULL, NULL, NULL, 17, NULL, NULL),
(2, NULL, NULL, 'testarbejdsgiver', 20090725, 80000, NULL, NULL, 60, NULL, NULL, 5, 'E', 'P', 'autogen', NULL, NULL, NULL, NULL, 17, 1, NULL),
(3, NULL, NULL, 'testarbejdsgiver', 20090726, 80000, NULL, NULL, 60, NULL, NULL, 5, 'E', 'P', 'autogen', NULL, NULL, NULL, NULL, 17, 2, NULL),
(4, NULL, NULL, 'testarbejdsgiver', 20090727, 80000, NULL, NULL, 60, NULL, NULL, 5, 'E', 'P', 'autogen', NULL, NULL, NULL, NULL, 17, 3, NULL),
(5, NULL, NULL, 'testarbejdsgiver', 20090728, 80000, NULL, NULL, 60, NULL, NULL, 5, 'E', 'P', 'autogen', NULL, NULL, NULL, NULL, 17, 4, NULL),
(6, NULL, NULL, 'testarbejdsgiver', 20090729, 80000, NULL, NULL, 60, NULL, NULL, 5, 'E', 'P', 'autogen', NULL, NULL, NULL, NULL, 17, 5, NULL),
(7, NULL, NULL, 'testarbejdsgiver', 20090730, 80000, NULL, NULL, 60, NULL, NULL, 5, 'E', 'P', 'autogen', NULL, NULL, NULL, NULL, 17, 6, NULL),
(8, NULL, NULL, 'testarbejdsgiver', 20090731, 80000, NULL, NULL, 60, NULL, NULL, 5, 'E', 'P', 'autogen', NULL, NULL, NULL, NULL, 17, 7, NULL),
(9, NULL, NULL, 'testarbejdsgiver', 20090801, 80000, NULL, NULL, 60, NULL, NULL, 5, 'E', 'P', 'autogen', NULL, NULL, NULL, NULL, 17, NULL, NULL),
(10, NULL, NULL, 'testarbejdsgiver', 20090724, 90000, NULL, NULL, 60, NULL, NULL, 5, 'E', 'P', 'autogen', NULL, NULL, NULL, NULL, 17, NULL, NULL),
(11, NULL, NULL, 'testarbejdsgiver', 20090725, 90000, NULL, NULL, 60, NULL, NULL, 5, 'E', 'P', 'autogen', NULL, NULL, NULL, NULL, 17, NULL, NULL),
(12, NULL, NULL, 'testarbejdsgiver', 20090726, 90000, NULL, NULL, 60, NULL, NULL, 5, 'E', 'P', 'autogen', NULL, NULL, NULL, NULL, 17, NULL, NULL),
(13, NULL, NULL, 'testarbejdsgiver', 20090727, 90000, NULL, NULL, 60, NULL, NULL, 5, 'E', 'P', 'autogen', NULL, NULL, NULL, NULL, 17, NULL, NULL),
(14, NULL, NULL, 'testarbejdsgiver', 20090728, 90000, NULL, NULL, 60, NULL, NULL, 5, 'E', 'P', 'autogen', NULL, NULL, NULL, NULL, 17, NULL, NULL),
(15, NULL, NULL, 'testarbejdsgiver', 20090729, 90000, NULL, NULL, 60, NULL, NULL, 5, 'E', 'P', 'autogen', NULL, NULL, NULL, NULL, 17, NULL, NULL),
(16, NULL, NULL, 'testarbejdsgiver', 20090730, 90000, NULL, NULL, 60, NULL, NULL, 5, 'E', 'P', 'autogen', NULL, NULL, NULL, NULL, 17, NULL, NULL),
(17, NULL, NULL, 'testarbejdsgiver', 20090731, 90000, NULL, NULL, 60, NULL, NULL, 5, 'E', 'P', 'autogen', NULL, NULL, NULL, NULL, 17, NULL, NULL),
(18, NULL, NULL, 'testarbejdsgiver', 20090801, 90000, NULL, NULL, 60, NULL, NULL, 5, 'E', 'P', 'autogen', NULL, NULL, NULL, NULL, 17, 8, NULL);

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
(17, 0, 'system', NULL, 'x', 20090822, 135657, 'Brugernavn: tho, IP: 127.0.0.1');

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
  PRIMARY KEY  (`cal_id`,`cal_login`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- 
-- Data dump for tabellen `webcal_entry_user`
-- 


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
  PRIMARY KEY  (`cal_login`),
  KEY `group_id` (`group_id`),
  KEY `role_id` (`role_id`),
  KEY `site_id` (`site_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- 
-- Data dump for tabellen `webcal_user`
-- 

INSERT INTO `webcal_user` (`cal_login`, `cal_passwd`, `cal_lastname`, `cal_firstname`, `cal_is_admin`, `cal_email`, `cal_enabled`, `cal_telephone`, `cal_address`, `cal_title`, `cal_birthday`, `cal_last_login`, `role_id`, `site_id`, `group_id`, `count`, `age_range`, `qualifications`, `notes`) VALUES 
('admin', '21232f297a57a5a743894a0e4a801fc3', 'ADMINISTRATOR', 'DEFAULT', 'Y', NULL, 'Y', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('agh', '37ee804a8d31f41305a138d16f41bebc', 'Givskov', 'Anders', 'N', 'agh@spejdernet.dk', 'Y', '1234', 'andeby', '', NULL, NULL, 1, 1, 0, 1, '1', '', ''),
('per', '2eec2245df990aa35a2a05db29fbfb06', 'Kousgaard Thomsen', 'Per', 'N', 'pkthomsen@pc.dk', 'Y', '55441671 - 29441671', 'Møllevej 9, 8832 Skals', '', NULL, NULL, 1, 1, 0, 1, '1', '', ''),
('steen', '6fa81a1534625d17a213377a53517558', 'Villekold Rasmussen', 'Steen', 'N', 'Steenvr@ofir.dk', 'Y', '24431057', 'Vester Skivevej 2, 7800 Skive', '', NULL, NULL, 1, 1, 0, 1, '1', '', ''),
('testarbejdsgiver', 'e9c21c68899c781e31a927acd9a1d42b', 'Arbejdsgiver', 'Test', 'N', '', 'Y', '12345678', '1234', '', NULL, NULL, 2, 1, 0, 1, '1', '', ''),
('tho', '21232f297a57a5a743894a0e4a801fc3', 'Højgaard Olesen', 'Thorbjørn', 'N', 'tho@thodata.dk', 'Y', '27284500', 'Galstersgade 2, 1, 9400 Nørresundby', 'Klan Rosa', NULL, NULL, 1, 1, 0, 1, '28', '', '');

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
('steen', 'LANGUAGE', 'Danish'),
('testarbejdsgiver', 'LANGUAGE', 'Danish'),
('tho', 'LANGUAGE', 'Danish');

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
