INSERT INTO `site` (`id`, `name`, `def_date`, `def_user`, `upd_date`, `upd_user`) VALUES
(2, 'Test SEE20:10', '2009-09-28 09:28:46', NULL, '2009-09-28 09:28:46', NULL);

INSERT INTO `webcal_config` (`cal_setting`, `cal_value`, `site_id`) VALUES
('JC_MAIL', 'tho@thodata.dk', 2),
('JC_MAIL_FROM', 'TEST Jobcenter', 2);

INSERT INTO `webcal_user` (`cal_login`, `cal_passwd`, `cal_lastname`, `cal_firstname`, `cal_is_admin`, `cal_email`, `cal_enabled`, `cal_telephone`, `cal_address`, `cal_title`, `cal_birthday`, `cal_last_login`, `role_id`, `site_id`, `group_id`, `count`, `age_range`, `qualifications`, `notes`, `ext_login`, `def_date`, `def_user`, `upd_date`, `upd_user`) VALUES
('testbothygesen', '098f6bcd4621d373cade4e832627b4f6', 'Thygesen', 'Bo', 'N', 'thyges@teknik.dk', 'Y', '40824872', 'Niels Kjeldsens vej 14, 7500 Holstebro', '', NULL, NULL, 4, 2, 0, 1, '36', '', '', '', '2009-09-12 01:22:14', 'tho', '2009-09-14 01:39:38', 'bothygesen'),
('testhekjje', '098f6bcd4621d373cade4e832627b4f6', 'Jepsen', 'Henrik', 'N', 'hekjje@hekjje.dk', 'Y', '23672939', 'Villestoftehaven 51, 5210 Odense NV', '', NULL, NULL, 4, 2, 0, 1, '1', '', '', '', '2009-09-12 01:08:38', 'tho', '2009-09-12 01:08:38', 'tho'),
('testhellesoee', '098f6bcd4621d373cade4e832627b4f6', 'Hellesøe', 'Claus', 'N', 'Claus@hellesoee.dk', 'Y', '97534225', 'Vejlgårdvej 20, 7800 Skive', '', NULL, NULL, 4, 2, 0, 1, '1', '', '', '', '2009-09-12 01:06:52', 'tho', '2009-09-12 01:06:52', 'tho'),
('testireneschmidt', '098f6bcd4621d373cade4e832627b4f6', 'Schmidt', 'Irene', 'N', 'Fam.schmidt@sport.dk', 'Y', '00000000', 'abcd', '', NULL, NULL, 4, 2, 0, 1, '1', '', '', '', '2009-09-12 01:17:42', 'tho', '2009-09-12 01:17:42', 'tho'),
('testjakobbang', '098f6bcd4621d373cade4e832627b4f6', 'A. Bang', 'Jakob', 'N', 'Jakob@spejdernet.dk', 'Y', '26532151', 'Fredensgade 13,2 – 211, 6000 Kolding', '', NULL, NULL, 4, 2, 0, 1, '1', '', '', '', '2009-09-12 01:20:22', 'tho', '2009-09-12 01:20:22', 'tho'),
('testmogensbahnsen', '098f6bcd4621d373cade4e832627b4f6', 'Bahnsen', 'Mogens', 'N', 'Mogens.Bahnsen@kfumscout.dk', 'Y', '23286288', 'Bissensvej 32, 7000 Fredericia', '', NULL, NULL, 4, 1, 0, 1, '1', '', '', '', '2009-09-12 01:16:32', 'tho', '2009-09-12 01:16:32', 'tho'),
('testpovledvard', '098f6bcd4621d373cade4e832627b4f6', 'Edvard Hansen', 'Povl', 'N', 'povledvard@email.dk', 'Y', '40210940', 'abcd', '', NULL, NULL, 4, 2, 0, 1, '1', '', '', NULL, '2009-09-12 01:10:00', NULL, '2009-09-12 01:10:00', NULL),
('testtommystub', '098f6bcd4621d373cade4e832627b4f6', 'Stub', 'Tommy', 'N', 'tommystub@spejdernet.dk', 'Y', '20168145', 'Linkenkærsvej 8, 5700 Svendborg', '', NULL, NULL, 4, 2, 0, 1, '1', '', '', 'tommystub', '2009-09-15 22:44:38', 'tho', '2009-09-15 22:44:38', 'tho'),
('testuffeebenau', '098f6bcd4621d373cade4e832627b4f6', 'Ebenau', 'Uffe', 'N', 'uffeebenau@spejdernet.dk', 'Y', '23868653', 'Dydyrvej 28, 4623 Lille-Skensved', '', NULL, NULL, 4, 2, 0, 1, '1', '', '', 'uffeebenau', '2009-09-12 01:13:08', 'tho', '2009-09-12 01:13:08', 'tho')
;

