-- phpMyAdmin SQL Dump
-- version 3.2.5
-- http://www.phpmyadmin.net
--
-- Vært: localhost
-- Genereringstid: 25. 03 2010 kl. 02:54:50
-- Serverversion: 5.1.35
-- PHP-version: 5.2.6

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `thodata_dk_db`
--

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `area`
--

DROP TABLE IF EXISTS `area`;
CREATE TABLE `area` (
  `id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `site_id` tinyint(4) NOT NULL,
  `name` varchar(64) NOT NULL,
  `description` varchar(255) NOT NULL,
  `contact_id` varchar(25) DEFAULT NULL,
  `def_date` timestamp NULL DEFAULT NULL,
  `def_user` varchar(25) DEFAULT NULL,
  `upd_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `upd_user` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `site_id` (`site_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Data dump for tabellen `area`
--

INSERT INTO `area` (`id`, `site_id`, `name`, `description`, `contact_id`, `def_date`, `def_user`, `upd_date`, `upd_user`) VALUES
(1, 1, 'FOR', 'Forplejning', 'rht', '2010-01-28 08:16:55', NULL, '2010-01-28 08:16:55', NULL),
(2, 1, 'DIV', 'Diverse', 'rht', '2010-01-28 08:16:55', NULL, '2010-01-28 08:16:55', NULL),
(3, 1, 'FES', 'Fester', 'rht', '2010-01-28 08:16:55', NULL, '2010-01-28 08:16:55', NULL),
(4, 1, 'SEM', 'Seminarer', 'rht', '2010-01-28 08:16:55', NULL, '2010-01-28 08:16:55', NULL),
(5, 1, 'SEK', 'Sekretariat', 'rht', '2010-01-28 08:16:55', NULL, '2010-01-28 08:16:55', NULL);

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `days`
--

DROP TABLE IF EXISTS `days`;
CREATE TABLE `days` (
  `id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `site_id` tinyint(4) NOT NULL,
  `date` date NOT NULL,
  `time` int(11) DEFAULT NULL,
  `def_date` timestamp NULL DEFAULT NULL,
  `def_user` varchar(25) DEFAULT NULL,
  `upd_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `upd_user` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `site_id` (`site_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Data dump for tabellen `days`
--

INSERT INTO `days` (`id`, `site_id`, `date`, `time`, `def_date`, `def_user`, `upd_date`, `upd_user`) VALUES
(1, 1, '2010-06-07', 80000, '2010-01-28 08:22:52', NULL, '2010-01-28 08:22:52', NULL),
(2, 1, '2010-06-08', NULL, '2010-01-28 08:22:52', NULL, '2010-01-28 08:22:52', NULL),
(3, 1, '2010-06-09', NULL, '2010-01-28 08:22:52', NULL, '2010-01-28 08:22:52', NULL),
(4, 1, '2010-06-10', NULL, '2010-01-28 08:22:52', NULL, '2010-01-28 08:22:52', NULL),
(5, 1, '2010-06-11', NULL, '2010-01-28 08:22:52', NULL, '2010-01-28 08:22:52', NULL),
(6, 1, '2010-06-12', NULL, '2010-01-28 08:22:52', NULL, '2010-01-28 08:22:52', NULL),
(7, 1, '2010-06-13', 220000, '2010-01-28 08:22:52', NULL, '2010-01-28 08:22:52', NULL);

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `district`
--

DROP TABLE IF EXISTS `district`;
CREATE TABLE `district` (
  `id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `site_id` tinyint(4) NOT NULL,
  `name` varchar(64) NOT NULL,
  `subcamp_id` tinyint(4) NOT NULL,
  `def_date` timestamp NULL DEFAULT NULL,
  `def_user` varchar(25) DEFAULT NULL,
  `upd_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `upd_user` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `site_id` (`site_id`),
  KEY `subcamp_id` (`subcamp_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Data dump for tabellen `district`
--


-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `group`
--

DROP TABLE IF EXISTS `group`;
CREATE TABLE `group` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `site_id` tinyint(4) NOT NULL,
  `name` varchar(64) NOT NULL,
  `district_id` tinyint(4) DEFAULT NULL,
  `tmp_district_name` varchar(50) DEFAULT NULL,
  `def_date` timestamp NULL DEFAULT NULL,
  `def_user` varchar(25) DEFAULT NULL,
  `upd_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `upd_user` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `district_id` (`district_id`),
  KEY `site_id` (`site_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Data dump for tabellen `group`
--

INSERT INTO `group` (`id`, `site_id`, `name`, `district_id`, `tmp_district_name`, `def_date`, `def_user`, `upd_date`, `upd_user`) VALUES
(0, 1, '- Ingen', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `job`
--

DROP TABLE IF EXISTS `job`;
CREATE TABLE `job` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `site_id` tinyint(4) DEFAULT NULL,
  `area_id` tinyint(4) DEFAULT NULL,
  `owner_id` varchar(25) DEFAULT NULL COMMENT 'cal_login',
  `name` varchar(64) NOT NULL,
  `description` text,
  `meetplace` varchar(64) DEFAULT NULL,
  `jobplace` varchar(64) DEFAULT NULL,
  `notes` text,
  `status` char(1) NOT NULL DEFAULT 'A' COMMENT 'Waiting/Approved/Deleted',
  `priority` tinyint(4) NOT NULL DEFAULT '3',
  `def_date` timestamp NULL DEFAULT NULL,
  `def_user` varchar(25) DEFAULT NULL,
  `upd_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `upd_user` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `owner_id` (`owner_id`),
  KEY `site_id` (`site_id`),
  KEY `area_id` (`area_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

--
-- Data dump for tabellen `job`
--

INSERT INTO `job` (`id`, `site_id`, `area_id`, `owner_id`, `name`, `description`, `meetplace`, `jobplace`, `notes`, `status`, `priority`, `def_date`, `def_user`, `upd_date`, `upd_user`) VALUES
(-2, NULL, NULL, NULL, 'Ledighedsperioder', NULL, NULL, NULL, NULL, 'F', 3, '2009-09-28 14:13:38', NULL, '2009-09-28 14:13:38', NULL),
(-1, NULL, NULL, NULL, 'Blokering', NULL, NULL, NULL, NULL, 'A', 3, '2009-09-28 14:15:40', NULL, '2009-09-28 14:15:40', NULL);

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `jobcategory`
--

DROP TABLE IF EXISTS `jobcategory`;
CREATE TABLE `jobcategory` (
  `id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `site_id` tinyint(4) NOT NULL,
  `def_date` timestamp NULL DEFAULT NULL,
  `def_user` varchar(25) DEFAULT NULL,
  `upd_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `upd_user` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Data dump for tabellen `jobcategory`
--

INSERT INTO `jobcategory` (`id`, `name`, `site_id`, `def_date`, `def_user`, `upd_date`, `upd_user`) VALUES
(1, 'Fester', 1, '2010-01-27 21:10:31', NULL, '2010-01-27 21:10:31', NULL),
(2, 'Sekretariat', 1, NULL, NULL, '2010-01-27 21:10:32', NULL),
(3, 'Runner', 1, NULL, NULL, '2010-01-27 21:10:32', NULL);

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `qualification`
--

DROP TABLE IF EXISTS `qualification`;
CREATE TABLE `qualification` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `site_id` int(11) NOT NULL,
  `def_date` timestamp NULL DEFAULT NULL,
  `def_user` varchar(25) DEFAULT NULL,
  `upd_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `upd_user` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Data dump for tabellen `qualification`
--

INSERT INTO `qualification` (`id`, `name`, `site_id`, `def_date`, `def_user`, `upd_date`, `upd_user`) VALUES
(2, 'Kørekort B', 1, NULL, NULL, '0000-00-00 00:00:00', NULL),
(3, 'Kørekort C', 1, '2009-10-19 23:05:29', NULL, '2009-10-19 23:05:29', NULL),
(4, 'Hygiejnekursus', 1, NULL, NULL, '0000-00-00 00:00:00', NULL),
(7, 'Elektriker', 1, NULL, NULL, '0000-00-00 00:00:00', NULL),
(9, 'Sygeplejerske', 1, NULL, NULL, '0000-00-00 00:00:00', NULL),
(10, 'IT', 1, NULL, NULL, '0000-00-00 00:00:00', NULL),
(11, 'Kontorarbejde', 1, NULL, NULL, '0000-00-00 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `role`
--

DROP TABLE IF EXISTS `role`;
CREATE TABLE `role` (
  `id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `name` varchar(16) NOT NULL,
  `def_date` timestamp NULL DEFAULT NULL,
  `def_user` varchar(25) DEFAULT NULL,
  `upd_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `upd_user` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`id`)
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
  `id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `def_date` timestamp NULL DEFAULT NULL,
  `def_user` varchar(25) DEFAULT NULL,
  `upd_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `upd_user` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Data dump for tabellen `site`
--

INSERT INTO `site` (`id`, `name`, `def_date`, `def_user`, `upd_date`, `upd_user`) VALUES
(1, 'EC2010 Jobbank', '2010-01-28 08:26:32', NULL, '2010-01-28 08:26:32', NULL);

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `subcamp`
--

DROP TABLE IF EXISTS `subcamp`;
CREATE TABLE `subcamp` (
  `id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `site_id` tinyint(4) NOT NULL,
  `name` varchar(64) NOT NULL,
  `contact_id` varchar(25) DEFAULT NULL,
  `def_date` timestamp NULL DEFAULT NULL,
  `def_user` varchar(25) DEFAULT NULL,
  `upd_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `upd_user` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `site_id` (`site_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Data dump for tabellen `subcamp`
--


-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `user_jobcategory`
--

DROP TABLE IF EXISTS `user_jobcategory`;
CREATE TABLE `user_jobcategory` (
  `cal_login` varchar(25) NOT NULL,
  `jobcategory_id` tinyint(4) NOT NULL,
  `def_date` timestamp NULL DEFAULT NULL,
  `def_user` varchar(25) DEFAULT NULL,
  `upd_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `upd_user` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Data dump for tabellen `user_jobcategory`
--

INSERT INTO `user_jobcategory` (`cal_login`, `jobcategory_id`, `def_date`, `def_user`, `upd_date`, `upd_user`) VALUES
('testhjaelper', 1, NULL, NULL, '2010-02-05 09:05:45', NULL),
('Louise', 1, NULL, NULL, '2010-03-14 18:20:09', NULL);

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `user_qualification`
--

DROP TABLE IF EXISTS `user_qualification`;
CREATE TABLE `user_qualification` (
  `cal_login` varchar(25) NOT NULL,
  `qualification_id` int(11) NOT NULL,
  `def_date` timestamp NULL DEFAULT NULL,
  `def_user` varchar(25) DEFAULT NULL,
  `upd_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `upd_user` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Data dump for tabellen `user_qualification`
--

INSERT INTO `user_qualification` (`cal_login`, `qualification_id`, `def_date`, `def_user`, `upd_date`, `upd_user`) VALUES
('__public__', 4, NULL, NULL, '2010-03-14 18:20:10', '__public__');

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `webcal_access_function`
--

DROP TABLE IF EXISTS `webcal_access_function`;
CREATE TABLE `webcal_access_function` (
  `cal_login` varchar(25) NOT NULL,
  `cal_permissions` varchar(64) NOT NULL,
  PRIMARY KEY (`cal_login`)
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
  `cal_can_view` int(11) NOT NULL DEFAULT '0',
  `cal_can_edit` int(11) NOT NULL DEFAULT '0',
  `cal_can_approve` int(11) NOT NULL DEFAULT '0',
  `cal_can_invite` char(1) DEFAULT 'Y',
  `cal_can_email` char(1) DEFAULT 'Y',
  `cal_see_time_only` char(1) DEFAULT 'N',
  PRIMARY KEY (`cal_login`,`cal_other_user`)
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
  PRIMARY KEY (`cal_boss`,`cal_assistant`)
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
  `cal_id` int(11) DEFAULT NULL,
  `cal_login` varchar(25) DEFAULT NULL,
  `cal_name` varchar(30) DEFAULT NULL,
  `cal_description` varchar(128) DEFAULT NULL,
  `cal_size` int(11) DEFAULT NULL,
  `cal_mime_type` varchar(50) DEFAULT NULL,
  `cal_type` char(1) NOT NULL,
  `cal_mod_date` int(11) NOT NULL,
  `cal_mod_time` int(11) NOT NULL,
  `cal_blob` longblob,
  PRIMARY KEY (`cal_blob_id`)
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
  `cat_owner` varchar(25) DEFAULT NULL,
  `cat_name` varchar(80) NOT NULL,
  `cat_color` varchar(8) DEFAULT NULL,
  PRIMARY KEY (`cat_id`)
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
  `cal_value` varchar(100) DEFAULT NULL,
  `site_id` tinyint(4) DEFAULT NULL
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
('JC_EMAIL', 'tho@thodata.dk', 1),
('JC_EMAIL_FROM', 'EC2010 Jobbank', 1),
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
('WEBCAL_TZ_CONVERSION', 'Y', NULL),
('WEEKENDBG', '#D0D0D0', NULL),
('WEEKEND_START', '6', NULL),
('WEEKNUMBER', '#FF6633', NULL),
('WEEK_START', '1', NULL),
('WORK_DAY_END_HOUR', '17', NULL),
('WORK_DAY_START_HOUR', '8', NULL),
('BGIMAGE', '', NULL),
('SMTP_PASSWORD', '', NULL),
('SMTP_USERNAME', '', NULL),
('JC_HELP_URL', 'http://see2010.spejdernet.dk/uploads/media/Vejledning_til_Jobdatabasen.pdf', 1),
('JC_SITE_URL', 'http://ec2010jobbank.thodata.dk', 1),
('WEBCAL_PROGRAM_VERSION', 'v1.2.0', NULL),
('APPLICATION_NAME', 'EC2010 Jobbank', NULL),
('SERVER_URL', 'http://ec2010jobbank.thodata.dk/', NULL);

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `webcal_entry`
--

DROP TABLE IF EXISTS `webcal_entry`;
CREATE TABLE `webcal_entry` (
  `cal_id` int(11) NOT NULL,
  `cal_group_id` int(11) DEFAULT NULL,
  `cal_ext_for_id` int(11) DEFAULT NULL,
  `cal_create_by` varchar(25) NOT NULL,
  `cal_date` int(11) NOT NULL,
  `cal_time` int(11) DEFAULT NULL,
  `cal_mod_date` int(11) DEFAULT NULL,
  `cal_mod_time` int(11) DEFAULT NULL,
  `cal_duration` int(11) NOT NULL,
  `cal_due_date` int(11) DEFAULT NULL,
  `cal_due_time` int(11) DEFAULT NULL,
  `cal_priority` int(11) DEFAULT '5',
  `cal_type` char(1) DEFAULT 'E',
  `cal_access` char(1) DEFAULT 'P',
  `cal_name` varchar(80) NOT NULL,
  `cal_location` varchar(100) DEFAULT NULL,
  `cal_url` varchar(100) DEFAULT NULL,
  `cal_completed` int(11) DEFAULT NULL,
  `cal_description` text,
  `job_id` smallint(6) DEFAULT NULL,
  `person_need` tinyint(4) DEFAULT '0',
  `contact_id` varchar(25) DEFAULT NULL,
  `def_date` timestamp NULL DEFAULT NULL,
  `def_user` varchar(25) DEFAULT NULL,
  `upd_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `upd_user` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`cal_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Data dump for tabellen `webcal_entry`
--


-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `webcal_entry_categories`
--

DROP TABLE IF EXISTS `webcal_entry_categories`;
CREATE TABLE `webcal_entry_categories` (
  `cal_id` int(11) NOT NULL DEFAULT '0',
  `cat_id` int(11) NOT NULL DEFAULT '0',
  `cat_order` int(11) NOT NULL DEFAULT '0',
  `cat_owner` varchar(25) DEFAULT NULL
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
  `cal_id` int(11) NOT NULL DEFAULT '0',
  `cal_fullname` varchar(50) NOT NULL,
  `cal_email` varchar(75) DEFAULT NULL,
  PRIMARY KEY (`cal_id`,`cal_fullname`)
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
  `cal_user_cal` varchar(25) DEFAULT NULL,
  `cal_type` char(1) NOT NULL,
  `cal_date` int(11) NOT NULL,
  `cal_time` int(11) DEFAULT NULL,
  `cal_text` text,
  PRIMARY KEY (`cal_log_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Data dump for tabellen `webcal_entry_log`
--

INSERT INTO `webcal_entry_log` (`cal_log_id`, `cal_entry_id`, `cal_login`, `cal_user_cal`, `cal_type`, `cal_date`, `cal_time`, `cal_text`) VALUES
(1, 0, 'system', NULL, 'x', 20100128, 235802, 'Brugernavn: jcihelper, IP: 90.185.51.51'),
(2, 0, 'system', NULL, 'x', 20100128, 235812, 'Brugernavn: testhelper, IP: 90.185.51.51'),
(3, 0, 'system', NULL, 'x', 20100128, 235832, 'Brugernavn: testhelper, IP: 90.185.51.51'),
(4, 0, 'system', NULL, 'x', 20100130, 71711, 'Brugernavn: richardt, IP: 77.68.136.157'),
(5, 0, 'system', NULL, 'x', 20100130, 71742, 'Brugernavn: test, IP: 77.68.136.157'),
(6, 0, 'system', NULL, 'x', 20100130, 93946, 'Brugernavn: richardt_thomsen, IP: 87.51.7.110'),
(7, 0, 'system', NULL, 'x', 20100205, 80523, 'Brugernavn: testhjaelper, IP: 90.185.51.51'),
(8, 0, 'system', NULL, 'x', 20100312, 193433, 'Brugernavn: richardt, IP: 77.68.136.157'),
(9, 0, 'system', NULL, 'x', 20100312, 193454, 'Brugernavn: richardt_thomsen, IP: 77.68.136.157'),
(10, 0, 'system', NULL, 'x', 20100312, 193509, 'Brugernavn: RIC, IP: 77.68.136.157'),
(11, 0, 'system', NULL, 'x', 20100312, 193530, 'Brugernavn: Richardt thomsen, IP: 77.68.136.157');

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `webcal_entry_repeats`
--

DROP TABLE IF EXISTS `webcal_entry_repeats`;
CREATE TABLE `webcal_entry_repeats` (
  `cal_id` int(11) NOT NULL DEFAULT '0',
  `cal_type` varchar(20) DEFAULT NULL,
  `cal_end` int(11) DEFAULT NULL,
  `cal_endtime` int(11) DEFAULT NULL,
  `cal_frequency` int(11) DEFAULT '1',
  `cal_days` char(7) DEFAULT NULL,
  `cal_bymonth` varchar(50) DEFAULT NULL,
  `cal_bymonthday` varchar(100) DEFAULT NULL,
  `cal_byday` varchar(100) DEFAULT NULL,
  `cal_bysetpos` varchar(50) DEFAULT NULL,
  `cal_byweekno` varchar(50) DEFAULT NULL,
  `cal_byyearday` varchar(50) DEFAULT NULL,
  `cal_wkst` char(2) DEFAULT 'MO',
  `cal_count` int(11) DEFAULT NULL,
  PRIMARY KEY (`cal_id`)
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
  `cal_exdate` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`cal_id`,`cal_date`)
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
  `cal_id` int(11) NOT NULL DEFAULT '0',
  `cal_login` varchar(25) NOT NULL,
  `cal_status` char(1) DEFAULT 'A',
  `cal_category` int(11) DEFAULT NULL,
  `cal_percent` int(11) NOT NULL DEFAULT '0',
  `count` int(11) DEFAULT NULL,
  `notes` varchar(255) DEFAULT NULL,
  `def_date` timestamp NULL DEFAULT NULL,
  `def_user` varchar(25) DEFAULT NULL,
  `upd_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `upd_user` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`cal_id`,`cal_login`)
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
  `cal_owner` varchar(25) DEFAULT NULL,
  `cal_name` varchar(50) NOT NULL,
  `cal_last_update` int(11) NOT NULL,
  PRIMARY KEY (`cal_group_id`)
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
  PRIMARY KEY (`cal_group_id`,`cal_login`)
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
  `cal_name` varchar(50) DEFAULT NULL,
  `cal_date` int(11) NOT NULL,
  `cal_type` varchar(10) NOT NULL,
  `cal_login` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`cal_import_id`)
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
  `cal_external_id` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`cal_id`,`cal_login`)
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
  `cal_lastname` varchar(25) DEFAULT NULL,
  `cal_firstname` varchar(25) DEFAULT NULL,
  `cal_admin` varchar(25) NOT NULL,
  `cal_is_public` char(1) NOT NULL DEFAULT 'N',
  `cal_url` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`cal_login`)
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
  `cal_id` int(11) NOT NULL DEFAULT '0',
  `cal_date` int(11) NOT NULL DEFAULT '0',
  `cal_offset` int(11) NOT NULL DEFAULT '0',
  `cal_related` char(1) NOT NULL DEFAULT 'S',
  `cal_before` char(1) NOT NULL DEFAULT 'Y',
  `cal_last_sent` int(11) NOT NULL DEFAULT '0',
  `cal_repeats` int(11) NOT NULL DEFAULT '0',
  `cal_duration` int(11) NOT NULL DEFAULT '0',
  `cal_times_sent` int(11) NOT NULL DEFAULT '0',
  `cal_action` varchar(12) NOT NULL DEFAULT 'EMAIL',
  PRIMARY KEY (`cal_id`)
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
  `cal_is_global` char(1) NOT NULL DEFAULT 'N',
  `cal_report_type` varchar(20) NOT NULL,
  `cal_include_header` char(1) NOT NULL DEFAULT 'Y',
  `cal_report_name` varchar(50) NOT NULL,
  `cal_time_range` int(11) NOT NULL,
  `cal_user` varchar(25) DEFAULT NULL,
  `cal_allow_nav` char(1) DEFAULT 'Y',
  `cal_cat_id` int(11) DEFAULT NULL,
  `cal_include_empty` char(1) DEFAULT 'N',
  `cal_show_in_trailer` char(1) DEFAULT 'N',
  `cal_update_date` int(11) NOT NULL,
  PRIMARY KEY (`cal_report_id`)
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
  PRIMARY KEY (`cal_report_id`,`cal_template_type`)
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
  `cal_id` int(11) NOT NULL DEFAULT '0',
  `cal_name` varchar(25) NOT NULL,
  `cal_type` int(11) NOT NULL,
  `cal_date` int(11) DEFAULT '0',
  `cal_remind` int(11) DEFAULT '0',
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
  `tzid` varchar(100) NOT NULL DEFAULT '',
  `dtstart` varchar(25) DEFAULT NULL,
  `dtend` varchar(25) DEFAULT NULL,
  `vtimezone` text,
  PRIMARY KEY (`tzid`)
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
  `cal_passwd` varchar(32) DEFAULT NULL,
  `cal_lastname` varchar(25) DEFAULT NULL,
  `cal_firstname` varchar(25) DEFAULT NULL,
  `cal_is_admin` char(1) DEFAULT 'N',
  `cal_email` varchar(75) DEFAULT NULL,
  `cal_enabled` char(1) DEFAULT 'Y',
  `cal_telephone` varchar(50) DEFAULT NULL,
  `cal_address` varchar(75) DEFAULT NULL,
  `cal_title` varchar(75) DEFAULT NULL,
  `cal_birthday` int(11) DEFAULT NULL,
  `cal_last_login` int(11) DEFAULT NULL,
  `role_id` tinyint(4) DEFAULT NULL,
  `site_id` tinyint(4) DEFAULT NULL,
  `group_id` smallint(6) DEFAULT NULL,
  `count` int(11) DEFAULT NULL,
  `age_range` varchar(10) DEFAULT NULL,
  `qualifications` varchar(255) DEFAULT NULL,
  `notes` varchar(255) DEFAULT NULL,
  `ext_login` varchar(64) DEFAULT NULL,
  `def_date` timestamp NULL DEFAULT NULL,
  `def_user` varchar(25) DEFAULT NULL,
  `upd_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `upd_user` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`cal_login`),
  KEY `group_id` (`group_id`),
  KEY `role_id` (`role_id`),
  KEY `site_id` (`site_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Data dump for tabellen `webcal_user`
--

INSERT INTO `webcal_user` (`cal_login`, `cal_passwd`, `cal_lastname`, `cal_firstname`, `cal_is_admin`, `cal_email`, `cal_enabled`, `cal_telephone`, `cal_address`, `cal_title`, `cal_birthday`, `cal_last_login`, `role_id`, `site_id`, `group_id`, `count`, `age_range`, `qualifications`, `notes`, `ext_login`, `def_date`, `def_user`, `upd_date`, `upd_user`) VALUES
('admin', 'c08444d8f18618c446682a7aa1cfe917', 'ADMINISTRATOR', 'DEFAULT', 'Y', NULL, 'Y', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2009-09-30 15:29:44', NULL),
('Louise', '6228bd57c9a858eb305e0fd0694890f7', 'Palsgaard', 'Louise', 'N', '', 'Y', '87921387', 'Vester Halne Vej 86, 9430 Vadum', '', NULL, NULL, 3, 1, 0, 5, '35', '', '', '', '2010-03-14 18:20:09', '__public__', '2010-03-14 18:20:09', '__public__'),
('mwh', '7b29cd266c3369f32c2f54ea44022edf', 'W. Hansen', 'Michael', 'N', 'mwh@up-front.dk', 'Y', '21470995', 'Søndre Ringgade 61, st. tv, 8000 Århus C', '', NULL, NULL, 1, 1, 0, 1, '1', '', '', '', '2010-03-15 10:30:54', 'tho', '2010-03-15 10:30:54', 'tho'),
('rht', '6177e459492afc51f5dcdfd6666b653a', 'Thomsen', 'Richard', 'N', 'richardt.thomsen@gmail.com', 'Y', '30499091', 'Vester Halnevej, 9400', NULL, NULL, NULL, 1, 1, 0, NULL, NULL, NULL, '', '', '2010-01-27 20:13:57', 'tho', '2010-03-12 20:35:50', 'tho'),
('Richardt_Thomsen', '6228bd57c9a858eb305e0fd0694890f7', 'Thomsen', 'Richardt', 'N', 'thomsenrichard@hotmail.com', 'Y', '21446709', 'Vester Halne Vej 86, 9430 Vadum', NULL, NULL, NULL, 2, 1, 0, NULL, NULL, NULL, '', '', '2010-01-30 08:21:22', '__public__', '2010-01-30 08:21:22', '__public__'),
('testarbejdsgiver', '098f6bcd4621d373cade4e832627b4f6', 'Olesen', 'TestArb', 'N', 'tholesen@gmail.com', 'Y', '12345678', 'Andeby 3', NULL, NULL, NULL, 2, 1, 0, NULL, NULL, NULL, '', '', '2010-01-28 08:32:04', 'tho', '2010-01-28 08:32:04', 'tho'),
('testhjaelper', '098f6bcd4621d373cade4e832627b4f6', 'Olesen', 'TestHjælp', 'N', 'geocaching@thodata.dk', 'Y', '87654321', 'Andeby 5', 'Hjørring homeboys', NULL, NULL, 3, 1, 0, 5, '20', '', 'er tændt på EC2010', '', '2010-01-28 08:34:04', 'tho', '2010-02-05 09:05:45', 'testhjaelper'),
('tho', 'd9eaabe53adedb62bc74b7eb0a9477d4', 'Højgaard Olesen', 'Thorbjørn', 'N', 'tho@thodata.dk', 'Y', '27284500', 'Galstersgade 2, 1, 9400 Nørresundby', NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, '', '', NULL, NULL, '2009-12-12 23:11:43', 'tho');

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `webcal_user_layers`
--

DROP TABLE IF EXISTS `webcal_user_layers`;
CREATE TABLE `webcal_user_layers` (
  `cal_layerid` int(11) NOT NULL DEFAULT '0',
  `cal_login` varchar(25) NOT NULL,
  `cal_layeruser` varchar(25) NOT NULL,
  `cal_color` varchar(25) DEFAULT NULL,
  `cal_dups` char(1) DEFAULT 'N',
  PRIMARY KEY (`cal_login`,`cal_layeruser`)
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
  `cal_value` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`cal_login`,`cal_setting`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Data dump for tabellen `webcal_user_pref`
--

INSERT INTO `webcal_user_pref` (`cal_login`, `cal_setting`, `cal_value`) VALUES
('admin', 'LANGUAGE', 'English-US'),
('Louise', 'LANGUAGE', 'Danish'),
('rht', 'LANGUAGE', 'English-US'),
('Richardt_Thomsen', 'LANGUAGE', 'Danish'),
('testhjaelper', 'LANGUAGE', 'Danish'),
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
  PRIMARY KEY (`cal_login`,`cal_type`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Data dump for tabellen `webcal_user_template`
--

INSERT INTO `webcal_user_template` (`cal_login`, `cal_type`, `cal_template_text`) VALUES
('__system__', 'T', '');

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `webcal_view`
--

DROP TABLE IF EXISTS `webcal_view`;
CREATE TABLE `webcal_view` (
  `cal_view_id` int(11) NOT NULL,
  `cal_owner` varchar(25) NOT NULL,
  `cal_name` varchar(50) NOT NULL,
  `cal_view_type` char(1) DEFAULT NULL,
  `cal_is_global` char(1) NOT NULL DEFAULT 'N',
  PRIMARY KEY (`cal_view_id`)
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
  PRIMARY KEY (`cal_view_id`,`cal_login`)
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
