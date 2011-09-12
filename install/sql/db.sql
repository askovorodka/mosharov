CREATE TABLE `fw_conf` (`conf_key` varchar(50) NOT NULL default '',`conf_value` varchar(255) NOT NULL default '',`name` varchar(255) NOT NULL default '',`section` varchar(20) NOT NULL default '',`section_name` varchar(30) NOT NULL default '');
INSERT INTO `fw_conf` VALUES ('LOGIN_LIFETIME', '86400', '����� ����� ������', 'global', '����������');
INSERT INTO `fw_conf` VALUES ('USERS_PER_PAGE', '30', '������������� �� ��������', 'users', '������������');
INSERT INTO `fw_conf` VALUES ('PAGES_PER_PAGE', '30', '���������� �� ��������', 'pages', '���������');
INSERT INTO `fw_conf` VALUES ('DEFAULT_URL', 'home', '��� �� ���������', 'site', '����');
INSERT INTO `fw_conf` VALUES ('SMARTY_DEBUGGING_SITE', 'false', '�������� Smarty', 'site', '����');
CREATE TABLE `fw_modules` (`id` tinyint(10) unsigned NOT NULL auto_increment,`name` varchar(20) NOT NULL default '',`title` varchar(20) NOT NULL default '',`section` varchar(20) NOT NULL default '',`priv` tinyint(10) NOT NULL default '1',`default_load` enum('0','1') NOT NULL default '0',`status` enum('0','1') NOT NULL default '1',PRIMARY KEY  (`id`));
INSERT INTO `fw_modules` VALUES (1, 'tree', '��������� �����', 'admin_main', 1, '0', '1');
INSERT INTO `fw_modules` VALUES (2, 'folder', '�����', 'front_main', 1, '0', '1');
INSERT INTO `fw_modules` VALUES (3, 'users', '������������', 'admin_main', 1, '0', '1');
INSERT INTO `fw_modules` VALUES (4, 'pages', '��������', 'admin_main', 1, '0', '1');
INSERT INTO `fw_modules` VALUES (9, 'modules', '������', 'admin_main', 1, '0', '1');
INSERT INTO `fw_modules` VALUES (10, 'edit_conf', '�������� ��������', 'admin_main', 1, '0', '1');
CREATE TABLE `fw_pages` (`id` tinyint(11) unsigned NOT NULL auto_increment,`parent` tinyint(11) unsigned NOT NULL default '0',`name` varchar(255) NOT NULL default '',`title` varchar(255) NOT NULL default '',`url` varchar(50) NOT NULL default '',`text` text NOT NULL,`meta_keywords` varchar(255) NOT NULL default '',`meta_description` varchar(255) NOT NULL default '',`insert_date` int(15) unsigned NOT NULL default '0',`status` enum('0','1') NOT NULL default '0',PRIMARY KEY  (`id`));
INSERT INTO `fw_pages` VALUES (1, 2, '������� ��������', '������� ��������', 'home', '������� ��������', '', '', 0, '1');
CREATE TABLE `fw_tree` (`id` tinyint(10) unsigned NOT NULL auto_increment,`param_left` tinyint(10) unsigned NOT NULL default '0',`param_right` tinyint(10) unsigned NOT NULL default '0',`param_level` tinyint(10) unsigned NOT NULL default '0',`url` varchar(20) NOT NULL default '',`name` varchar(255) NOT NULL default '',`title` varchar(255) NOT NULL default '',`text` text NOT NULL,`meta_keywords` varchar(255) NOT NULL default '',`meta_description` varchar(255) NOT NULL default '',`module` varchar(50) NOT NULL default '',`support_modules` varchar(255) NOT NULL default '',`elements` text NOT NULL,`status` enum('0','1') NOT NULL default '1',`in_menu` enum('0','1') NOT NULL default '1',PRIMARY KEY  (`id`));
CREATE TABLE `fw_users` (`id` tinyint(10) unsigned NOT NULL auto_increment,`login` varchar(50) NOT NULL default '',`password` varchar(32) NOT NULL default '',`name` varchar(100) NOT NULL default '',`mail` varchar(50) NOT NULL default '',`tel` varchar(20) NOT NULL default '',`deliver` text NOT NULL,`reg_date` int(15) NOT NULL default '0',`priv` tinyint(2) NOT NULL default '0',`status` enum('0','1') NOT NULL default '0',PRIMARY KEY  (`id`));