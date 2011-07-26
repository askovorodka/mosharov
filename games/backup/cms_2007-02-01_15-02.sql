#SKD101|cms|38|2007.02.01 15:02:48|313|2|13|2|4|1|1|52|2|8|3|2|2|19|1|1|21|22|8|5|1|9|127|2|5

DROP TABLE IF EXISTS fw_banners;
CREATE TABLE `fw_banners` (
  `id` int(15) unsigned NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `image` varchar(4) NOT NULL default '',
  `type` enum('0','1') NOT NULL default '0',
  `target_url` varchar(100) NOT NULL default '',
  `showings` int(15) unsigned NOT NULL default '0',
  `start_date` int(15) unsigned NOT NULL default '0',
  `end_date` int(15) unsigned NOT NULL default '0',
  `group` int(15) unsigned NOT NULL default '0',
  `status` enum('0','1') NOT NULL default '0',
  `shown` int(15) unsigned NOT NULL default '0',
  `clicks` int(15) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB /*!40101 DEFAULT CHARSET=cp1251 */;

INSERT INTO `fw_banners` VALUES
(1, '�������� ������', 'jpg', '0', 'http://ya.ru', 500, 1167598800, 1169154000, 1, '1', 50, 4),
(2, '�������� ������ 2', 'jpg', '0', 'http://rambler.ru', 1000, 0, 0, 2, '1', 38, 2);

DROP TABLE IF EXISTS fw_banners_cat;
CREATE TABLE `fw_banners_cat` (
  `banner_id` int(11) NOT NULL default '0',
  `url` text NOT NULL
) ENGINE=InnoDB /*!40101 DEFAULT CHARSET=cp1251 */;

INSERT INTO `fw_banners_cat` VALUES
(2, '/shop/'),
(2, '/shop/test1/'),
(2, '/shop/test1/sdf/'),
(1, '/home/'),
(1, '/home/dsfsd/'),
(1, '/users/'),
(1, '/users/login/'),
(1, '/users/register/'),
(1, '/users/logout/'),
(1, '/shop/test1/'),
(1, '/shop/test1/sdf/'),
(1, '/news/'),
(1, '/news/archive/4/');

DROP TABLE IF EXISTS fw_banners_groups;
CREATE TABLE `fw_banners_groups` (
  `id` int(15) unsigned NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB /*!40101 DEFAULT CHARSET=cp1251 */;

INSERT INTO `fw_banners_groups` VALUES
(1, '�������� ������ 1'),
(2, '�������� ������ 2');

DROP TABLE IF EXISTS fw_catalogue;
CREATE TABLE `fw_catalogue` (
  `id` tinyint(10) unsigned NOT NULL auto_increment,
  `param_left` tinyint(10) unsigned NOT NULL default '0',
  `param_right` tinyint(10) unsigned NOT NULL default '0',
  `param_level` tinyint(10) unsigned NOT NULL default '0',
  `url` varchar(20) NOT NULL default '',
  `name` varchar(255) NOT NULL default '',
  `text` text NOT NULL,
  `title` varchar(255) NOT NULL default '',
  `image` varchar(50) NOT NULL default '',
  `meta_keywords` varchar(255) NOT NULL default '',
  `meta_description` varchar(255) NOT NULL default '',
  `status` enum('0','1') NOT NULL default '1',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB /*!40101 DEFAULT CHARSET=cp1251 */;

INSERT INTO `fw_catalogue` VALUES
(1, 1, 8, 0, '/', '/', '', '', '', '', '', '1'),
(2, 2, 5, 1, 'test1', '�������� ������ 1', '', '', '', '', '', '1'),
(3, 6, 7, 1, 'test2', '�������� ������ 2', '', '', '', '', '', '1'),
(4, 3, 4, 2, 'sdf', 'sdf', '', '', '', '', '', '1');

DROP TABLE IF EXISTS fw_catalogue_properties;
CREATE TABLE `fw_catalogue_properties` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `type` enum('0','1','2') NOT NULL default '0',
  `elements` text NOT NULL,
  `status` enum('0','1') NOT NULL default '1',
  KEY `id` (`id`)
) ENGINE=InnoDB /*!40101 DEFAULT CHARSET=cp1251 */;

INSERT INTO `fw_catalogue_properties` VALUES
(1, 'dsfsdf', '2', '', '1');

DROP TABLE IF EXISTS fw_catalogue_relations;
CREATE TABLE `fw_catalogue_relations` (
  `cat_id` int(11) NOT NULL default '0',
  `property_id` int(11) NOT NULL default '0',
  `sort_order` int(10) NOT NULL default '0'
) ENGINE=InnoDB /*!40101 DEFAULT CHARSET=cp1251 */;

INSERT INTO `fw_catalogue_relations` VALUES
(2, 1, 0);

DROP TABLE IF EXISTS fw_conf;
CREATE TABLE `fw_conf` (
  `conf_key` varchar(50) NOT NULL default '',
  `conf_value` varchar(255) NOT NULL default '',
  `name` varchar(255) NOT NULL default '',
  `section` varchar(20) NOT NULL default '',
  `section_name` varchar(30) NOT NULL default ''
) ENGINE=InnoDB /*!40101 DEFAULT CHARSET=cp1251 */;

INSERT INTO `fw_conf` VALUES
('LOGIN_LIFETIME', '86400', '����� ����� ������', 'global', '����������'),
('USERS_PER_PAGE', '30', '������������� �� �������', 'users', '������������'),
('PAGES_PER_PAGE', '30', '������� � ������', 'pages', '��������'),
('DEFAULT_URL', 'home', '��� �� ���������', 'front', '����'),
('SMARTY_DEBUGGING_SITE', 'false', '������� Smarty', 'front', '����'),
('NEWS_PER_PAGE_FRONT', '5', '�������� �� �������� (����)', 'front', '����'),
('PRODUCTS_PER_PAGE', '30', '��������� �� ��������', 'shop', '�������'),
('PRODUCT_GENERATE_PREVIEW', 'on', '�������������� ��������� preview', 'shop', '�������'),
('DEFAULT_CURRENCY', '���.', '�������� �������', 'shop', '�������'),
('NEWS_PER_PAGE', '30', '�������� �� �������� (�������)', 'news', '�������'),
('NEWS_PER_PAGE_FRONT_ARCHIVE', '10', '�������� �� �������� ������', 'news', '�������'),
('PRODUCTS_PER_PAGE_FRONT', '15', '��������� �� �������� (����)', 'shop', '�������'),
('SEARCH_RESULTS_PER_PAGE', '15', '����������� ������ �� ��������', 'shop', '�������'),
('POLLS_PER_PAGE', '30', '������� �� ��������', 'poll', '������'),
('NEWS_IMAGE_WIDTH', '100', '������ ������', 'news', '�������'),
('ALBUMS_PER_PAGE', '30', '�������� �� ��������', 'photoalbum', '����������'),
('PREVIEW1_WIDTH', '100', '������ ���������� ������', 'photoalbum', '����������'),
('PREVIEW2_WIDTH', '400', '������ �������� ������', 'photoalbum', '����������'),
('PHOTO_MAX_SIZE', '1600x1200', '������������ ������ ����������', 'photoalbum', '����������'),
('ALLOWED_FORMATS', 'gif,jpeg,png', '����������� �������', 'photoalbum', '����������'),
('PHOTOS_FOLDER', 'uploaded_files/photos', '����� ����������', 'photoalbum', '����������'),
('PHOTO_MAX_FILESIZE', '2000', '������������ ��� ���������� (��)', 'photoalbum', '����������'),
('PHOTOS_PER_PAGE', '12', '���������� �� �������� �������', 'photoalbum', '����������'),
('SEND_ORDER_TO', 'lex@fastweb.ru', '����� ��� ����������� � ������', 'shop', '�������'),
('ADMIN_MAIL', 'lex@fastweb.ru', '����� �������������� �����', 'global', '����������'),
('PREVIEW1_HEIGTH', '100', '������ ���������� ������', 'photoalbum', '����������'),
('PREVIEW2_HEIGTH', '400', '������ �������� ������', 'photoalbum', '����������'),
('PRODUCT_PREVIEW_WIDTH', '100', '������ ������ ��������', 'shop', '�������'),
('PRODUCT_PREVIEW_HEIGHT', '100', '������ ������ ��������', 'shop', '�������'),
('PHOTOS_PER_PAGE_SUP', '15', '���������� �� �������� ������� ���������', 'photoalbum', '����������'),
('PHOTOALBUM_MODE', 'full', '����� �����������', 'photoalbum', '����������'),
('BASE_URL', 'http://cms', '��� �����', 'global', '����������'),
('BASE_PATH', 'd:/home/cms', '���� � �������', 'global', '����������'),
('SCRIPT_FOLDER', '', '����� �������', 'global', '����������'),
('THREADS_PER_PAGE', '50', '��� �� �������', 'forum', '�����'),
('RESULTS_PER_PAGE', '5', '����������� �� �������', 'search', '�����'),
('POSTS_PER_PAGE', '20', '��������� �� ��������', 'forum', '�����'),
('SUBSCRIBE_ENCODING', 'Windows-1251', '��������� ���������', 'subscribe', '��������'),
('SUBSCRIBE_TRANSPORT_METHOD', 'standard', '����� �������� �����', 'subscribe', '��������'),
('CONFIRM_SUBSCRIPTION', 'yes', '������������� �������� �� �����', 'subscribe', '��������'),
('GB_MESSAGES_PER_PAGE', '10', '��������� �� ��������', 'guestbook', '�������� �����'),
('GB_PREMODERATION', 'on', '������������ ���������', 'guestbook', '�������� �����'),
('PHOTOALBUM_COMMENTS_PER_PAGE', '20', '������������ �� ��������', 'photoalbum', '����������'),
('PRODUCT_RATING', 'on', '������� ���������', 'shop', '�������'),
('PRODUCT_COMMENTS', 'on', '����������� ���������', 'shop', '�������'),
('PRODUCT_COMMENTS_PER_PAGE', '10', '������������ �� ��������', 'shop', '�������'),
('EDITOR_MODE', 'html_', '����� ���������', 'admin', '����������������� ������'),
('RSS_SHOW', 'true', '����������� RSS ��������', 'admin', '����������������� ������'),
('RSS_URL', '', 'URL ��������', 'admin', '����������������� ������'),
('FORUM_PREMODERATION', 'off', '������������ ���������', 'forum', '�����'),
('BANNERS_PER_PAGE', '20', '�������� �� ��������', 'banners', '�������'),
('CURRENCY_RATE', '29.4', '���� ������', 'shop', '�������');

DROP TABLE IF EXISTS fw_forms;
CREATE TABLE `fw_forms` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `email` varchar(255) NOT NULL default '',
  `status` enum('0','1') NOT NULL default '1',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB /*!40101 DEFAULT CHARSET=cp1251 */;

INSERT INTO `fw_forms` VALUES
(1, '��������������', 'neon.lexx@mail.ru', '1'),
(3, 'asdfsdfdsfs', 'asdasdassdfds', '0');

DROP TABLE IF EXISTS fw_forms_elements;
CREATE TABLE `fw_forms_elements` (
  `id` int(11) NOT NULL auto_increment,
  `parent` int(11) NOT NULL default '0',
  `name` varchar(255) NOT NULL default '',
  `type` tinyint(4) NOT NULL default '0',
  `value` text NOT NULL,
  `sort_order` int(11) NOT NULL default '0',
  `status` enum('0','1') NOT NULL default '1',
  PRIMARY KEY  (`id`),
  KEY `parent` (`parent`)
) ENGINE=InnoDB /*!40101 DEFAULT CHARSET=cp1251 */;

INSERT INTO `fw_forms_elements` VALUES
(1, 1, '*�������:*', 1, '', 2, '1'),
(2, 1, '*��� � �������:*', 1, '', 1, '1'),
(3, 1, '*E-mail:*', 1, 'aasd\r\nasdasd\r\n*asdasdas\r\ndas', 3, '1'),
(4, 1, '���� ������ � ������� ������ ������, ����������� ���� (���� ����):', 2, '', 5, '1'),
(5, 1, '���� ���������:', 2, '', 6, '1'),
(18, 1, '*������ ��� ����������:*', 0, '', 4, '1'),
(19, 1, '*��� ������:*', 3, '������ �������\r\n������ �������\r\n*�������� ������ �������*\r\n�������� �������\r\n����� �������', 7, '1'),
(20, 1, '����', 3, '��\r\n*���*', 8, '0');

DROP TABLE IF EXISTS fw_forum_posts;
CREATE TABLE `fw_forum_posts` (
  `id` int(11) NOT NULL auto_increment,
  `parent` int(11) NOT NULL default '0',
  `author` varchar(100) NOT NULL default '0',
  `text` text NOT NULL,
  `publish_date` int(15) NOT NULL default '0',
  `status` enum('1','0') NOT NULL default '1',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB /*!40101 DEFAULT CHARSET=cp1251 */;

INSERT INTO `fw_forum_posts` VALUES
(1, 1, '1', 'werewrwerer', 1157538991, '1'),
(2, 1, '1', 'uiouiouio', 1157539047, '1'),
(3, 2, 'rtytytr', 'rtytryrty', 1158217014, '1');

DROP TABLE IF EXISTS fw_forum_threads;
CREATE TABLE `fw_forum_threads` (
  `id` int(11) NOT NULL auto_increment,
  `parent` int(11) NOT NULL default '0',
  `title` varchar(255) NOT NULL default '',
  `status` enum('1','0') NOT NULL default '1',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB /*!40101 DEFAULT CHARSET=cp1251 */;

INSERT INTO `fw_forum_threads` VALUES
(1, 2, 'erwer', '1'),
(2, 2, 'yrtyrtyrtyr', '1');

DROP TABLE IF EXISTS fw_forum_vp;
CREATE TABLE `fw_forum_vp` (
  `user_id` int(11) NOT NULL default '0',
  `thread_id` int(11) NOT NULL default '0',
  `forum_id` int(11) NOT NULL default '0',
  `view_time` int(15) NOT NULL default '0'
) ENGINE=MyISAM /*!40101 DEFAULT CHARSET=cp1251 */;

DROP TABLE IF EXISTS fw_forums;
CREATE TABLE `fw_forums` (
  `id` tinyint(10) unsigned NOT NULL auto_increment,
  `param_left` tinyint(10) unsigned NOT NULL default '0',
  `param_right` tinyint(10) unsigned NOT NULL default '0',
  `param_level` tinyint(10) unsigned NOT NULL default '0',
  `url` varchar(20) NOT NULL default '',
  `name` varchar(255) NOT NULL default '',
  `title` varchar(255) NOT NULL default '',
  `read_users` text NOT NULL,
  `write_users` text NOT NULL,
  `status` enum('0','1') NOT NULL default '1',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB /*!40101 DEFAULT CHARSET=cp1251 */;

INSERT INTO `fw_forums` VALUES
(1, 1, 4, 0, '/', '/', '', 'all', 'all', '1'),
(2, 2, 3, 1, 'forum', '�������� �����', '', 'all', 'all', '1');

DROP TABLE IF EXISTS fw_guestbook;
CREATE TABLE `fw_guestbook` (
  `id` int(11) NOT NULL auto_increment,
  `author` varchar(255) NOT NULL default '',
  `message` text NOT NULL,
  `answer` text NOT NULL,
  `insert_date` int(15) NOT NULL default '0',
  `author_mail` varchar(255) NOT NULL default '',
  `status` enum('0','1') NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB /*!40101 DEFAULT CHARSET=cp1251 */;

DROP TABLE IF EXISTS fw_modules;
CREATE TABLE `fw_modules` (
  `id` tinyint(10) unsigned NOT NULL auto_increment,
  `name` varchar(20) NOT NULL default '',
  `title` varchar(20) NOT NULL default '',
  `section` varchar(20) NOT NULL default '',
  `priv` tinyint(10) NOT NULL default '1',
  `default_load` enum('0','1') NOT NULL default '0',
  `status` enum('0','1') NOT NULL default '1',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB /*!40101 DEFAULT CHARSET=cp1251 */;

INSERT INTO `fw_modules` VALUES
(1, 'tree', '��������� �����', 'admin_main', 1, '0', '1'),
(3, 'users', '������������', 'admin_main', 1, '0', '1'),
(4, 'page', '��������', 'front_main', 1, '0', '1'),
(5, 'cabinet', '������ �������', 'front_additional', 1, '0', '1'),
(6, 'file_manager', '���������� �������', 'admin_additional', 0, '0', '1'),
(7, 'news', '�������', 'front_support', 1, '1', '1'),
(8, 'shop', '�������', 'front_additional', 1, '1', '1'),
(9, 'modules', '������', 'admin_main', 1, '0', '1'),
(10, 'edit_conf', '�������� ��������', 'admin_main', 0, '0', '1'),
(11, 'polls', '������', 'front_support', 1, '0', '1'),
(12, 'photoalbum', '����������', 'front_support', 1, '0', '1'),
(13, 'forum', '�����', 'front_additional', 1, '0', '1'),
(14, 'search', '�����', 'front_additional', 1, '0', '1'),
(15, 'subscribe', '��������', 'front_additional', 1, '0', '1'),
(16, 'guestbook', '�������� �����', 'front_additional', 1, '0', '1'),
(17, 'tables', '�������', 'front_support', 1, '0', '1'),
(18, 'site_map', '����� �����', 'front_main', 1, '0', '1'),
(19, 'forms', '����� ��������', 'front_support', 1, '0', '1'),
(20, 'banners', '�������', 'front_additional', 1, '1', '1');

DROP TABLE IF EXISTS fw_news;
CREATE TABLE `fw_news` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `title` varchar(255) NOT NULL default '',
  `small_text` text NOT NULL,
  `text` text NOT NULL,
  `publish_date` int(15) NOT NULL default '0',
  `image` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB /*!40101 DEFAULT CHARSET=cp1251 */;

INSERT INTO `fw_news` VALUES
(4, 'fghfg', 'hfghfghfgh', '<P>hfghfghfgh</P>', 1158845760, '');

DROP TABLE IF EXISTS fw_orders;
CREATE TABLE `fw_orders` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `user` int(11) unsigned NOT NULL default '0',
  `name` varchar(50) NOT NULL default '',
  `mail` varchar(50) NOT NULL default '',
  `tel` varchar(50) NOT NULL default '',
  `deliver` text NOT NULL,
  `comments` text NOT NULL,
  `products` text NOT NULL,
  `total_price` decimal(10,2) NOT NULL default '0.00',
  `insert_date` int(15) unsigned NOT NULL default '0',
  `status` tinyint(5) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB /*!40101 DEFAULT CHARSET=cp1251 */;

DROP TABLE IF EXISTS fw_photoalbum_cat;
CREATE TABLE `fw_photoalbum_cat` (
  `id` tinyint(10) unsigned NOT NULL auto_increment,
  `param_left` tinyint(10) unsigned NOT NULL default '0',
  `param_right` tinyint(10) unsigned NOT NULL default '0',
  `param_level` tinyint(10) unsigned NOT NULL default '0',
  `url` varchar(20) NOT NULL default '',
  `name` varchar(255) NOT NULL default '',
  `title` varchar(255) NOT NULL default '',
  `meta_keywords` varchar(255) NOT NULL default '',
  `meta_description` varchar(255) NOT NULL default '',
  `status` enum('0','1') NOT NULL default '1',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB /*!40101 DEFAULT CHARSET=cp1251 */;

INSERT INTO `fw_photoalbum_cat` VALUES
(1, 1, 2, 0, '/', '/', '', '', '', '1');

DROP TABLE IF EXISTS fw_photoalbum_comments;
CREATE TABLE `fw_photoalbum_comments` (
  `id` int(11) NOT NULL auto_increment,
  `photo_id` int(11) NOT NULL default '0',
  `author` varchar(255) NOT NULL default '',
  `comment` text NOT NULL,
  `insert_date` int(15) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB /*!40101 DEFAULT CHARSET=cp1251 */;

DROP TABLE IF EXISTS fw_photoalbum_images;
CREATE TABLE `fw_photoalbum_images` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `parent` int(11) unsigned NOT NULL default '0',
  `ext` char(3) NOT NULL default '',
  `title` varchar(255) NOT NULL default '',
  `link` varchar(60) NOT NULL default '',
  `insert_date` int(15) NOT NULL default '0',
  `sort_order` smallint(5) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB /*!40101 DEFAULT CHARSET=cp1251 */;

DROP TABLE IF EXISTS fw_photoalbums;
CREATE TABLE `fw_photoalbums` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `parent` int(11) unsigned NOT NULL default '0',
  `name` varchar(255) NOT NULL default '',
  `title` varchar(255) NOT NULL default '',
  `description` text NOT NULL,
  `meta_keywords` varchar(255) NOT NULL default '',
  `meta_description` varchar(255) NOT NULL default '',
  `insert_date` int(15) unsigned NOT NULL default '0',
  `switch_comments` enum('0','1') NOT NULL default '1',
  `status` enum('0','1') NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB /*!40101 DEFAULT CHARSET=cp1251 */;

DROP TABLE IF EXISTS fw_polls;
CREATE TABLE `fw_polls` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `name` varchar(100) NOT NULL default '',
  `publish_date` int(15) NOT NULL default '0',
  `finish_date` int(15) NOT NULL default '0',
  `status` enum('0','1','2') NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB /*!40101 DEFAULT CHARSET=cp1251 */;

DROP TABLE IF EXISTS fw_polls_answers;
CREATE TABLE `fw_polls_answers` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `parent` int(15) unsigned NOT NULL default '0',
  `name` varchar(100) NOT NULL default '',
  `answers` int(5) NOT NULL default '0',
  `sort_order` tinyint(3) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB /*!40101 DEFAULT CHARSET=cp1251 */;

DROP TABLE IF EXISTS fw_products;
CREATE TABLE `fw_products` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `parent` int(11) unsigned NOT NULL default '0',
  `name` varchar(255) NOT NULL default '',
  `title` varchar(255) NOT NULL default '',
  `small_description` text NOT NULL,
  `description` text NOT NULL,
  `additional_products` varchar(255) NOT NULL default '',
  `price` decimal(10,2) NOT NULL default '0.00',
  `sale` tinyint(3) unsigned NOT NULL default '0',
  `rating` int(11) NOT NULL default '0',
  `insert_date` int(15) unsigned NOT NULL default '0',
  `status` enum('0','1') NOT NULL default '0',
  `sort_order` int(11) NOT NULL default '0',
  `hit` enum('0','1') NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB /*!40101 DEFAULT CHARSET=cp1251 */;

INSERT INTO `fw_products` VALUES
(3, 2, 'Product 3', '', '', '', '', '123.00', 0, 0, 1168515332, '1', 2, '0'),
(4, 2, 'Product 4', '', '', '', '', '123.00', 0, 0, 1168515332, '1', 3, '0'),
(5, 2, 'Product 5', '', '', '', '', '123.00', 0, 0, 1168515332, '1', 16, '0'),
(6, 2, 'Product 6', '', '', '', '', '123.00', 0, 0, 1168515332, '1', 4, '0'),
(7, 2, 'Product 7', '', '', ' asd asd asasd asd\r\n<br>\r\n\r\n<p>asdasdasd asd <b>asd</b> as</p>\r\n', '', '123.00', 0, 0, 1168515332, '1', 5, '0'),
(8, 2, 'Product 8', '', '', '', '', '123.00', 0, 0, 1168515332, '1', 7, '0'),
(9, 2, 'Product 9', '', '', '', '', '123.00', 0, 0, 1168515332, '1', 1, '0'),
(10, 2, 'Product 10', '', '', '', '', '123.00', 0, 0, 1168515332, '1', 8, '0'),
(11, 2, 'Product 11', '', '', '', '', '123.00', 0, 0, 1168515332, '1', 9, '0'),
(12, 2, 'Product 12', '', '', '', '', '123.00', 0, 0, 1168515332, '1', 10, '0'),
(13, 2, 'Product 13', '', '', '', '', '123.00', 0, 0, 1168515332, '1', 11, '0'),
(14, 2, 'Product 14', '', '', '', '', '123.00', 0, 0, 1168515332, '1', 12, '0'),
(15, 2, 'Product 15', '', '', '', '', '123.00', 0, 0, 1168515332, '1', 13, '0'),
(16, 2, 'Product 16', '', '', '', '', '123.00', 0, 0, 1168515332, '1', 14, '0'),
(17, 2, 'Product 17', '', '', '', '', '123.00', 0, 0, 1168515332, '1', 15, '0'),
(18, 2, 'Product 18', '', '', '', '', '123.00', 0, 0, 1168515332, '1', 17, '0'),
(19, 2, 'Product 19', '', '', '', '', '123.00', 0, 0, 1168515332, '1', 18, '0'),
(20, 2, 'Product 20', '', '', '', '', '123.00', 0, 0, 1168515332, '1', 19, '0'),
(21, 2, 'Product 21', '', '', '', '', '123.00', 0, 0, 1168515332, '1', 20, '0'),
(22, 2, 'Product 22', '', '', '', '', '123.00', 0, 0, 1168515332, '1', 6, '0'),
(23, 2, 'Product 23', '', '', '', '', '123.00', 0, 0, 1168515332, '1', 21, '0');

DROP TABLE IF EXISTS fw_products_comments;
CREATE TABLE `fw_products_comments` (
  `id` int(11) NOT NULL auto_increment,
  `product_id` int(11) NOT NULL default '0',
  `author` varchar(50) NOT NULL default '',
  `text` text NOT NULL,
  `insert_date` int(15) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB /*!40101 DEFAULT CHARSET=cp1251 */;

DROP TABLE IF EXISTS fw_products_images;
CREATE TABLE `fw_products_images` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `parent` int(11) unsigned NOT NULL default '0',
  `ext` varchar(4) NOT NULL default '',
  `title` varchar(255) NOT NULL default '',
  `link` varchar(60) NOT NULL default '',
  `sort_order` tinyint(5) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARSET=cp1251 */;

DROP TABLE IF EXISTS fw_products_properties;
CREATE TABLE `fw_products_properties` (
  `product_id` int(10) unsigned NOT NULL default '0',
  `property_id` int(10) unsigned NOT NULL default '0',
  `value` text NOT NULL,
  PRIMARY KEY  (`product_id`,`property_id`)
) ENGINE=InnoDB /*!40101 DEFAULT CHARSET=cp1251 */;

DROP TABLE IF EXISTS fw_search;
CREATE TABLE `fw_search` (
  `url` varchar(255) NOT NULL default '',
  `title` varchar(255) NOT NULL default '',
  `content` longtext NOT NULL,
  PRIMARY KEY  (`url`),
  FULLTEXT KEY `content` (`content`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARSET=cp1251 */;

INSERT INTO `fw_search` VALUES
('http://cms', '������� ��������', ' ������� �������� ��������. ����������, ���������... ������� �������� ��� ������� ����� ����� ����� ������� ����� ������� ��� ������� ������� - ������� �������� ������� �������� �������������� ��� � �������: * �������: * E-mail: * ������ ��� ����������: ���� ������ � ������� ������ ������, ����������� ���� (���� ����): ���� ���������: ��� ������: * ������ ������� ������ ������� �������� ������ ������� �������� ������� ����� ������� dfbdfbdfb \'dfbvdffd \"\"\" sdfsdfgsdgsg \'sdgsd\"gsd\' ��������: sdf Pgt: 0.103 Queries: 8 sdfdsf '),
('http://cms/users/login', '��� �������', ' ��� ������� ��������. ����������, ���������... ������� �������� ��� ������� ����� ����� ����� ������� ����� ������� ��� ������� ������� - ��� ������� - ���� �����: ������: ����������� ��������� ���� Pgt: 0.091 Queries: 5 sdfdsf '),
('http://cms/map', '����� �����', ' ����� ����� ��������. ����������, ���������... ������� �������� ��� ������� ����� ����� ����� ������� ����� ������� ��� ������� ������� - ����� ����� ��� ������� ���� � ������� ����������� ����� �� ������� ����� ����� ����� ������� �������� ������ 1 �������� ������ 2 ����� ������� fghfg Pgt: 0.075 Queries: 8 sdfdsf '),
('http://cms/search', '�����', ' ����� ��������. ����������, ���������... ������� �������� ��� ������� ����� ����� ����� ������� ����� ������� ��� ������� ������� - ����� Pgt: 0.075 Queries: 5 sdfdsf '),
('http://cms/shop', '�������', ' ������� ��������. ����������, ���������... ������� �������� ��� ������� ����� ����� ����� ������� ����� ������� ��� ������� ������� - ������� � �������� ������ 1 [1] � �������� ������ 2 Pgt: 0.084 Queries: 9 sdfdsf '),
('http://cms/forum', '�����', ' ����� ��������. ����������, ���������... ������� �������� ��� ������� ����� ����� ����� ������� ����� ������� ��� ������� - ������� ����� ��� ��������� ���������� �������� ����� 2 14.09.2006 � 10:56 Pgt: 0.083 Queries: 7 sdfdsf '),
('http://cms/news', '�������', ' ������� ��������. ����������, ���������... ������� �������� ��� ������� ����� ����� ����� ������� ����� ������� ��� ������� ������� - ������� [21.09.2006 17:36] fghfg hfghfghfgh [ ������ ������ ] [ ����� �������� ] Pgt: 0.072 Queries: 6 sdfdsf '),
('http://cms/shop/basket', '�������', ' ������� ��������. ����������, ���������... ������� �������� ��� ������� ����� ����� ����� ������� ����� ������� ��� ������� ������� - ������� - ��� ������� � ����� ������� ��� �������. ������� � ������� ������� Pgt: 0.077 Queries: 7 sdfdsf '),
('http://cms/home/dsfsd', 'sdf', ' sdf ��������. ����������, ���������... ������� �������� ��� ������� ����� ����� ����� ������� ����� ������� ��� ������� ������� - ������� �������� - sdf sdf Pgt: 0.084 Queries: 8 sdfdsf '),
('http://cms/users/register', '��� �������', ' ��� ������� ��������. ����������, ���������... ������� �������� ��� ������� ����� ����� ����� ������� ����� ������� ��� ������� ������� - ��� ������� - ����������� * �.�.�: * �����: * ������: * E-mail 1 : * �������: * ����� ��������: 1 ������������ ����������� ��� ��������� ������������ �����, ��� ��� �� ���� ����� ���������� ����� ����� ������� � ������ ������ ����������. Pgt: 0.079 Queries: 5 sdfdsf '),
('http://cms/users/logout', '', ' Notice : Undefined index: HTTP_REFERER in d:\\home\\cms\\modules\\cabinet\\front\\cabinet.f_main.php on line 68 Warning : Cannot modify header information - headers already sent by (output started at d:\\home\\cms\\modules\\cabinet\\front\\cabinet.f_main.php:68) in d:\\home\\cms\\modules\\cabinet\\front\\cabinet.f_main.php on line 69 '),
('http://cms/shop/test1', '�������� ������ 1', ' �������� ������ 1 ��������. ����������, ���������... ������� �������� ��� ������� ����� ����� ����� ������� ����� ������� ��� ������� ������� - ������� - �������� ������ 1 �������� � ������ ���������: ����������� ��: ���� , ���� , �������� ��� ����������� sdfsd �������� fsdfsdf ��������� ���-��: 1 2 3 4 5 6 7 8 9 10 ����: 41.00 ?. [ �������� � ������� ] Pgt: 0.079 Queries: 9 sdfdsf '),
('http://cms/shop/test2', '�������� ������ 2', ' �������� ������ 2 ��������. ����������, ���������... ������� �������� ��� ������� ����� ����� ����� ������� ����� ������� ��� ������� ������� - ������� - �������� ������ 2 Pgt: 0.079 Queries: 9 sdfdsf '),
('http://cms/news/archive/4', '������� - fghfg', ' ������� - fghfg ��������. ����������, ���������... ������� �������� ��� ������� ����� ����� ����� ������� ����� ������� ��� ������� ������� - ������� - ����� - fghfg [21.09.2006 17:36] fghfg hfghfghfgh Pgt: 0.071 Queries: 6 sdfdsf '),
('http://cms/forum/forum', '�����', ' ����� ��������. ����������, ���������... ������� �������� ��� ������� ����� ����� ����� ������� ����� ������� ��� ������� ������� - �������� ����� ���� ����� ������� ��������� ���������� yrtyrtyrtyr rtytytr 0 14.09.2006 � 10:56 erwer Test Petrovich 1 06.09.2006 � 14:37 ������� ����� ����: * ���� ���: * �������� ����: B I U &laquo; ������ &raquo; URL Pgt: 0.086 Queries: 9 sdfdsf '),
('http://cms/news/archive', '������� - �����', ' ������� - ����� ��������. ����������, ���������... ������� �������� ��� ������� ����� ����� ����� ������� ����� ������� ��� ������� ������� - ������� - ����� [21.09.2006 17:36] fghfg hfghfghfgh [ ������ ������ ] ��������: 1 >> Pgt: 0.072 Queries: 7 sdfdsf '),
('http://cms/home', '������� ��������', ' ������� �������� ��������. ����������, ���������... ������� �������� ��� ������� ����� ����� ����� ������� ����� ������� ��� ������� ������� - ������� �������� ������� �������� �������������� ��� � �������: * �������: * E-mail: * ������ ��� ����������: ���� ������ � ������� ������ ������, ����������� ���� (���� ����): ���� ���������: ��� ������: * ������ ������� ������ ������� �������� ������ ������� �������� ������� ����� ������� dfbdfbdfb \'dfbvdffd \"\"\" sdfsdfgsdgsg \'sdgsd\"gsd\' ��������: sdf Pgt: 0.088 Queries: 8 sdfdsf '),
('http://cms/shop/test1/1', 'sfs', ' sfs ��������. ����������, ���������... ������� �������� ��� ������� ����� ����� ����� ������� ����� ������� ��� ������� ������� - ������� - �������� ������ 1 - sdfsd sdfsd sdfsfsf dsfsdf ���-��: 1 2 3 4 5 6 7 8 9 10 ����: 41.00 ?. [ �������� � ������� ] ����������� ��������: ������� ��������: 0 ��������������� � ����������� �������� ������ ������������������ �������������. ����������� �������������: Pgt: 0.080 Queries: 12 sdfdsf '),
('http://cms/shop/basket/add/1', '', '1'),
('http://cms/forum/forum/thread_2', '�����', ' ����� ��������. ����������, ���������... ������� �������� ��� ������� ����� ����� ����� ������� ����� ������� ��� ������� ������� - �������� ����� - yrtyrtyrtyr �����: ������: ����������� ����: yrtyrtyrtyr rtytytr rtytryrty 14.09.2006 � 10:56 ���������� ��������: * ���� ���: B I U &laquo; ������ &raquo; URL Pgt: 0.091 Queries: 10 sdfdsf '),
('http://cms/forum/forum/thread_1', '�����', ' ����� ��������. ����������, ���������... ������� �������� ��� ������� ����� ����� ����� ������� ����� ������� ��� ������� ������� - �������� ����� - erwer �����: ������: ����������� ����: erwer Test Petrovich ����������� ����� ���������: 2 ���� �����������: 22.12.2006 werewrwerer 06.09.2006 � 14:36 ���������� Test Petrovich ����������� ����� ���������: 2 ���� �����������: 22.12.2006 uiouiouio 06.09.2006 � 14:37 ���������� ��������: * ���� ���: B I U &laquo; ������ &raquo; URL Pgt: 0.086 Queries: 10 sdfdsf '),
('http://cms/news/archive/page_1', '������� - �����', ' ������� - ����� ��������. ����������, ���������... ������� �������� ��� ������� ����� ����� ����� ������� ����� ������� ��� ������� ������� - ������� - ����� [21.09.2006 17:36] fghfg hfghfghfgh [ ������ ������ ] ��������: 1 >> Pgt: 0.071 Queries: 7 sdfdsf ');

DROP TABLE IF EXISTS fw_search_statistics;
CREATE TABLE `fw_search_statistics` (
  `query` varchar(255) NOT NULL default '',
  `number` int(11) NOT NULL default '0',
  KEY `query` (`query`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARSET=cp1251 */;

INSERT INTO `fw_search_statistics` VALUES
('', 1),
('ergerger', 1),
('���������', 1),
('�������', 1),
('quer', 2),
('qu', 1),
('q', 1),
('�������', 27);

DROP TABLE IF EXISTS fw_subscribe_groups;
CREATE TABLE `fw_subscribe_groups` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB /*!40101 DEFAULT CHARSET=cp1251 */;

DROP TABLE IF EXISTS fw_subscribe_list;
CREATE TABLE `fw_subscribe_list` (
  `id` int(11) NOT NULL auto_increment,
  `mail` varchar(255) NOT NULL default '',
  `group_id` int(11) NOT NULL default '0',
  `reg_date` int(15) NOT NULL default '0',
  `status` enum('0','1') NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `mail` (`mail`)
) ENGINE=InnoDB /*!40101 DEFAULT CHARSET=cp1251 */;

DROP TABLE IF EXISTS fw_subscribe_templates;
CREATE TABLE `fw_subscribe_templates` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `template` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB /*!40101 DEFAULT CHARSET=cp1251 */;

DROP TABLE IF EXISTS fw_tables;
CREATE TABLE `fw_tables` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `format` char(3) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB /*!40101 DEFAULT CHARSET=cp1251 */;

INSERT INTO `fw_tables` VALUES
(1, '???????? ??????? 1', 'csv'),
(2, '???????? ??????? 2', 'xls'),
(3, '???????? ??????? 3', 'xls'),
(4, 'sd', 'xls'),
(5, '��', 'xls');

DROP TABLE IF EXISTS fw_templates;
CREATE TABLE `fw_templates` (
  `id` int(10) NOT NULL auto_increment,
  `name` varchar(50) NOT NULL default '',
  `file` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB /*!40101 DEFAULT CHARSET=cp1251 */;

INSERT INTO `fw_templates` VALUES
(2, '��������', 'index.html');

DROP TABLE IF EXISTS fw_tree;
CREATE TABLE `fw_tree` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `param_left` int(11) unsigned NOT NULL default '0',
  `param_right` int(11) unsigned NOT NULL default '0',
  `param_level` int(11) unsigned NOT NULL default '0',
  `url` varchar(20) NOT NULL default '',
  `text` longtext NOT NULL,
  `name` varchar(255) NOT NULL default '',
  `title` varchar(255) NOT NULL default '',
  `meta_keywords` varchar(255) NOT NULL default '',
  `meta_description` varchar(255) NOT NULL default '',
  `module` varchar(50) NOT NULL default '',
  `support_modules` varchar(255) NOT NULL default '',
  `elements` text NOT NULL,
  `template` varchar(50) NOT NULL default '',
  `status` enum('0','1') NOT NULL default '1',
  `access_users` text NOT NULL,
  `access_groups` text NOT NULL,
  `in_menu` enum('0','1') NOT NULL default '1',
  PRIMARY KEY  (`id`),
  KEY `url` (`url`)
) ENGINE=InnoDB /*!40101 DEFAULT CHARSET=cp1251 */ PACK_KEYS=0;

INSERT INTO `fw_tree` VALUES
(14, 1, 18, 0, '/', '', '/', '', '', '', '', '', '', '', '1', '', '', '1'),
(15, 2, 5, 1, 'home', '<DIV>{form id=\"1\"}dfbdfbdfb \'dfbvdffd \"\"\" sdfsdfgsdgsg \'sdgsd\"gsd\'</DIV>\r\n<DIV>{$news}</DIV>', '������� ��������', '', '', '', 'page', 'news,forms', '{if $page_content}\r\n<h1>{$page_content.name|stripslashes}</h1>\r\n{eval var=$page_content.text|stripslashes}\r\n{/if}\r\n\r\n{if $subpages}��������:<br>\r\n<ul>\r\n{$subpages}\r\n</ul>\r\n{/if}', 'index.html', '1', 'all', 'all', '1'),
(16, 6, 7, 1, 'users', '', '��� �������', '', '', '', 'cabinet', '', '{$main}', 'index.html', '1', 'all', '', '1'),
(17, 8, 9, 1, 'map', '', '����� �����', '', '', '', 'site_map', '', '', 'index.html', '1', 'all', '', '1'),
(18, 10, 11, 1, 'search', '', '�����', '', '', '', 'search', '', '', 'index.html', '1', 'all', '', '1'),
(19, 12, 13, 1, 'shop', '', '�������', '', '', '', 'shop', '', '{$main}', 'index.html', '1', 'all', '', '1'),
(20, 14, 15, 1, 'forum', '', '�����', '', '', '', 'forum', '', '', 'index.html', '1', 'all', '', '1'),
(22, 16, 17, 1, 'news', '', '�������', '', '', '', 'news', '', '', 'index.html', '1', 'all', '', '1'),
(23, 3, 4, 2, 'dsfsd', '', 'sdf', '', '', '', 'page', '', '{if $page_content}\r\n<h1>{$page_content.name|stripslashes}</h1>\r\n{eval var=$page_content.text|stripslashes}\r\n{/if}\r\n\r\n{if $subpages}��������:<br>\r\n<ul>\r\n{$subpages}\r\n</ul>\r\n{/if}\r\n', 'index.html', '1', 'all', 'all', '1');

DROP TABLE IF EXISTS fw_urls;
CREATE TABLE `fw_urls` (
  `id` int(11) NOT NULL auto_increment,
  `url_from` varchar(255) NOT NULL default '',
  `url_to` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB /*!40101 DEFAULT CHARSET=cp1251 */;

INSERT INTO `fw_urls` VALUES
(84, 'http://cms/shop/', 'http://cms/asd/asdas/das/'),
(85, 'http://cms/shop/', 'http://cms/asd/asdas/das/'),
(86, 'http://cms/news/', 'http://cms/asd/asdas/das/'),
(87, 'http://cms/news/', 'http://cms/asd/asdas/das/'),
(88, 'http://cms/news/', 'http://cms/asd/asdas/das/'),
(89, 'http://cms/news/', 'http://cms/asd/asdas/das/'),
(90, '', 'http://cms/asd/'),
(91, '', 'http://cms/asd/'),
(92, 'http://cms/forum/', 'http://cms/templates/img/for_01.jpg/'),
(93, 'http://cms/forum/', 'http://cms/templates/img/forum_2.gif/'),
(94, 'http://cms/forum/', 'http://cms/templates/img/forum_3.gif/'),
(95, 'http://cms/seadch/', 'http://cms/sdfsd/sdf/sdf/'),
(96, '', 'http://cms/favicon.ico/'),
(97, '', 'http://cms/favicon.ico/'),
(98, 'http://cms/forum/', 'http://cms/templates/img/forum_2.gif/'),
(99, 'http://cms/forum/', 'http://cms/templates/img/for_01.jpg/'),
(100, 'http://cms/forum/', 'http://cms/templates/img/forum_3.gif/'),
(101, '', 'http://cms/mapasdasd/'),
(102, 'http://www.stroymaster-m.ru/catalog/industrial/', 'http://cms/insertfiles/demon_creative-1133467079_i_5386_full.jpg/'),
(103, 'http://www.stroymaster-m.ru/admin/index.php?mod=shop&action=edit_product&id=1', 'http://cms/insertfiles/demon_creative-1133467079_i_5386_full.jpg/'),
(104, 'http://www.stroymaster-m.ru/admin/index.php?mod=shop&action=edit_product&id=1', 'http://cms/insertfiles/demon_creative-1133467079_i_5386_full.jpg/'),
(105, 'http://cms/forum/', 'http://cms/templates/img/forum_3.gif/'),
(106, 'http://cms/forum/', 'http://cms/templates/img/for_01.jpg/'),
(107, 'http://cms/forum/', 'http://cms/templates/img/forum_2.gif/'),
(108, 'http://cms/forum/', 'http://cms/templates/img/forum_2.gif/'),
(109, 'http://cms/forum/', 'http://cms/templates/img/for_01.jpg/'),
(110, 'http://cms/forum/', 'http://cms/templates/img/for_01.jpg/'),
(111, 'http://cms/forum/', 'http://cms/templates/img/forum_2.gif/'),
(112, 'http://cms/forum/', 'http://cms/templates/img/forum_3.gif/'),
(113, 'http://cms/admin/index.php?mod=banners&action=edit_banner&id=1', 'http://cms/uploaded_files/banners/1.gif/'),
(114, 'http://cms/admin/index.php?mod=banners&action=edit_banner&id=1', 'http://cms/uploaded_files/banners/1.gif/'),
(115, 'http://cms/admin/index.php?mod=banners&action=edit_banner&id=1', 'http://cms/uploaded_files/banners/1.gif/'),
(116, 'http://cms/admin/index.php?mod=banners&action=edit_banner&id=1', 'http://cms/uploaded_files/banners/1.gif/'),
(117, 'http://cms/admin/index.php?mod=banners&action=edit_banner&id=1', 'http://cms/uploaded_files/banners/1.gif/'),
(118, 'http://cms/admin/index.php?mod=banners&action=edit_banner&id=1', 'http://cms/uploaded_files/banners/1.gif/'),
(119, 'http://cms/admin/index.php?mod=banners&action=edit_banner&id=1', 'http://cms/uploaded_files/banners/1.gif/'),
(120, 'http://cms/admin/index.php?mod=banners&action=edit_banner&id=1', 'http://cms/uploaded_files/banners/1.gif/'),
(121, 'http://cms/admin/index.php?mod=banners&action=edit_banner&id=1', 'http://cms/uploaded_files/banners/1.gif/'),
(122, 'http://cms/admin/index.php?mod=banners&action=edit_banner&id=1', 'http://cms/uploaded_files/banners/1.gif/'),
(123, 'http://cms/admin/index.php?mod=banners&action=edit_banner&id=1', 'http://cms/uploaded_files/banners/1.gif/'),
(124, 'http://cms/admin/index.php?mod=banners&action=edit_banner&id=1', 'http://cms/uploaded_files/banners/1.gif/'),
(125, 'http://cms/admin/index.php?mod=banners&action=edit_banner&id=1', 'http://cms/uploaded_files/banners/1.gif/'),
(126, 'http://cms/admin/index.php?mod=banners&action=edit_banner&id=1', 'http://cms/uploaded_files/banners/1.gif/'),
(127, 'http://cms/admin/index.php?mod=banners&action=edit_banner&id=1', 'http://cms/uploaded_files/banners/1.gif/'),
(128, 'http://cms/admin/index.php?mod=banners&action=edit_banner&id=1', 'http://cms/uploaded_files/banners/1.gif/'),
(129, 'http://cms/admin/index.php?mod=banners&action=edit_banner&id=1', 'http://cms/uploaded_files/banners/1.gif/'),
(130, 'http://cms/admin/index.php?mod=banners&action=edit_banner&id=1', 'http://cms/uploaded_files/banners/1.gif/'),
(131, 'http://cms/admin/index.php?mod=banners&action=edit_banner&id=1', 'http://cms/uploaded_files/banners/1.gif/'),
(132, 'http://cms/admin/index.php?mod=banners&action=edit_banner&id=1', 'http://cms/uploaded_files/banners/1.gif/'),
(133, 'http://cms/admin/index.php?mod=banners&action=edit_banner&id=1', 'http://cms/uploaded_files/banners/1.gif/'),
(134, 'http://cms/admin/index.php?mod=banners&action=edit_banner&id=1', 'http://cms/uploaded_files/banners/1.gif/'),
(135, 'http://cms/admin/index.php?mod=banners&action=edit_banner&id=1', 'http://cms/uploaded_files/banners/1.gif/'),
(136, 'http://cms/admin/index.php?mod=banners&action=edit_banner&id=1', 'http://cms/uploaded_files/banners/1.gif/'),
(137, 'http://cms/admin/index.php?mod=banners&action=edit_banner&id=1', 'http://cms/uploaded_files/banners/1.gif/'),
(138, 'http://cms/admin/index.php?mod=banners&action=edit_banner&id=1', 'http://cms/uploaded_files/banners/1.gif/'),
(139, 'http://cms/admin/index.php?mod=banners&action=edit_banner&id=1', 'http://cms/uploaded_files/banners/1.gif/'),
(140, 'http://cms/admin/index.php?mod=banners&action=edit_banner&id=1', 'http://cms/uploaded_files/banners/1.gif/'),
(141, 'http://cms/admin/index.php?mod=banners&action=edit_banner&id=1', 'http://cms/uploaded_files/banners/1.gif/'),
(142, 'http://cms/admin/index.php?mod=banners&action=edit_banner&id=1', 'http://cms/uploaded_files/banners/1.gif/'),
(143, 'http://cms/admin/index.php?mod=banners&action=edit_banner&id=1', 'http://cms/uploaded_files/banners/1.gif/'),
(144, 'http://cms/admin/index.php?mod=banners&action=edit_banner&id=1', 'http://cms/uploaded_files/banners/1.gif/'),
(145, 'http://cms/admin/index.php?mod=banners&action=edit_banner&id=1', 'http://cms/uploaded_files/banners/1.gif/'),
(146, 'http://cms/admin/index.php?mod=banners&action=edit_banner&id=1', 'http://cms/uploaded_files/banners/1.gif/'),
(147, 'http://cms/admin/index.php?mod=banners&action=edit_banner&id=1', 'http://cms/uploaded_files/banners/1.gif/'),
(148, 'http://cms/admin/index.php?mod=banners&action=edit_banner&id=1', 'http://cms/uploaded_files/banners/1.gif/'),
(149, 'http://cms/admin/index.php?mod=banners&action=edit_banner&id=1', 'http://cms/uploaded_files/banners/1.gif/'),
(150, 'http://cms/admin/index.php?mod=banners&action=edit_banner&id=1', 'http://cms/uploaded_files/banners/1.gif/'),
(151, 'http://cms/admin/index.php?mod=banners&action=edit_banner&id=1', 'http://cms/uploaded_files/banners/1.gif/'),
(152, 'http://cms/admin/index.php?mod=banners&action=edit_banner&id=1', 'http://cms/uploaded_files/banners/1.gif/'),
(153, 'http://cms/admin/index.php?mod=banners&action=edit_banner&id=1', 'http://cms/uploaded_files/banners/1.gif/'),
(154, 'http://cms/admin/index.php?mod=banners&action=edit_banner&id=1', 'http://cms/uploaded_files/banners/1.gif/'),
(155, 'http://cms/admin/index.php?mod=banners&action=edit_banner&id=1', 'http://cms/uploaded_files/banners/1.gif/'),
(156, 'http://cms/admin/index.php?mod=banners&action=edit_banner&id=1', 'http://cms/uploaded_files/banners/1.gif/'),
(157, 'http://cms/admin/index.php?mod=banners&action=edit_banner&id=1', 'http://cms/uploaded_files/banners/1.gif/'),
(158, 'http://cms/admin/index.php?mod=banners&action=edit_banner&id=1', 'http://cms/uploaded_files/banners/1.gif/'),
(159, 'http://cms/admin/index.php?mod=banners&action=edit_banner&id=1', 'http://cms/uploaded_files/banners/1.gif/'),
(160, 'http://cms/admin/index.php?mod=banners&action=edit_banner&id=1', 'http://cms/uploaded_files/banners/1.gif/'),
(161, 'http://cms/admin/index.php?mod=banners&action=edit_banner&id=1', 'http://cms/uploaded_files/banners/1.gif/'),
(162, 'http://cms/admin/index.php?mod=banners&action=edit_banner&id=1', 'http://cms/uploaded_files/banners/1.gif/'),
(163, 'http://cms/admin/index.php?mod=banners&action=edit_banner&id=1', 'http://cms/uploaded_files/banners/1.gif/'),
(164, 'http://cms/admin/index.php?mod=banners&action=edit_banner&id=1', 'http://cms/uploaded_files/banners/1.gif/'),
(165, 'http://cms/admin/index.php?mod=banners&action=edit_banner&id=1', 'http://cms/uploaded_files/banners/1.gif/'),
(166, 'http://cms/admin/index.php?mod=banners&action=edit_banner&id=1', 'http://cms/uploaded_files/banners/1.gif/'),
(167, 'http://cms/admin/index.php?mod=banners&action=edit_banner&id=1', 'http://cms/uploaded_files/banners/1.gif/'),
(168, 'http://cms/admin/index.php?mod=banners&action=edit_banner&id=1', 'http://cms/uploaded_files/banners/1.gif/'),
(169, 'http://cms/admin/index.php?mod=banners&action=edit_banner&id=1', 'http://cms/uploaded_files/banners/1.gif/'),
(170, 'http://cms/admin/index.php?mod=banners&action=edit_banner&id=1', 'http://cms/uploaded_files/banners/1.gif/'),
(171, 'http://cms/admin/index.php?mod=banners&action=edit_banner&id=1', 'http://cms/uploaded_files/banners/1.gif/'),
(172, 'http://cms/admin/index.php?mod=banners&action=edit_banner&id=1', 'http://cms/uploaded_files/banners/1.gif/'),
(173, 'http://cms/admin/index.php?mod=banners&action=edit_banner&id=1', 'http://cms/uploaded_files/banners/1.gif/'),
(174, 'http://cms/admin/index.php?mod=banners&action=edit_banner&id=1', 'http://cms/uploaded_files/banners/1.gif/'),
(175, 'http://cms/admin/index.php?mod=banners&action=edit_banner&id=1', 'http://cms/uploaded_files/banners/1.gif/'),
(176, 'http://cms/admin/index.php?mod=banners&action=edit_banner&id=1', 'http://cms/uploaded_files/banners/1.gif/'),
(177, 'http://cms/admin/index.php?mod=banners&action=edit_banner&id=1', 'http://cms/uploaded_files/banners/1.gif/'),
(178, 'http://cms/admin/index.php?mod=banners&action=edit_banner&id=1', 'http://cms/uploaded_files/banners/1.gif/'),
(179, 'http://cms/admin/index.php?mod=banners&action=edit_banner&id=1', 'http://cms/uploaded_files/banners/1.gif/'),
(180, 'http://cms/admin/index.php?mod=banners&action=edit_banner&id=1', 'http://cms/uploaded_files/banners/1.gif/'),
(181, 'http://cms/admin/index.php?mod=banners&action=edit_banner&id=1', 'http://cms/uploaded_files/banners/1.gif/'),
(182, 'http://cms/admin/index.php?mod=banners&action=edit_banner&id=1', 'http://cms/uploaded_files/banners/1.gif/'),
(183, 'http://cms/admin/index.php?mod=banners&action=edit_banner&id=1', 'http://cms/uploaded_files/banners/1.gif/'),
(184, 'http://cms/admin/index.php?mod=banners&action=edit_banner&id=1', 'http://cms/uploaded_files/banners/1.gif/'),
(185, 'http://cms/admin/index.php?mod=banners&action=edit_banner&id=1', 'http://cms/uploaded_files/banners/1.gif/'),
(186, 'http://cms/admin/index.php?mod=banners&action=edit_banner&id=1', 'http://cms/uploaded_files/banners/1.gif/'),
(187, 'http://cms/admin/index.php?mod=banners&action=edit_banner&id=1', 'http://cms/uploaded_files/banners/1.gif/'),
(188, 'http://cms/admin/index.php?mod=banners&action=edit_banner&id=1', 'http://cms/uploaded_files/banners/1.gif/'),
(189, 'http://cms/admin/index.php?mod=banners&action=edit_banner&id=1', 'http://cms/uploaded_files/banners/1.gif/'),
(190, 'http://cms/admin/index.php?mod=banners&action=edit_banner&id=1', 'http://cms/uploaded_files/banners/1.gif/'),
(191, 'http://cms/admin/index.php?mod=banners&action=edit_banner&id=1', 'http://cms/uploaded_files/banners/1.gif/'),
(192, 'http://cms/admin/index.php?mod=banners&action=edit_banner&id=1', 'http://cms/uploaded_files/banners/1.gif/'),
(193, 'http://cms/admin/index.php?mod=banners&action=edit_banner&id=1', 'http://cms/uploaded_files/banners/1.gif/'),
(194, 'http://cms/admin/index.php?mod=banners&action=edit_banner&id=1', 'http://cms/uploaded_files/banners/1.gif/'),
(195, 'http://cms/admin/index.php?mod=banners&action=edit_banner&id=1', 'http://cms/uploaded_files/banners/1.gif/'),
(196, 'http://cms/admin/index.php?mod=banners&action=edit_banner&id=1', 'http://cms/uploaded_files/banners/1.gif/'),
(197, 'http://cms/admin/index.php?mod=banners&action=edit_banner&id=1', 'http://cms/uploaded_files/banners/1.gif/'),
(198, 'http://cms/admin/index.php?mod=banners&action=edit_banner&id=1', 'http://cms/uploaded_files/banners/1.gif/'),
(199, 'http://cms/admin/index.php?mod=banners&action=edit_banner&id=1', 'http://cms/uploaded_files/banners/1.gif/'),
(200, 'http://cms/admin/index.php?mod=banners&action=edit_banner&id=1', 'http://cms/uploaded_files/banners/1.gif/'),
(201, 'http://cms/admin/index.php?mod=banners&action=edit_banner&id=1', 'http://cms/uploaded_files/banners/1.gif/'),
(202, 'http://cms/admin/index.php?mod=banners&action=edit_banner&id=1', 'http://cms/uploaded_files/banners/1.gif/'),
(203, 'http://cms/admin/index.php?mod=banners&action=edit_banner&id=1', 'http://cms/uploaded_files/banners/1.gif/'),
(204, 'http://cms/admin/index.php?mod=banners&action=edit_banner&id=1', 'http://cms/uploaded_files/banners/1.gif/'),
(205, 'http://cms/admin/index.php?mod=banners&action=edit_banner&id=1', 'http://cms/uploaded_files/banners/1.gif/'),
(206, 'http://cms/admin/index.php?mod=banners&action=edit_banner&id=1', 'http://cms/uploaded_files/banners/1.gif/'),
(207, 'http://cms/admin/index.php?mod=banners&action=edit_banner&id=1', 'http://cms/uploaded_files/banners/1.gif/'),
(208, 'http://cms/admin/index.php?mod=banners&action=edit_banner&id=1', 'http://cms/uploaded_files/banners/1.gif/'),
(209, 'http://cms/admin/index.php?mod=banners&action=edit_banner&id=1', 'http://cms/uploaded_files/banners/1.gif/'),
(210, 'http://cms/admin/index.php?mod=banners&action=edit_banner&id=1', 'http://cms/uploaded_files/banners/1.gif/'),
(211, 'http://cms/admin/index.php?mod=banners&action=edit_banner&id=1', 'http://cms/uploaded_files/banners/1.gif/'),
(212, 'http://cms/admin/index.php?mod=banners&action=edit_banner&id=1', 'http://cms/uploaded_files/banners/1.gif/'),
(213, 'http://cms/admin/index.php?mod=banners&action=edit_banner&id=1', 'http://cms/uploaded_files/banners/1.gif/'),
(214, 'http://cms/admin/index.php?mod=banners&action=edit_banner&id=1', 'http://cms/uploaded_files/banners/1.gif/'),
(215, 'http://cms/admin/index.php?mod=banners&action=edit_banner&id=1', 'http://cms/uploaded_files/banners/1.gif/'),
(216, 'http://cms/admin/index.php?mod=banners&action=edit_banner&id=1', 'http://cms/uploaded_files/banners/1.gif/'),
(217, 'http://cms/forum/', 'http://cms/templates/img/for_01.jpg/'),
(218, 'http://cms/forum/', 'http://cms/templates/img/forum_3.gif/'),
(219, 'http://cms/forum/', 'http://cms/templates/img/forum_2.gif/'),
(220, 'http://cms/forum/', 'http://cms/templates/img/forum_3.gif/'),
(221, '', 'http://cms/favicon.ico/'),
(222, 'http://cms/admin/index.php?mod=banners&action=edit_banner&id=1', 'http://cms/modules/select_date/calendar.php/?id=ed'),
(223, 'http://cms/admin/index.php?mod=banners&action=edit_banner&id=1', 'http://cms/modules/select_date/calendar.php/?id=ed'),
(224, 'http://cms/modules/select_date/calendar.php?id=sd', 'http://cms/modules/select_date/templates/img/bg4.gif/'),
(225, 'http://cms/modules/select_date/calendar.php?id=sd', 'http://cms/modules/select_date/templates/img/bg4.gif/'),
(226, 'http://cms/modules/select_date/calendar.php?id=sd', 'http://cms/modules/select_date/templates/img/bg4.gif/'),
(227, 'http://cms/modules/select_date/calendar.php?id=sd', 'http://cms/modules/select_date/templates/img/bg4.gif/'),
(228, 'http://cms/admin/index.php?mod=banners&action=edit_banner&id=2', 'http://cms/uploaded_files/banners/2.gif/'),
(229, 'http://cms/admin/index.php?mod=banners&action=edit_banner&id=2', 'http://cms/uploaded_files/banners/2.gif/'),
(230, 'http://cms/admin/index.php?mod=banners&action=edit_banner&id=2', 'http://cms/uploaded_files/banners/2.jpg/'),
(231, 'http://cms/admin/index.php?mod=banners&action=edit_banner&id=2', 'http://cms/uploaded_files/banners/2.jpg/'),
(232, 'http://cms/shop/test1/', 'http://cms/go.php/?target=1'),
(233, '', 'http://cms/temp.php'),
(234, '', 'http://cms/temp.html/'),
(235, '', 'http://cms/temp.html/'),
(236, '', 'http://cms/index.php/'),
(237, '', 'http://cms/shop/test1/s.xml'),
(238, '', 'http://cms/shop/test1/catalog.xml'),
(239, '', 'http://cms/index.php/'),
(240, '', 'http://cms/index.php/'),
(241, '', 'http://cms/index.php/'),
(242, '', 'http://cms/shop/test1/index.php/'),
(243, '', 'http://cms/index.php/'),
(244, '', 'http://cms/shop/test1/index.xml_/'),
(245, '', 'http://cms/shop/test1/index.xml_/'),
(246, '', 'http://cms/shop/test1/index.xml%5C'),
(247, '', 'http://cms/shop/test1/index.xml_/'),
(248, '', 'http://cms/shop/test1_/'),
(249, '', 'http://cms/shop/test1/index.xml');

DROP TABLE IF EXISTS fw_users;
CREATE TABLE `fw_users` (
  `id` tinyint(10) unsigned NOT NULL auto_increment,
  `login` varchar(50) NOT NULL default '',
  `password` varchar(32) NOT NULL default '',
  `name` varchar(100) NOT NULL default '',
  `mail` varchar(50) NOT NULL default '',
  `tel` varchar(20) NOT NULL default '',
  `deliver` text NOT NULL,
  `send_forum_answers` set('0','1') NOT NULL default '',
  `reg_date` int(15) NOT NULL default '0',
  `group_id` int(10) NOT NULL default '0',
  `status` enum('0','1') NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB /*!40101 DEFAULT CHARSET=cp1251 */;

INSERT INTO `fw_users` VALUES
(1, 'root', '2567a5ec9705eb7ac2c984033e06189d', 'Test Petrovich', 'test@test.com', '0451051510', 'tgrgtrbrbtbr', '', 0, 1, '1'),
(3, 'admin', 'c5fe25896e49ddfe996db7508cf00534', '������������� �����', 'admin@site.ru', '(495) 783-08-40', '', '', 0, 2, '1');

DROP TABLE IF EXISTS fw_users_groups;
CREATE TABLE `fw_users_groups` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `priv` tinyint(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB /*!40101 DEFAULT CHARSET=cp1251 */;

INSERT INTO `fw_users_groups` VALUES
(1, '�����������', 0),
(2, '�������������', 1),
(3, '��������', 5),
(4, '����', 8),
(5, '������������', 9);