INSERT INTO `subcamp` (`id`, `site_id`, `name`, `contact_id`, `def_date`, `def_user`, `upd_date`, `upd_user`) VALUES
(21, 2, 'TLuppen', 'testpovledvard', '2009-09-12 01:28:16', NULL, '2009-09-12 01:28:16', NULL),
(22, 2, 'TDråben', 'testhellesoee', '2009-09-12 01:28:16', NULL, '2009-09-12 01:28:16', NULL),
(23, 2, 'Tniverset', 'testhekjje', '2009-09-12 01:28:16', NULL, '2009-09-12 01:28:16', NULL),
(24, 2, 'TSolsikken', 'testuffeebenau', '2009-09-12 01:28:16', NULL, '2009-09-12 01:28:16', NULL),
(25, 2, 'TGloben', 'testmogensbahnsen', '2009-09-12 01:28:16', NULL, '2009-09-12 01:28:16', NULL),
(26, 2, 'TSymfonien', 'testireneschmidt', '2009-09-12 01:28:16', NULL, '2009-09-12 01:28:16', NULL),
(27, 2, 'TLanternen', 'testjakobbang', '2009-09-12 01:28:16', NULL, '2009-09-12 01:28:16', NULL),
(28, 2, 'TSludderen', 'testbothygesen', '2009-09-12 01:28:16', NULL, '2009-09-12 01:28:16', NULL),
(29, 2, 'TFarveladen', NULL, NULL, NULL, '0000-00-00 00:00:00', NULL);

INSERT INTO `area` (`id`, `site_id`, `name`, `description`, `contact_id`, `def_date`, `def_user`, `upd_date`, `upd_user`) VALUES
(21, 2, 'TDOT', 'TDrift og teknik', 'tho', '2009-09-12 01:51:53', NULL, '2009-09-12 01:51:53', NULL),
(22, 2, 'TAKT', 'TAktiviteter', 'tho', '2009-09-12 01:51:53', NULL, '2009-09-12 01:51:53', NULL),
(23, 2, 'TKLU', 'TKorpslejrudvalget', 'tho', '2009-09-12 01:53:21', NULL, '2009-09-12 01:53:21', NULL),
(24, 2, 'TINT', 'Tnternational', 'tho', '2009-09-12 01:51:53', NULL, '2009-09-12 01:51:53', NULL),
(25, 2, 'TKUL', 'TKultur', 'tho', '2009-09-12 01:51:53', NULL, '2009-09-12 01:51:53', NULL),
(26, 2, 'TLT', 'TLandstræf', 'tho', '2009-09-12 01:51:53', NULL, '2009-09-12 01:51:53', NULL),
(27, 2, 'TØKO', 'TØkonomi', 'tho', '2009-09-12 01:51:53', NULL, '2009-09-12 01:51:53', NULL),
(28, 2, 'TINF', 'TInfrastruktur', 'tho', '2009-09-12 01:51:53', NULL, '2009-09-12 01:51:53', NULL),
(29, 2, 'TPR', 'TPR og kommunikation', 'tho', '2009-09-12 01:51:53', NULL, '2009-09-12 01:51:53', NULL);

INSERT INTO `days` (`id`, `site_id`, `date`, `time`, `def_date`, `def_user`, `upd_date`, `upd_user`) VALUES
(21, 2, '2009-07-24', 120000, NULL, NULL, '0000-00-00 00:00:00', NULL),
(22, 2, '2009-07-25', NULL, NULL, NULL, '0000-00-00 00:00:00', NULL),
(23, 2, '2009-07-26', NULL, NULL, NULL, '0000-00-00 00:00:00', NULL),
(24, 2, '2009-07-27', NULL, NULL, NULL, '0000-00-00 00:00:00', NULL),
(25, 2, '2009-07-28', NULL, NULL, NULL, '0000-00-00 00:00:00', NULL),
(26, 2, '2009-07-29', NULL, NULL, NULL, '0000-00-00 00:00:00', NULL),
(27, 2, '2009-07-30', NULL, NULL, NULL, '0000-00-00 00:00:00', NULL),
(28, 2, '2009-07-31', NULL, NULL, NULL, '0000-00-00 00:00:00', NULL),
(29, 2, '2009-08-01', 160000, NULL, NULL, '0000-00-00 00:00:00', NULL);

INSERT INTO `district` (`id`, `site_id`, `name`, `subcamp_id`, `def_date`, `def_user`, `upd_date`, `upd_user`) VALUES
(91, 2, 'TAalborg Distrikt', 28, NULL, NULL, '0000-00-00 00:00:00', NULL),
(92, 2, 'TAggersborg Distrikt', 24, NULL, NULL, '0000-00-00 00:00:00', NULL),
(93, 2, 'TBastrup Distrikt', 23, NULL, NULL, '0000-00-00 00:00:00', NULL);

INSERT INTO `group` (`id`, `site_id`, `name`, `district_id`, `tmp_district_name`, `def_date`, `def_user`, `upd_date`, `upd_user`) VALUES
(20000, 2, 'T- Ingen', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', NULL),
(20001, 2, 'Test Gruppe 1', 91, '', NULL, NULL, '0000-00-00 00:00:00', NULL),
(20002, 2, 'Test Gruppe 2', 92, '', NULL, NULL, '0000-00-00 00:00:00', NULL),
(20003, 2, 'Test Gruppe 3', 93, '', NULL, NULL, '0000-00-00 00:00:00', NULL);

INSERT INTO `jobcategory` (`id`, `name`, `site_id`, `def_date`, `def_user`, `upd_date`, `upd_user`) VALUES
(21, 'TAktivitet', 2, NULL, NULL, '0000-00-00 00:00:00', NULL),
(22, 'TVagt', 2, NULL, NULL, '0000-00-00 00:00:00', NULL),
(23, 'TForsyning', 2, NULL, NULL, '0000-00-00 00:00:00', NULL),
(24, 'THandyman', 2, NULL, NULL, '0000-00-00 00:00:00', NULL);

INSERT INTO `qualification` (`id`, `name`, `site_id`, `def_date`, `def_user`, `upd_date`, `upd_user`) VALUES
(201, 'TMotorsav', 2, NULL, NULL, '0000-00-00 00:00:00', NULL),
(202, 'TKørekort B', 2, NULL, NULL, '0000-00-00 00:00:00', NULL),
(203, 'TStort kørekort', 2, NULL, NULL, '0000-00-00 00:00:00', NULL),
(204, 'Tygiejnekursus', 2, NULL, NULL, '0000-00-00 00:00:00', NULL),
(205, 'TStorkøkken', 2, NULL, NULL, '0000-00-00 00:00:00', NULL),
(206, 'TVVS', 2, NULL, NULL, '0000-00-00 00:00:00', NULL),
(207, 'TElektriker', 2, NULL, NULL, '0000-00-00 00:00:00', NULL),
(208, 'TTømrer', 2, NULL, NULL, '0000-00-00 00:00:00', NULL),
(209, 'TSygeplejerske', 2, NULL, NULL, '0000-00-00 00:00:00', NULL),
(210, 'TIT', 2, NULL, NULL, '0000-00-00 00:00:00', NULL),
(211, 'TKontorarbejde', 2, NULL, NULL, '0000-00-00 00:00:00', NULL),
(212, 'TTruck-certifikat', 2, NULL, NULL, '0000-00-00 00:00:00', NULL);
