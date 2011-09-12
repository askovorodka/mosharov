-- phpMyAdmin SQL Dump
-- version 
-- http://www.phpmyadmin.net
-- 
-- Хост: 62.152.41.101
-- Время создания: Июл 31 2008 г., 21:47
-- Версия сервера: 4.1.22
-- Версия PHP: 5.1.6
-- 
-- База данных: `a14540_blmdb`
-- 

-- --------------------------------------------------------

-- 
-- Структура таблицы `fw_banners`
-- 

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
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=3 ;

-- 
-- Дамп данных таблицы `fw_banners`
-- 

INSERT INTO `fw_banners` (`id`, `name`, `image`, `type`, `target_url`, `showings`, `start_date`, `end_date`, `group`, `status`, `shown`, `clicks`) VALUES 
(1, 'Тестовый баннер', 'gif', '0', 'http://ya.ru', 500, 1167598800, 1169154000, 1, '1', 50, 4),
(2, 'Тестовый баннер 2', 'gif', '0', 'http://rambler.ru', 1000, 0, 0, 2, '1', 197, 5);

-- --------------------------------------------------------

-- 
-- Структура таблицы `fw_banners_cat`
-- 

CREATE TABLE `fw_banners_cat` (
  `banner_id` int(11) NOT NULL default '0',
  `url` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

-- 
-- Дамп данных таблицы `fw_banners_cat`
-- 

INSERT INTO `fw_banners_cat` (`banner_id`, `url`) VALUES 
(2, '/about/'),
(2, '/otr/'),
(2, '/news/'),
(2, '/contacts/'),
(1, '/news/');

-- --------------------------------------------------------

-- 
-- Структура таблицы `fw_banners_groups`
-- 

CREATE TABLE `fw_banners_groups` (
  `id` int(15) unsigned NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=3 ;

-- 
-- Дамп данных таблицы `fw_banners_groups`
-- 

INSERT INTO `fw_banners_groups` (`id`, `name`) VALUES 
(1, 'Тестовая группа 1'),
(2, 'Тестовая группа 2');

-- --------------------------------------------------------

-- 
-- Структура таблицы `fw_catalogue`
-- 

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
  `parent_id` int(11) NOT NULL default '0',
  `small_text` text,
  `top` enum('0','1') default '0',
  `title_top` varchar(255) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=17 ;

-- 
-- Дамп данных таблицы `fw_catalogue`
-- 

INSERT INTO `fw_catalogue` (`id`, `param_left`, `param_right`, `param_level`, `url`, `name`, `text`, `title`, `image`, `meta_keywords`, `meta_description`, `status`, `parent_id`, `small_text`, `top`, `title_top`) VALUES 
(1, 1, 8, 0, '/', '/', '', '', '', '', '', '1', 0, '', '0', NULL),
(13, 2, 3, 1, 'vertu', 'Мобильные телефоны Vertu', '<br>', 'Мобильные телефоны Vertu', '', '', '', '1', 0, 'Краткое описание для категории<br>', '1', 'Vertu'),
(14, 4, 5, 1, 'mobiado', 'Мобильные телефоны Mobiado', '<br>', 'Мобильные телефоны Nokia', '', '', '', '1', 1, 'Краткое описание для категории<br>', '1', 'Mobiado'),
(15, 6, 7, 1, 'royal_vx', 'Мобильные телефоны Royal VX', '<br>', '', '', '', '', '1', 1, 'Краткое описание для категории<br>', '1', 'Royal VX');

-- --------------------------------------------------------

-- 
-- Структура таблицы `fw_catalogue_properties`
-- 

CREATE TABLE `fw_catalogue_properties` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `type` enum('0','1','2') NOT NULL default '0',
  `elements` text NOT NULL,
  `status` enum('0','1') NOT NULL default '1',
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=3 ;

-- 
-- Дамп данных таблицы `fw_catalogue_properties`
-- 

INSERT INTO `fw_catalogue_properties` (`id`, `name`, `type`, `elements`, `status`) VALUES 
(1, 'dsfsdf', '2', '', '1'),
(2, 'р', '1', 'левый правый', '1');

-- --------------------------------------------------------

-- 
-- Структура таблицы `fw_catalogue_relations`
-- 

CREATE TABLE `fw_catalogue_relations` (
  `cat_id` int(11) NOT NULL default '0',
  `property_id` int(11) NOT NULL default '0',
  `sort_order` int(10) NOT NULL default '0'
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

-- 
-- Дамп данных таблицы `fw_catalogue_relations`
-- 

INSERT INTO `fw_catalogue_relations` (`cat_id`, `property_id`, `sort_order`) VALUES 
(2, 1, 0);

-- --------------------------------------------------------

-- 
-- Структура таблицы `fw_conf`
-- 

CREATE TABLE `fw_conf` (
  `conf_key` varchar(50) NOT NULL default '',
  `conf_value` varchar(255) NOT NULL default '',
  `name` varchar(255) NOT NULL default '',
  `section` varchar(20) NOT NULL default '',
  `section_name` varchar(30) NOT NULL default ''
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

-- 
-- Дамп данных таблицы `fw_conf`
-- 

INSERT INTO `fw_conf` (`conf_key`, `conf_value`, `name`, `section`, `section_name`) VALUES 
('LOGIN_LIFETIME', '86400', 'Время жизни сессии', 'global', 'Глобальные'),
('USERS_PER_PAGE', '30', 'Пользователей на сраницу', 'users', 'Пользователи'),
('PAGES_PER_PAGE', '30', 'Страниц в списке', 'pages', 'Страницы'),
('DEFAULT_URL', 'home', 'УРЛ по умолчанию', 'front', 'Сайт'),
('SMARTY_DEBUGGING_SITE', 'false', 'Дебагер Smarty', 'front', 'Сайт'),
('NEWS_PER_PAGE_FRONT', '5', 'Новостей на страницу (сайт)', 'front', 'Сайт'),
('PRODUCTS_PER_PAGE', '30', 'Продуктов на страницу', 'shop', 'Магазин'),
('PRODUCT_GENERATE_PREVIEW', 'on', 'Автоматическая генерация preview', 'shop', 'Магазин'),
('DEFAULT_CURRENCY', 'руб.', 'Денежная еденица', 'shop', 'Магазин'),
('NEWS_PER_PAGE', '30', 'Новостей на старницу (админка)', 'news', 'Новости'),
('NEWS_PER_PAGE_FRONT_ARCHIVE', '10', 'Новостей на страницу архива', 'news', 'Новости'),
('PRODUCTS_PER_PAGE_FRONT', '15', 'Продуктов на страницу (сайт)', 'shop', 'Магазин'),
('SEARCH_RESULTS_PER_PAGE', '15', 'Результатов поиска на страницу', 'shop', 'Магазин'),
('POLLS_PER_PAGE', '30', 'Опросов на страницу', 'poll', 'Опросы'),
('NEWS_IMAGE_WIDTH', '100', 'Ширина превью', 'news', 'Новости'),
('ALBUMS_PER_PAGE', '30', 'Альбомов на страницу', 'photoalbum', 'Фотоальбом'),
('PREVIEW1_WIDTH', '100', 'Ширина маленького превью', 'photoalbum', 'Фотоальбом'),
('PREVIEW2_WIDTH', '400', 'Ширина большого превью', 'photoalbum', 'Фотоальбом'),
('PHOTO_MAX_SIZE', '1600x1200', 'Максимальный размер фотографии', 'photoalbum', 'Фотоальбом'),
('ALLOWED_FORMATS', 'gif,jpeg,png', 'Разрешённые форматы', 'photoalbum', 'Фотоальбом'),
('PHOTOS_FOLDER', 'uploaded_files/photos', 'Папка фотографий', 'photoalbum', 'Фотоальбом'),
('PHOTO_MAX_FILESIZE', '2000', 'Максимальный вес фотографии (Кб)', 'photoalbum', 'Фотоальбом'),
('PHOTOS_PER_PAGE', '12', 'Фотографий на страницу альбома', 'photoalbum', 'Фотоальбом'),
('SEND_ORDER_TO', 'shand@yandex.ru', 'Адрес для уведомлений о заказе', 'shop', 'Магазин'),
('ADMIN_MAIL', 'shand@yandex.ru', 'Адрес администратора сайта', 'global', 'Глобальные'),
('PREVIEW1_HEIGTH', '100', 'Высота маленького превью', 'photoalbum', 'Фотоальбом'),
('PREVIEW2_HEIGTH', '400', 'Высота большого превью', 'photoalbum', 'Фотоальбом'),
('PRODUCT_PREVIEW_WIDTH', '100', 'Ширина превью продукта', 'shop', 'Магазин'),
('PRODUCT_PREVIEW_HEIGHT', '100', 'Высота превью продукта', 'shop', 'Магазин'),
('PHOTOS_PER_PAGE_SUP', '15', 'ФОтографий на страницу альбома поддержки', 'photoalbum', 'Фотоальбом'),
('PHOTOALBUM_MODE', 'full', 'Стиль фотоальбома', 'photoalbum', 'Фотоальбом'),
('BASE_URL', 'http://www.blmobile.ru', 'УРЛ сайта', 'global', 'Глобальные'),
('BASE_PATH', '/home/httpd/vhosts/blmobile.ru/httpdocs', 'Путь к скрипту', 'global', 'Глобальные'),
('SCRIPT_FOLDER', '', 'Папка скрипта', 'global', 'Глобальные'),
('THREADS_PER_PAGE', '50', 'Тем на сраницу', 'forum', 'Форум'),
('RESULTS_PER_PAGE', '5', 'Результатов на странцу', 'search', 'Поиск'),
('POSTS_PER_PAGE', '20', 'Сообщений на страницу', 'forum', 'Форум'),
('SUBSCRIBE_ENCODING', 'Windows-1251', 'Кодировка сообщений', 'subscribe', 'Рассылка'),
('SUBSCRIBE_TRANSPORT_METHOD', 'standard', 'Метод отправки писем', 'subscribe', 'Рассылка'),
('CONFIRM_SUBSCRIPTION', 'yes', 'Подтверждение подписки по почте', 'subscribe', 'Рассылка'),
('GB_MESSAGES_PER_PAGE', '10', 'Сообщений на страницу', 'guestbook', 'Гостевая книга'),
('GB_PREMODERATION', 'on', 'Премодерация сообщений', 'guestbook', 'Гостевая книга'),
('PHOTOALBUM_COMMENTS_PER_PAGE', '20', 'Комментариев на страницу', 'photoalbum', 'Фотоальбом'),
('PRODUCT_RATING', 'off', 'Рейтинг продукции', 'shop', 'Магазин'),
('PRODUCT_COMMENTS', 'off', 'Комментарии продукции', 'shop', 'Магазин'),
('PRODUCT_COMMENTS_PER_PAGE', '10', 'Комментариев на страницу', 'shop', 'Магазин'),
('EDITOR_MODE', 'html_', 'Стиль редактора', 'admin', 'Администраторская панель'),
('RSS_SHOW', 'true', 'Отображение RSS новостей', 'admin', 'Администраторская панель'),
('RSS_URL', '', 'URL новостей', 'admin', 'Администраторская панель'),
('FORUM_PREMODERATION', 'off', 'Премодерация сообщений', 'forum', 'Форум'),
('BANNERS_PER_PAGE', '20', 'Баннеров на страницу', 'banners', 'Баннеры'),
('CURRENCY_RATE', '29.4', 'Курс валюты', 'shop', 'Магазин'),
('DOCUMENT_IMAGE_WIDTH', '100', 'Ширина превью картинки для документа', 'pages', 'Страницы'),
('DOCUMENT_IMAGE_HEIGHT', '100', 'Высота превью картинки для документа', 'pages', 'Страницы'),
('DOCUMENTS_ON_PAGE', '10', 'Документов на страницу', 'pages', 'Страницы'),
('NEWS_PER_TOP', '3', 'Новостей на главной', 'news', 'Новости'),
('OTR_PER_PAGE', '30', 'Отраслевых решений на страницу', 'otr', 'Отраслевые решения'),
('CURRENCY_SITE', '1', 'Валюта для вывода на сайт', 'shop', 'Магазин'),
('CURRENCY_ADMIN', '1', 'Валюта расчета', 'shop', 'Магазин'),
('PRODUCT_PER_PHOTO', '4', 'Превью продукта', 'shop', 'Магазин');

-- --------------------------------------------------------

-- 
-- Структура таблицы `fw_currency`
-- 

CREATE TABLE `fw_currency` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `kurs` float NOT NULL default '0',
  `znak` varchar(255) NOT NULL default '',
  `status` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=4 ;

-- 
-- Дамп данных таблицы `fw_currency`
-- 

INSERT INTO `fw_currency` (`id`, `name`, `kurs`, `znak`, `status`) VALUES 
(1, 'Рубль', 1, 'руб.', 1),
(2, 'Доллар', 28.5, '$', 1),
(3, 'euro', 35, 'euro', 1);

-- --------------------------------------------------------

-- 
-- Структура таблицы `fw_documents`
-- 

CREATE TABLE `fw_documents` (
  `id` int(11) NOT NULL auto_increment,
  `parent` int(11) NOT NULL default '0',
  `name` varchar(255) NOT NULL default '',
  `small_description` text NOT NULL,
  `description` text NOT NULL,
  `title` varchar(255) NOT NULL default '',
  `image` varchar(255) NOT NULL default '',
  `meta_keywords` varchar(255) NOT NULL default '',
  `meta_description` varchar(255) NOT NULL default '',
  `status` enum('0','1') NOT NULL default '1',
  `insert_date` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `sort_order` int(11) NOT NULL default '1',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=23 ;

-- 
-- Дамп данных таблицы `fw_documents`
-- 

INSERT INTO `fw_documents` (`id`, `parent`, `name`, `small_description`, `description`, `title`, `image`, `meta_keywords`, `meta_description`, `status`, `insert_date`, `sort_order`) VALUES 
(3, 23, 'name 3', '3333', '4444444', '222222', '3.jpg', '', '', '1', '0000-00-00 00:00:00', 2),
(8, 23, 'name 8', 'asdsadsa', 'asdasdas', 'asdasd', '', '', '', '1', '0000-00-00 00:00:00', 5),
(9, 23, 'name 9', 'asdsadsa', 'asdasdas', 'asdasd', '', '', '', '1', '0000-00-00 00:00:00', 3),
(10, 23, 'name 10', '3333', '4444444', '222222', '', '', '', '1', '0000-00-00 00:00:00', 6),
(11, 23, 'name 11', 'asdsadsa', 'asdasdas', 'asdasd', '', '', '', '1', '0000-00-00 00:00:00', 1),
(12, 23, 'name 12', '3333', '4444444', '222222', '', '', '', '1', '0000-00-00 00:00:00', 7),
(13, 23, 'name 13', 'asdsadsa', 'asdasdas', 'asdasd', '', '', '', '0', '0000-00-00 00:00:00', 4),
(14, 23, 'name 14', '3333', '4444444', '222222', '', '', '', '1', '0000-00-00 00:00:00', 8),
(15, 23, 'name 15', 'asdsadsa', 'asdasdas', 'asdasd', '', '', '', '1', '0000-00-00 00:00:00', 10),
(16, 23, 'name 16', '3333', '4444444', '222222', '', '', '', '1', '0000-00-00 00:00:00', 9),
(17, 23, 'name 17', 'asdsadsa', 'asdasdas', 'asdasd', '', '', '', '1', '0000-00-00 00:00:00', 11),
(18, 23, 'name 18', '3333', '4444444', '222222', '', '', '', '1', '0000-00-00 00:00:00', 12),
(19, 23, 'name 19', 'asdsadsa', 'asdasdas', 'asdasd', '', '', '', '1', '0000-00-00 00:00:00', 13),
(20, 23, 'name 20', '3333', '4444444', '222222', '', '', '', '1', '0000-00-00 00:00:00', 14),
(21, 23, 'name 21', 'asdsadsa', 'asdasdas', 'asdasd', '', '', '', '1', '0000-00-00 00:00:00', 15),
(22, 23, 'name 22', '3333', '4444444', '222222', '', '', '', '1', '0000-00-00 00:00:00', 16);

-- --------------------------------------------------------

-- 
-- Структура таблицы `fw_documents_orderby`
-- 

CREATE TABLE `fw_documents_orderby` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `orderby` varchar(255) NOT NULL default '',
  `orderbysc` enum('ASC','DESC') NOT NULL default 'ASC',
  `status` enum('0','1') NOT NULL default '1',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=4 ;

-- 
-- Дамп данных таблицы `fw_documents_orderby`
-- 

INSERT INTO `fw_documents_orderby` (`id`, `name`, `orderby`, `orderbysc`, `status`) VALUES 
(1, 'Дате добавления', 'insert_date', 'DESC', '1'),
(2, 'Имени', 'name', 'ASC', '1'),
(3, 'Порядку', 'sort_order', 'ASC', '1');

-- --------------------------------------------------------

-- 
-- Структура таблицы `fw_forms`
-- 

CREATE TABLE `fw_forms` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `email` varchar(255) NOT NULL default '',
  `status` enum('0','1') NOT NULL default '1',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=4 ;

-- 
-- Дамп данных таблицы `fw_forms`
-- 

INSERT INTO `fw_forms` (`id`, `name`, `email`, `status`) VALUES 
(1, 'Сотрудничество', 'neon.lexx@mail.ru', '1'),
(3, 'asdfsdfdsfs', 'asdasdassdfds', '0');

-- --------------------------------------------------------

-- 
-- Структура таблицы `fw_forms_elements`
-- 

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
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=21 ;

-- 
-- Дамп данных таблицы `fw_forms_elements`
-- 

INSERT INTO `fw_forms_elements` (`id`, `parent`, `name`, `type`, `value`, `sort_order`, `status`) VALUES 
(1, 1, '*Телефон:*', 1, '', 2, '1'),
(2, 1, '*Имя и Фамилия:*', 1, '', 1, '1'),
(3, 1, '*E-mail:*', 1, 'aasd\r\nasdasd\r\n*asdasdas\r\ndas', 3, '1'),
(4, 1, 'Опыт работы в системе прямых продаж, организация сети (если есть):', 2, '', 5, '1'),
(5, 1, 'Ваше сообщение:', 2, '', 6, '1'),
(18, 1, '*Данные для заполнения:*', 0, '', 4, '1'),
(19, 1, '*Вид услуги:*', 3, 'первый вариант\r\nвторой вариант\r\n*активный третий вариант*\r\nчетвёртый вариант\r\nпятый вариант', 7, '1'),
(20, 1, 'Тоха', 3, 'да\r\n*нет*', 8, '0');

-- --------------------------------------------------------

-- 
-- Структура таблицы `fw_forum_posts`
-- 

CREATE TABLE `fw_forum_posts` (
  `id` int(11) NOT NULL auto_increment,
  `parent` int(11) NOT NULL default '0',
  `author` varchar(100) NOT NULL default '0',
  `text` text NOT NULL,
  `publish_date` int(15) NOT NULL default '0',
  `status` enum('1','0') NOT NULL default '1',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=4 ;

-- 
-- Дамп данных таблицы `fw_forum_posts`
-- 

INSERT INTO `fw_forum_posts` (`id`, `parent`, `author`, `text`, `publish_date`, `status`) VALUES 
(1, 1, '1', 'werewrwerer', 1157538991, '1'),
(2, 1, '1', 'uiouiouio', 1157539047, '1'),
(3, 2, 'rtytytr', 'rtytryrty', 1158217014, '1');

-- --------------------------------------------------------

-- 
-- Структура таблицы `fw_forum_threads`
-- 

CREATE TABLE `fw_forum_threads` (
  `id` int(11) NOT NULL auto_increment,
  `parent` int(11) NOT NULL default '0',
  `title` varchar(255) NOT NULL default '',
  `status` enum('1','0') NOT NULL default '1',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=3 ;

-- 
-- Дамп данных таблицы `fw_forum_threads`
-- 

INSERT INTO `fw_forum_threads` (`id`, `parent`, `title`, `status`) VALUES 
(1, 2, 'erwer', '1'),
(2, 2, 'yrtyrtyrtyr', '1');

-- --------------------------------------------------------

-- 
-- Структура таблицы `fw_forum_vp`
-- 

CREATE TABLE `fw_forum_vp` (
  `user_id` int(11) NOT NULL default '0',
  `thread_id` int(11) NOT NULL default '0',
  `forum_id` int(11) NOT NULL default '0',
  `view_time` int(15) NOT NULL default '0'
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

-- 
-- Дамп данных таблицы `fw_forum_vp`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `fw_forums`
-- 

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
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=3 ;

-- 
-- Дамп данных таблицы `fw_forums`
-- 

INSERT INTO `fw_forums` (`id`, `param_left`, `param_right`, `param_level`, `url`, `name`, `title`, `read_users`, `write_users`, `status`) VALUES 
(1, 1, 4, 0, '/', '/', '', 'all', 'all', '1'),
(2, 2, 3, 1, 'forum', 'Тестовый форум', '', 'all', 'all', '1');

-- --------------------------------------------------------

-- 
-- Структура таблицы `fw_guestbook`
-- 

CREATE TABLE `fw_guestbook` (
  `id` int(11) NOT NULL auto_increment,
  `author` varchar(255) NOT NULL default '',
  `message` text NOT NULL,
  `answer` text NOT NULL,
  `insert_date` int(15) NOT NULL default '0',
  `author_mail` varchar(255) NOT NULL default '',
  `status` enum('0','1') NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 AUTO_INCREMENT=1 ;

-- 
-- Дамп данных таблицы `fw_guestbook`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `fw_modules`
-- 

CREATE TABLE `fw_modules` (
  `id` tinyint(10) unsigned NOT NULL auto_increment,
  `name` varchar(20) NOT NULL default '',
  `title` varchar(20) NOT NULL default '',
  `section` varchar(20) NOT NULL default '',
  `priv` tinyint(10) NOT NULL default '1',
  `default_load` enum('0','1') NOT NULL default '0',
  `status` enum('0','1') NOT NULL default '1',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=22 ;

-- 
-- Дамп данных таблицы `fw_modules`
-- 

INSERT INTO `fw_modules` (`id`, `name`, `title`, `section`, `priv`, `default_load`, `status`) VALUES 
(1, 'tree', 'Структура сайта', 'admin_main', 1, '0', '1'),
(3, 'users', 'Пользователи', 'admin_main', 1, '0', '1'),
(4, 'page', 'Страницы', 'front_main', 1, '0', '1'),
(7, 'news', 'Новости', 'front_support', 1, '1', '1'),
(8, 'shop', 'Магазин', 'front_additional', 1, '1', '1'),
(9, 'modules', 'Модули', 'admin_main', 1, '0', '1'),
(10, 'edit_conf', 'Редактор настроек', 'admin_main', 0, '0', '1');

-- --------------------------------------------------------

-- 
-- Структура таблицы `fw_news`
-- 

CREATE TABLE `fw_news` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `title` varchar(255) NOT NULL default '',
  `small_text` text NOT NULL,
  `text` text NOT NULL,
  `publish_date` int(15) NOT NULL default '0',
  `image` varchar(50) NOT NULL default '',
  `cat_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=32 ;

-- 
-- Дамп данных таблицы `fw_news`
-- 

INSERT INTO `fw_news` (`id`, `title`, `small_text`, `text`, `publish_date`, `image`, `cat_id`) VALUES 
(31, 'Компания Vertu объявили о запуске двух новых моделей телефонов Vertu', 'На днях представители Vertu объявили о запуске двух новых моделей. Известный производитель мобильных телефонов класса люкс компания Vertu вновь пополняет свою коллекцию.', 'Известный производитель мобильных телефонов класса люкс компания Vertu снова пополняет свою коллекцию. На днях представители Vertu объявили о запуске двух новых моделей Vertu Ascent Ti - Ascent Ti Knurled и AscentTi Checked, отличающихся новыми элементами дизайна. Ведущей темой при разработке стиля моделей стали детали интерьера роскошных гоночных автомобилей. На корпусе Vertu Ascent Ti Knurled, выполненном из титана,выгравирован ромбовидный рисунок, задняя панель отделана серой, под сталь, кожей. Модель Vertu Ascent Ti Checked отличается спиралевидным рисунком и доступна в темно-лиловом цвете кожи. Цвет строчки, которой прошиты модели, и оформление клавиатуры совпадают с цветом кожи,которой отделан каждый телефон.', 1216124520, '', 0);

-- --------------------------------------------------------

-- 
-- Структура таблицы `fw_news_cat`
-- 

CREATE TABLE `fw_news_cat` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `url` varchar(150) NOT NULL default '',
  `text` text,
  `meta_description` varchar(100) default NULL,
  `meta_keywords` varchar(100) default NULL,
  `status` int(11) NOT NULL default '1',
  `sort_order` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=10 ;

-- 
-- Дамп данных таблицы `fw_news_cat`
-- 

INSERT INTO `fw_news_cat` (`id`, `name`, `url`, `text`, `meta_description`, `meta_keywords`, `status`, `sort_order`) VALUES 
(2, 'Категория1', 'cat1', 'text', NULL, NULL, 1, 1),
(4, 'тест', 'test', '<P><U>описание категории\r\n<SCRIPT></U></P></BODY></HTML></SCRIPT>\r\n</U></P>', NULL, NULL, 1, 5),
(7, 'категория3', 'cat3', NULL, NULL, NULL, 1, 2),
(9, 'categor', 'cat', 'asdas"''"<STRONG>sfsdfsdfsdfsdfds</STRONG>"''"dssdf', NULL, NULL, 1, 7);

-- --------------------------------------------------------

-- 
-- Структура таблицы `fw_orders`
-- 

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
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 AUTO_INCREMENT=1 ;

-- 
-- Дамп данных таблицы `fw_orders`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `fw_otr`
-- 

CREATE TABLE `fw_otr` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `title` varchar(255) NOT NULL default '',
  `small_text` text NOT NULL,
  `text` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=3 ;

-- 
-- Дамп данных таблицы `fw_otr`
-- 

INSERT INTO `fw_otr` (`id`, `title`, `small_text`, `text`) VALUES 
(1, 'Решение1', 'текст краткий', 'текст полный'),
(2, 'Решение2', 'текст текст', '<IMG height=500 alt="" src="/insertfiles/mers2.gif" width=380 border=0>текст текст текст');

-- --------------------------------------------------------

-- 
-- Структура таблицы `fw_photoalbum_cat`
-- 

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
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=2 ;

-- 
-- Дамп данных таблицы `fw_photoalbum_cat`
-- 

INSERT INTO `fw_photoalbum_cat` (`id`, `param_left`, `param_right`, `param_level`, `url`, `name`, `title`, `meta_keywords`, `meta_description`, `status`) VALUES 
(1, 1, 2, 0, '/', '/', '', '', '', '1');

-- --------------------------------------------------------

-- 
-- Структура таблицы `fw_photoalbum_comments`
-- 

CREATE TABLE `fw_photoalbum_comments` (
  `id` int(11) NOT NULL auto_increment,
  `photo_id` int(11) NOT NULL default '0',
  `author` varchar(255) NOT NULL default '',
  `comment` text NOT NULL,
  `insert_date` int(15) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 AUTO_INCREMENT=1 ;

-- 
-- Дамп данных таблицы `fw_photoalbum_comments`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `fw_photoalbum_images`
-- 

CREATE TABLE `fw_photoalbum_images` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `parent` int(11) unsigned NOT NULL default '0',
  `ext` char(3) NOT NULL default '',
  `title` varchar(255) NOT NULL default '',
  `link` varchar(60) NOT NULL default '',
  `insert_date` int(15) NOT NULL default '0',
  `sort_order` smallint(5) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 AUTO_INCREMENT=1 ;

-- 
-- Дамп данных таблицы `fw_photoalbum_images`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `fw_photoalbums`
-- 

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
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 AUTO_INCREMENT=1 ;

-- 
-- Дамп данных таблицы `fw_photoalbums`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `fw_polls`
-- 

CREATE TABLE `fw_polls` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `name` varchar(100) NOT NULL default '',
  `publish_date` int(15) NOT NULL default '0',
  `finish_date` int(15) NOT NULL default '0',
  `status` enum('0','1','2') NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 AUTO_INCREMENT=1 ;

-- 
-- Дамп данных таблицы `fw_polls`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `fw_polls_answers`
-- 

CREATE TABLE `fw_polls_answers` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `parent` int(15) unsigned NOT NULL default '0',
  `name` varchar(100) NOT NULL default '',
  `answers` int(5) NOT NULL default '0',
  `sort_order` tinyint(3) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 AUTO_INCREMENT=1 ;

-- 
-- Дамп данных таблицы `fw_polls_answers`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `fw_products`
-- 

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
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=28 ;

-- 
-- Дамп данных таблицы `fw_products`
-- 

INSERT INTO `fw_products` (`id`, `parent`, `name`, `title`, `small_description`, `description`, `additional_products`, `price`, `sale`, `rating`, `insert_date`, `status`, `sort_order`, `hit`) VALUES 
(26, 13, 'Vertu Signature Diamond Gold', 'Vertu Signature - Diamond Gold', 'Стандарт GSM 900/1800 <br>Интерфейс USB <br>Дисплей TFT 128х128 Пикселей <br>Доступ в интернет: GPRS,MMS,WAP, Bluetooth. <br>Память: встроенная 8 Мб, слот памяти до 2 Gb <br>Дополнительные функции: МР 3, MP4, виброзвонок, полифония, конвертер валют, диктофон. <br>Аккумулятор: Li-Ion 700mah. <br>Габариты: 122х42х15.5 mm <br>Вес: 170 грамм. <br>', 'Точная копия оригинала. Модель 2007 г. <br>Телефон продается в фирменной упаковке!&nbsp;В комплект входит: зарядное устройство, USB кабель, запасной аккумулятор.<br>Синхронизация с ПК без установки драйверов. Определяется как обычная флеш-карта. <br>Режим Веб-камеры без драйверов. <br>Поддержка языков: английский, русский, французский, немецкий, арабский.', '', 15000.00, 0, 0, 1217191492, '1', 1, '0');

-- --------------------------------------------------------

-- 
-- Структура таблицы `fw_products_comments`
-- 

CREATE TABLE `fw_products_comments` (
  `id` int(11) NOT NULL auto_increment,
  `product_id` int(11) NOT NULL default '0',
  `author` varchar(50) NOT NULL default '',
  `text` text NOT NULL,
  `insert_date` int(15) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 AUTO_INCREMENT=1 ;

-- 
-- Дамп данных таблицы `fw_products_comments`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `fw_products_images`
-- 

CREATE TABLE `fw_products_images` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `parent` int(11) unsigned NOT NULL default '0',
  `ext` varchar(4) NOT NULL default '',
  `title` varchar(255) NOT NULL default '',
  `link` varchar(60) NOT NULL default '',
  `sort_order` tinyint(5) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=11 ;

-- 
-- Дамп данных таблицы `fw_products_images`
-- 

INSERT INTO `fw_products_images` (`id`, `parent`, `ext`, `title`, `link`, `sort_order`) VALUES 
(10, 26, 'jpg', '', '', 2);

-- --------------------------------------------------------

-- 
-- Структура таблицы `fw_products_properties`
-- 

CREATE TABLE `fw_products_properties` (
  `product_id` int(10) unsigned NOT NULL default '0',
  `property_id` int(10) unsigned NOT NULL default '0',
  `value` text NOT NULL,
  PRIMARY KEY  (`product_id`,`property_id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

-- 
-- Дамп данных таблицы `fw_products_properties`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `fw_products_video`
-- 

CREATE TABLE `fw_products_video` (
  `id` int(11) NOT NULL auto_increment,
  `parent` int(11) NOT NULL default '0',
  `ext` varchar(255) NOT NULL default '',
  `title` varchar(255) NOT NULL default '',
  `sort_order` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=4 ;

-- 
-- Дамп данных таблицы `fw_products_video`
-- 

INSERT INTO `fw_products_video` (`id`, `parent`, `ext`, `title`, `sort_order`) VALUES 
(3, 24, 'mpeg', 'видео1', 1);

-- --------------------------------------------------------

-- 
-- Структура таблицы `fw_search`
-- 

CREATE TABLE `fw_search` (
  `url` varchar(255) NOT NULL default '',
  `title` varchar(255) NOT NULL default '',
  `content` longtext NOT NULL,
  PRIMARY KEY  (`url`),
  FULLTEXT KEY `content` (`content`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

-- 
-- Дамп данных таблицы `fw_search`
-- 

INSERT INTO `fw_search` (`url`, `title`, `content`) VALUES 
('http://cms', 'Главная страница', ' Главная страница Загрузка. Пожалуйста, подождите... Главная страница Мой кабинет Карта сайта Поиск Магазин Форум Новости Моя корзина Главная - Главная страница Главная страница Сотрудничество Имя и Фамилия: * Телефон: * E-mail: * Данные для заполнения: Опыт работы в системе прямых продаж, организация сети (если есть): Ваше сообщение: Вид услуги: * первый вариант второй вариант активный третий вариант четвёртый вариант пятый вариант dfbdfbdfb ''dfbvdffd """ sdfsdfgsdgsg ''sdgsd"gsd'' Страницы: sdf Pgt: 0.103 Queries: 8 sdfdsf '),
('http://cms/forum', 'Форум', ' Форум Загрузка. Пожалуйста, подождите... Главная страница Мой кабинет Карта сайта Поиск Магазин Форум Новости Моя корзина - Главная Форум Тем Последнее обновление Тестовый форум 2 14.09.2006 в 10:56 Pgt: 0.083 Queries: 7 sdfdsf '),
('http://cms/forum/forum', 'Форум', ' Форум Загрузка. Пожалуйста, подождите... Главная страница Мой кабинет Карта сайта Поиск Магазин Форум Новости Моя корзина Главная - Тестовый форум Тема Автор Ответов Последнее обновление yrtyrtyrtyr rtytytr 0 14.09.2006 в 10:56 erwer Test Petrovich 1 06.09.2006 в 14:37 Создать новую тему: * Ваше имя: * Название темы: B I U &laquo; Цитата &raquo; URL Pgt: 0.086 Queries: 9 sdfdsf '),
('http://cms/forum/forum/thread_1', 'Форум', ' Форум Загрузка. Пожалуйста, подождите... Главная страница Мой кабинет Карта сайта Поиск Магазин Форум Новости Моя корзина Главная - Тестовый форум - erwer Логин: Пароль: Регистрация Тема: erwer Test Petrovich Разработчик Всего сообщений: 2 Дата регистрации: 22.12.2006 werewrwerer 06.09.2006 в 14:36 Цитировать Test Petrovich Разработчик Всего сообщений: 2 Дата регистрации: 22.12.2006 uiouiouio 06.09.2006 в 14:37 Цитировать Ответить: * Ваше имя: B I U &laquo; Цитата &raquo; URL Pgt: 0.086 Queries: 10 sdfdsf '),
('http://cms/forum/forum/thread_2', 'Форум', ' Форум Загрузка. Пожалуйста, подождите... Главная страница Мой кабинет Карта сайта Поиск Магазин Форум Новости Моя корзина Главная - Тестовый форум - yrtyrtyrtyr Логин: Пароль: Регистрация Тема: yrtyrtyrtyr rtytytr rtytryrty 14.09.2006 в 10:56 Цитировать Ответить: * Ваше имя: B I U &laquo; Цитата &raquo; URL Pgt: 0.091 Queries: 10 sdfdsf '),
('http://cms/home', 'Главная страница', ' Главная страница Загрузка. Пожалуйста, подождите... Главная страница Мой кабинет Карта сайта Поиск Магазин Форум Новости Моя корзина Главная - Главная страница Главная страница Сотрудничество Имя и Фамилия: * Телефон: * E-mail: * Данные для заполнения: Опыт работы в системе прямых продаж, организация сети (если есть): Ваше сообщение: Вид услуги: * первый вариант второй вариант активный третий вариант четвёртый вариант пятый вариант dfbdfbdfb ''dfbvdffd """ sdfsdfgsdgsg ''sdgsd"gsd'' Страницы: sdf Pgt: 0.088 Queries: 8 sdfdsf '),
('http://cms/home/dsfsd', 'sdf', ' sdf Загрузка. Пожалуйста, подождите... Главная страница Мой кабинет Карта сайта Поиск Магазин Форум Новости Моя корзина Главная - Главная страница - sdf sdf Pgt: 0.084 Queries: 8 sdfdsf '),
('http://cms/map', 'Карта сайта', ' Карта сайта Загрузка. Пожалуйста, подождите... Главная страница Мой кабинет Карта сайта Поиск Магазин Форум Новости Моя корзина Главная - Карта сайта Мой кабинет Вход в систему Регистрация Выйти из системы Карта сайта Поиск Магазин Тестовый раздел 1 Тестовый раздел 2 Форум Новости fghfg Pgt: 0.075 Queries: 8 sdfdsf '),
('http://cms/news', 'Новости', ' Новости Загрузка. Пожалуйста, подождите... Главная страница Мой кабинет Карта сайта Поиск Магазин Форум Новости Моя корзина Главная - Новости [21.09.2006 17:36] fghfg hfghfghfgh [ читать дальше ] [ архив новостей ] Pgt: 0.072 Queries: 6 sdfdsf '),
('http://cms/news/archive', 'Новости - Архив', ' Новости - Архив Загрузка. Пожалуйста, подождите... Главная страница Мой кабинет Карта сайта Поиск Магазин Форум Новости Моя корзина Главная - Новости - Архив [21.09.2006 17:36] fghfg hfghfghfgh [ читать дальше ] Страница: 1 >> Pgt: 0.072 Queries: 7 sdfdsf '),
('http://cms/news/archive/4', 'Новости - fghfg', ' Новости - fghfg Загрузка. Пожалуйста, подождите... Главная страница Мой кабинет Карта сайта Поиск Магазин Форум Новости Моя корзина Главная - Новости - Архив - fghfg [21.09.2006 17:36] fghfg hfghfghfgh Pgt: 0.071 Queries: 6 sdfdsf '),
('http://cms/news/archive/page_1', 'Новости - Архив', ' Новости - Архив Загрузка. Пожалуйста, подождите... Главная страница Мой кабинет Карта сайта Поиск Магазин Форум Новости Моя корзина Главная - Новости - Архив [21.09.2006 17:36] fghfg hfghfghfgh [ читать дальше ] Страница: 1 >> Pgt: 0.071 Queries: 7 sdfdsf '),
('http://cms/search', 'Поиск', ' Поиск Загрузка. Пожалуйста, подождите... Главная страница Мой кабинет Карта сайта Поиск Магазин Форум Новости Моя корзина Главная - Поиск Pgt: 0.075 Queries: 5 sdfdsf '),
('http://cms/shop', 'Магазин', ' Магазин Загрузка. Пожалуйста, подождите... Главная страница Мой кабинет Карта сайта Поиск Магазин Форум Новости Моя корзина Главная - Магазин  Тестовый раздел 1 [1]  Тестовый раздел 2 Pgt: 0.084 Queries: 9 sdfdsf '),
('http://cms/shop/basket', 'Магазин', ' Магазин Загрузка. Пожалуйста, подождите... Главная страница Мой кабинет Карта сайта Поиск Магазин Форум Новости Моя корзина Главная - Магазин - Моя корзина В Вашей корзине нет товаров. Перейти в каталог товаров Pgt: 0.077 Queries: 7 sdfdsf '),
('http://cms/shop/basket/add/1', '', '1'),
('http://cms/shop/test1', 'Тестовый раздел 1', ' Тестовый раздел 1 Загрузка. Пожалуйста, подождите... Главная страница Мой кабинет Карта сайта Поиск Магазин Форум Новости Моя корзина Главная - Магазин - Тестовый раздел 1 Продукты в данной категории: Сортировать по: цене , дате , алфавиту Нет изображения sdfsd Сравнить fsdfsdf Подробнее Кол-во: 1 2 3 4 5 6 7 8 9 10 Цена: 41.00 ?. [ Добавить в корзину ] Pgt: 0.079 Queries: 9 sdfdsf '),
('http://cms/shop/test1/1', 'sfs', ' sfs Загрузка. Пожалуйста, подождите... Главная страница Мой кабинет Карта сайта Поиск Магазин Форум Новости Моя корзина Главная - Магазин - Тестовый раздел 1 - sdfsd sdfsd sdfsfsf dsfsdf Кол-во: 1 2 3 4 5 6 7 8 9 10 Цена: 41.00 ?. [ Добавить в корзину ] Фотогалерея продукта: Рейтинг продукта: 0 Комментирование и голосование доступны только зарегестрированным пользователям. Комментарии пользователей: Pgt: 0.080 Queries: 12 sdfdsf '),
('http://cms/shop/test2', 'Тестовый раздел 2', ' Тестовый раздел 2 Загрузка. Пожалуйста, подождите... Главная страница Мой кабинет Карта сайта Поиск Магазин Форум Новости Моя корзина Главная - Магазин - Тестовый раздел 2 Pgt: 0.079 Queries: 9 sdfdsf '),
('http://cms/users/login', 'Мой кабинет', ' Мой кабинет Загрузка. Пожалуйста, подождите... Главная страница Мой кабинет Карта сайта Поиск Магазин Форум Новости Моя корзина Главная - Мой кабинет - Вход Логин: Пароль: Регистрация Запомнить меня Pgt: 0.091 Queries: 5 sdfdsf '),
('http://cms/users/logout', '', ' Notice : Undefined index: HTTP_REFERER in d:\\home\\cms\\modules\\cabinet\\front\\cabinet.f_main.php on line 68 Warning : Cannot modify header information - headers already sent by (output started at d:\\home\\cms\\modules\\cabinet\\front\\cabinet.f_main.php:68) in d:\\home\\cms\\modules\\cabinet\\front\\cabinet.f_main.php on line 69 '),
('http://cms/users/register', 'Мой кабинет', ' Мой кабинет Загрузка. Пожалуйста, подождите... Главная страница Мой кабинет Карта сайта Поиск Магазин Форум Новости Моя корзина Главная - Мой кабинет - Регистрация * Ф.И.О: * Логин: * Пароль: * E-mail 1 : * Телефон: * Адрес доставки: 1 Настоятельно рекомендуем Вам указывать существующий адрес, так как на него будут высылаться копии Ваших заказов и прочая важная информация. Pgt: 0.079 Queries: 5 sdfdsf ');

-- --------------------------------------------------------

-- 
-- Структура таблицы `fw_search_statistics`
-- 

CREATE TABLE `fw_search_statistics` (
  `query` varchar(255) NOT NULL default '',
  `number` int(11) NOT NULL default '0',
  KEY `query` (`query`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

-- 
-- Дамп данных таблицы `fw_search_statistics`
-- 

INSERT INTO `fw_search_statistics` (`query`, `number`) VALUES 
('', 1),
('ergerger', 1),
('ыаыаваыва', 1),
('магазин', 1),
('quer', 2),
('qu', 1),
('q', 1),
('главная', 27);

-- --------------------------------------------------------

-- 
-- Структура таблицы `fw_subscribe_groups`
-- 

CREATE TABLE `fw_subscribe_groups` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 AUTO_INCREMENT=1 ;

-- 
-- Дамп данных таблицы `fw_subscribe_groups`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `fw_subscribe_list`
-- 

CREATE TABLE `fw_subscribe_list` (
  `id` int(11) NOT NULL auto_increment,
  `mail` varchar(255) NOT NULL default '',
  `group_id` int(11) NOT NULL default '0',
  `reg_date` int(15) NOT NULL default '0',
  `status` enum('0','1') NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `mail` (`mail`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 AUTO_INCREMENT=1 ;

-- 
-- Дамп данных таблицы `fw_subscribe_list`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `fw_subscribe_templates`
-- 

CREATE TABLE `fw_subscribe_templates` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `template` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 AUTO_INCREMENT=1 ;

-- 
-- Дамп данных таблицы `fw_subscribe_templates`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `fw_tables`
-- 

CREATE TABLE `fw_tables` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `format` char(3) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=6 ;

-- 
-- Дамп данных таблицы `fw_tables`
-- 

INSERT INTO `fw_tables` (`id`, `name`, `format`) VALUES 
(1, '???????? ??????? 1', 'csv'),
(2, '???????? ??????? 2', 'xls'),
(3, '???????? ??????? 3', 'xls'),
(4, 'sd', 'xls'),
(5, 'ст', 'xls');

-- --------------------------------------------------------

-- 
-- Структура таблицы `fw_templates`
-- 

CREATE TABLE `fw_templates` (
  `id` int(10) NOT NULL auto_increment,
  `name` varchar(50) NOT NULL default '',
  `file` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=5 ;

-- 
-- Дамп данных таблицы `fw_templates`
-- 

INSERT INTO `fw_templates` (`id`, `name`, `file`) VALUES 
(2, 'Основной', 'index.html');

-- --------------------------------------------------------

-- 
-- Структура таблицы `fw_tree`
-- 

CREATE TABLE `fw_tree` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `param_left` int(11) unsigned NOT NULL default '0',
  `param_right` int(11) unsigned NOT NULL default '0',
  `param_level` int(11) unsigned NOT NULL default '0',
  `url` varchar(20) NOT NULL default '',
  `text` longtext NOT NULL,
  `name` varchar(255) NOT NULL default '',
  `title` varchar(255) NOT NULL default '',
  `image` varchar(255) NOT NULL default '',
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
  `show_nodes` enum('0','1') NOT NULL default '1',
  `show_documents` enum('0','1') NOT NULL default '1',
  `show_documents_number` int(11) NOT NULL default '0',
  `show_documents_orderby` int(11) NOT NULL default '0',
  `documents_template` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `url` (`url`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 PACK_KEYS=0 AUTO_INCREMENT=36 ;

-- 
-- Дамп данных таблицы `fw_tree`
-- 

INSERT INTO `fw_tree` (`id`, `param_left`, `param_right`, `param_level`, `url`, `text`, `name`, `title`, `image`, `meta_keywords`, `meta_description`, `module`, `support_modules`, `elements`, `template`, `status`, `access_users`, `access_groups`, `in_menu`, `show_nodes`, `show_documents`, `show_documents_number`, `show_documents_orderby`, `documents_template`) VALUES 
(14, 1, 12, 0, '/', '', '/', '', '', '', '', '', '', '', '', '1', '', '', '1', '1', '1', 0, 0, ''),
(31, 2, 3, 1, 'home', 'Главная страница сайта<br>', 'Главная страница', 'Интернет-магазин телефонов Vertu (Верту), Royal VX, Mobiado (Мобиадо)', '', '', '', 'page', 'news', '\n{if $page_content}\n	<p>{eval var=$page_content.text|stripslashes}</p>\n{/if}\n\n{if $subpages}\n	<p>Страницы:</p>\n	<ul>\n		{$subpages}\n	</ul>\n{/if}\n\n{if $documents}\n	<p>Документы:</p>\n	<table width="100%" border="1">\n		{$documents}\n	</table>\n\n	{if $total_pages>1}\n	<p align="center">\n	Страница: <a href="{$page_content.full_url}page_1/"><<</a>\n\n	{section name=p loop=$pages}\n		{if $pages[p]==$current_page}\n		{$pages[p]}\n		{else}\n		<a href="{$page_content.full_url}page_{$pages[p]}/">{$pages[p]}</a>\n		{/if}\n	{/section}\n\n	<a href="{$page_content.full_url}page_{$total_pages}/">>></a>\n	</p>\n	{/if}\n{/if}\n', 'index.html', '1', 'all', 'all', '1', '1', '1', 10, 0, 'documents_list.html'),
(32, 4, 5, 1, 'news', '', 'Новости', 'Новости', '', '', '', 'news', '', '', 'index.html', '1', 'all', '', '1', '1', '1', 10, 0, ''),
(33, 6, 7, 1, 'shop', '', 'Каталог', 'Каталог', '', '', '', 'shop', '', '{$main}', 'index.html', '1', 'all', '', '1', '1', '1', 10, 0, ''),
(34, 8, 9, 1, 'order', 'Доставляем заказанный товар в любую точку Москвы и ближайшего подмосковья.<br><br>Наш курьер оперативно свяжется с Вами и быстро выполнит заказ.<br><br>Стоимость доставки с курьером составляет 300 рублей.<br>', 'Доставка', 'Доставка', '', '', '', 'page', '', '\n{if $page_content}\n	<p>{eval var=$page_content.text|stripslashes}</p>\n{/if}\n\n{if $subpages}\n	<p>Страницы:</p>\n	<ul>\n		{$subpages}\n	</ul>\n{/if}\n\n{if $documents}\n	<p>Документы:</p>\n	<table width="100%" border="1">\n		{$documents}\n	</table>\n\n	{if $total_pages>1}\n	<p align="center">\n	Страница: <a href="{$page_content.full_url}page_1/"><<</a>\n\n	{section name=p loop=$pages}\n		{if $pages[p]==$current_page}\n		{$pages[p]}\n		{else}\n		<a href="{$page_content.full_url}page_{$pages[p]}/">{$pages[p]}</a>\n		{/if}\n	{/section}\n\n	<a href="{$page_content.full_url}page_{$total_pages}/">>></a>\n	</p>\n	{/if}\n{/if}\n', 'index.html', '1', 'all', 'all', '1', '1', '1', 10, 0, 'documents_list.html'),
(35, 10, 11, 1, 'contacts', 'Сделать заказ, получить любую информацию по работе магазина или о товаре можно позвонив по телефону:<br>8-926-836-64-39 (Дмитрий).<br>', 'Контакты', 'Контакты', '', '', '', 'page', '', '\n{if $page_content}\n	<p>{eval var=$page_content.text|stripslashes}</p>\n{/if}\n\n{if $subpages}\n	<p>Страницы:</p>\n	<ul>\n		{$subpages}\n	</ul>\n{/if}\n\n{if $documents}\n	<p>Документы:</p>\n	<table width="100%" border="1">\n		{$documents}\n	</table>\n\n	{if $total_pages>1}\n	<p align="center">\n	Страница: <a href="{$page_content.full_url}page_1/"><<</a>\n\n	{section name=p loop=$pages}\n		{if $pages[p]==$current_page}\n		{$pages[p]}\n		{else}\n		<a href="{$page_content.full_url}page_{$pages[p]}/">{$pages[p]}</a>\n		{/if}\n	{/section}\n\n	<a href="{$page_content.full_url}page_{$total_pages}/">>></a>\n	</p>\n	{/if}\n{/if}\n', 'index.html', '1', 'all', 'all', '1', '1', '1', 10, 0, 'documents_list.html');

-- --------------------------------------------------------

-- 
-- Структура таблицы `fw_urls`
-- 

CREATE TABLE `fw_urls` (
  `id` int(11) NOT NULL auto_increment,
  `url_from` varchar(255) NOT NULL default '',
  `url_to` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=361 ;

-- 
-- Дамп данных таблицы `fw_urls`
-- 

INSERT INTO `fw_urls` (`id`, `url_from`, `url_to`) VALUES 
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
(249, '', 'http://cms/shop/test1/index.xml'),
(250, '', 'http://cms/favicon.ico/'),
(251, 'http://cms/forum/', 'http://cms/templates/img/forum_3.gif/'),
(252, 'http://cms/forum/', 'http://cms/templates/img/for_01.jpg/'),
(253, 'http://cms/forum/', 'http://cms/templates/img/forum_2.gif/'),
(254, '', 'http://cms/favicon.ico/'),
(255, 'http://evgeny/', 'http://cms/cms/'),
(256, 'http://evgeny/', 'http://cms/cms/'),
(257, 'http://evgeny', 'http://cms/cms/'),
(258, 'http://evgeny', 'http://cms/cms/'),
(259, 'http://evgeny', 'http://cms/cms/'),
(260, 'http://cms/admin/index.php?mod=news', 'http://cms/uploaded_files/news/resized-5.jpg/'),
(261, 'http://cms/admin/index.php?mod=news', 'http://cms/uploaded_files/news/resized-5.jpg/'),
(262, 'http://cms/admin/index.php?mod=news', 'http://cms/uploaded_files/news/resized-5.jpg/'),
(263, 'http://cms/news/cat1/archive/', 'http://cms/uploaded_files/news/resized-5.jpg/'),
(264, 'http://cms/admin/index.php?mod=news', 'http://cms/uploaded_files/news/resized-5.jpg/'),
(265, 'http://cms/admin/index.php?mod=news', 'http://cms/uploaded_files/news/resized-5.jpg/'),
(266, 'http://cms/admin/?mod=tree&action=edit_document&id=7', 'http://cms/uploaded_files/tree_images/7.jpg/'),
(267, 'http://cms/home/dsfsd/', 'http://cms/home/dsfsd/item_13/'),
(268, 'http://cms/home/dsfsd/', 'http://cms/home/dsfsd/item_13/'),
(269, 'http://cms/home/dsfsd/', 'http://cms/uploaded_files/documents_tree/resized-3.jpg/'),
(270, '', 'http://cms/home/dsfsd/page_2/'),
(271, 'http://cms/forum/', 'http://cms/templates/img/forum_3.gif/'),
(272, 'http://cms/forum/', 'http://cms/templates/img/for_01.jpg/'),
(273, 'http://cms/forum/', 'http://cms/templates/img/forum_2.gif/'),
(274, '', 'http://varsstrap.pixon.ru/favicon.ico/'),
(275, 'http://varsstrap.pixon.ru/', 'http://varsstrap.pixon.ru/shop/'),
(276, 'http://varsstrap.pixon.ru/admin/index.php?mod=news', 'http://varsstrap.pixon.ru/uploaded_files/news/resized-5.jpg/'),
(277, 'http://varsstrap.pixon.ru/admin/index.php?mod=news', 'http://varsstrap.pixon.ru/uploaded_files/news/resized-5.jpg/'),
(278, 'http://varsstrap.pixon.ru/admin/index.php?mod=news', 'http://varsstrap.pixon.ru/uploaded_files/news/resized-5.jpg/'),
(279, 'http://varsstrap.pixon.ru/admin/index.php?mod=news', 'http://varsstrap.pixon.ru/uploaded_files/news/resized-5.jpg/'),
(280, 'http://varsstrap.pixon.ru/admin/index.php?mod=news', 'http://varsstrap.pixon.ru/uploaded_files/news/resized-5.jpg/'),
(281, 'http://varsstrap.pixon.ru/admin/index.php?mod=news', 'http://varsstrap.pixon.ru/uploaded_files/news/resized-5.jpg/'),
(282, 'http://varsstrap.pixon.ru/admin/index.php?mod=news', 'http://varsstrap.pixon.ru/uploaded_files/news/resized-5.jpg/'),
(283, 'http://varsstrap.pixon.ru/admin/index.php?mod=news', 'http://varsstrap.pixon.ru/uploaded_files/news/resized-5.jpg/'),
(284, 'http://varsstrap.pixon.ru/admin/index.php?mod=news', 'http://varsstrap.pixon.ru/uploaded_files/news/resized-5.jpg/'),
(285, 'http://varsstrap.pixon.ru/admin/index.php?mod=news', 'http://varsstrap.pixon.ru/uploaded_files/news/resized-5.jpg/'),
(286, 'http://varsstrap.pixon.ru/admin/index.php?mod=news', 'http://varsstrap.pixon.ru/uploaded_files/news/resized-5.jpg/'),
(287, 'http://varsstrap.pixon.ru/admin/index.php?mod=news', 'http://varsstrap.pixon.ru/uploaded_files/news/resized-5.jpg/'),
(288, 'http://varsstrap.pixon.ru/admin/index.php?mod=news', 'http://varsstrap.pixon.ru/uploaded_files/news/resized-5.jpg/'),
(289, 'http://varsstrap.pixon.ru/admin/index.php?mod=news', 'http://varsstrap.pixon.ru/uploaded_files/news/resized-5.jpg/'),
(290, 'http://varsstrap.pixon.ru/admin/index.php?mod=news', 'http://varsstrap.pixon.ru/uploaded_files/news/resized-5.jpg/'),
(291, 'http://varsstrap.pixon.ru/admin/index.php?mod=news', 'http://varsstrap.pixon.ru/uploaded_files/news/resized-5.jpg/'),
(292, '', 'http://varsstrap.pixon.ru/uploaded_files/shop_images/3.mpeg/'),
(293, '', 'http://varsstrap.pixon.ru/uploaded_files/shop_images/3.mpeg/'),
(294, '', 'http://varsstrap.pixon.ru/favicon.ico/'),
(295, 'http://varsstrap.pixon.ru/', 'http://varsstrap.pixon.ru/cat1/cat1-1/'),
(296, 'http://varsstrap.pixon.ru/', 'http://varsstrap.pixon.ru/catalog/cat1/cat1-1//24/'),
(297, 'http://varsstrap.pixon.ru/', 'http://varsstrap.pixon.ru/uploaded_files/shop_images/'),
(298, 'http://varsstrap.pixon.ru/javascript/editor/assetmanager/assetmanager.php?lang=russian&ffilter=image', 'http://varsstrap.pixon.ru/insertfiles/%D0%BA%D0%B0%D1%80%D1%82%D1%80%D0%B8%D0%B4%D0%B6.jpg/'),
(299, 'http://varsstrap.pixon.ru/javascript/editor/assetmanager/assetmanager.php?lang=russian&ffilter=image', 'http://varsstrap.pixon.ru/insertfiles/%D0%BA%D0%B0%D1%80%D1%82%D1%80%D0%B8%D0%B4%D0%B6.jpg/'),
(300, 'http://varsstrap.pixon.ru/javascript/editor/assetmanager/assetmanager.php?lang=russian&ffilter=image', 'http://varsstrap.pixon.ru/insertfiles/%D0%BA%D0%B0%D1%80%D1%82%D1%80%D0%B8%D0%B4%D0%B6.jpg/'),
(301, 'http://varsstrap.pixon.ru/javascript/editor/assetmanager/assetmanager.php?lang=russian&ffilter=image', 'http://varsstrap.pixon.ru/insertfiles/%D0%BA%D0%B0%D1%80%D1%82%D1%80%D0%B8%D0%B4%D0%B6.jpg/'),
(302, 'http://varsstrap.pixon.ru/javascript/editor/assetmanager/assetmanager.php?lang=russian&ffilter=image', 'http://varsstrap.pixon.ru/insertfiles/%D0%BF%D1%80%D0%B8%D0%BA1.jpg/'),
(303, 'http://varsstrap.pixon.ru/javascript/editor/assetmanager/assetmanager.php?lang=russian&ffilter=image', 'http://varsstrap.pixon.ru/insertfiles/%D0%BF%D1%80%D0%B8%D0%BA1.jpg/'),
(304, 'http://varsstrap.pixon.ru/javascript/editor/assetmanager/assetmanager.php?lang=russian&ffilter=image', 'http://varsstrap.pixon.ru/insertfiles/%D0%BF%D1%80%D0%B8%D0%BA1.jpg/'),
(305, 'http://varsstrap.pixon.ru/javascript/editor/assetmanager/assetmanager.php?lang=russian&ffilter=image', 'http://varsstrap.pixon.ru/insertfiles/%D0%BA%D0%B0%D1%80%D1%82%D1%80%D0%B8%D0%B4%D0%B6.jpg/'),
(306, 'http://varsstrap.pixon.ru/javascript/editor/assetmanager/assetmanager.php?lang=russian&ffilter=image', 'http://varsstrap.pixon.ru/insertfiles/%D0%BA%D0%B0%D1%80%D1%82%D1%80%D0%B8%D0%B4%D0%B6.jpg/'),
(307, 'http://varsstrap.pixon.ru/javascript/editor/assetmanager/assetmanager.php?lang=russian&ffilter=image', 'http://varsstrap.pixon.ru/insertfiles/%D0%BA%D0%B0%D1%80%D1%82%D1%80%D0%B8%D0%B4%D0%B6.jpg/'),
(308, 'http://varsstrap.pixon.ru/javascript/editor/assetmanager/assetmanager.php?lang=russian&ffilter=image', 'http://varsstrap.pixon.ru/insertfiles/%D0%BA%D0%B0%D1%80%D1%82%D1%80%D0%B8%D0%B4%D0%B6.jpg/'),
(309, 'http://varsstrap.pixon.ru/admin/index.php?mod=news&action=add', 'http://varsstrap.pixon.ru/_js/notepad2.js/'),
(310, 'http://varsstrap.pixon.ru/admin/index.php?mod=news&action=add', 'http://varsstrap.pixon.ru/_css/style.css/'),
(311, 'http://varsstrap.pixon.ru/admin/index.php?mod=news&action=add', 'http://varsstrap.pixon.ru/_css/last.css/'),
(312, 'http://demo.efaculty.ru/', 'http://demo.efaculty.ru/uploaded_files/shop_images/resized-1.gif/'),
(313, 'http://demo.efaculty.ru/', 'http://demo.efaculty.ru/uploaded_files/banners/2.gif/'),
(314, 'http://demo.efaculty.ru/', 'http://demo.efaculty.ru/uploaded_files/banners/2.gif/'),
(315, 'http://demo.efaculty.ru/', 'http://demo.efaculty.ru/uploaded_files/banners/2.gif/'),
(316, 'http://demo.efaculty.ru/', 'http://demo.efaculty.ru/uploaded_files/banners/2.gif/'),
(317, 'http://demo.efaculty.ru/', 'http://demo.efaculty.ru/logo.jpg/'),
(318, 'http://demo.efaculty.ru/', 'http://demo.efaculty.ru/topmenu_vline.jpg/'),
(319, 'http://demo.efaculty.ru/', 'http://demo.efaculty.ru/catalog.jpg/'),
(320, 'http://demo.efaculty.ru/', 'http://demo.efaculty.ru/but_bot.jpg/'),
(321, 'http://demo.efaculty.ru/', 'http://demo.efaculty.ru/clear.gif/'),
(322, 'http://demo.efaculty.ru/shop/cat1/cat1-1/', 'http://demo.efaculty.ru/uploaded_files/shop_images/resized-1.gif/'),
(323, 'http://demo.efaculty.ru/order/', 'http://demo.efaculty.ru/contacts/'),
(324, 'http://demo.efaculty.ru/order/', 'http://demo.efaculty.ru/contacts/'),
(325, 'http://demo.efaculty.ru/order/', 'http://demo.efaculty.ru/contacts/'),
(326, 'http://demo.efaculty.ru/shop/vertu/26/', 'http://demo.efaculty.ru/shop/vertu/26/gallery/'),
(327, 'http://demo.efaculty.ru/shop/', 'http://demo.efaculty.ru/uploaded_files/shop_images/cat-14.jpg/'),
(328, 'http://demo.efaculty.ru/shop/', 'http://demo.efaculty.ru/uploaded_files/shop_images/cat-14.jpg/'),
(329, 'http://demo.efaculty.ru/admin/index.php?mod=shop&action=edit_cat&id=14', 'http://demo.efaculty.ru/uploaded_files/shop_images/cat-14.jpg/'),
(330, 'http://demo.efaculty.ru/shop/', 'http://demo.efaculty.ru/nokia/27/'),
(331, 'http://demo.efaculty.ru/shop/', 'http://demo.efaculty.ru/nokia/27/'),
(332, '', 'http://demo.efaculty.ru/favicon.ico/'),
(333, '', 'http://demo.efaculty.ru/favicon.ico/'),
(334, '', 'http://demo.efaculty.ru/favicon.ico/'),
(335, '', 'http://www.blmobile.ru/favicon.ico/'),
(336, '', 'http://www.blmobile.ru/favicon.ico/'),
(337, '', 'http://www.blmobile.ru/favicon.ico/'),
(338, '', 'http://www.blmobile.ru/favicon.ico/'),
(339, '', 'http://www.blmobile.ru/favicon.ico/'),
(340, '', 'http://www.blmobile.ru/favicon.ico/'),
(341, '', 'http://www.blmobile.ru/favicon.ico/'),
(342, '', 'http://www.blmobile.ru/favicon.ico/'),
(343, '', 'http://www.blmobile.ru/favicon.ico/'),
(344, '', 'http://www.blmobile.ru/favicon.ico/'),
(345, 'http://blmobile.ru/', 'http://www.blmobile.ru/favicon.ico/'),
(346, 'http://www.blmobile.ru/news/', 'http://www.blmobile.ru/favicon.ico/'),
(347, '', 'http://www.blmobile.ru/favicon.ico/'),
(348, '', 'http://www.blmobile.ru/favicon.ico/'),
(349, '', 'http://www.blmobile.ru/favicon.ico/'),
(350, '', 'http://www.blmobile.ru/favicon.ico/'),
(351, '', 'http://www.blmobile.ru/favicon.ico/'),
(352, '', 'http://www.blmobile.ru/favicon.ico/'),
(353, '', 'http://www.blmobile.ru/favicon.ico/'),
(354, '', 'http://www.blmobile.ru/favicon.ico/'),
(355, '', 'http://www.blmobile.ru/favicon.ico/'),
(356, '', 'http://www.blmobile.ru/favicon.ico/'),
(357, '', 'http://www.blmobile.ru/favicon.ico/'),
(358, '', 'http://www.blmobile.ru/favicon.ico/'),
(359, '', 'http://www.blmobile.ru/favicon.ico/'),
(360, '', 'http://www.blmobile.ru/favicon.ico/');

-- --------------------------------------------------------

-- 
-- Структура таблицы `fw_users`
-- 

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
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=6 ;

-- 
-- Дамп данных таблицы `fw_users`
-- 

INSERT INTO `fw_users` (`id`, `login`, `password`, `name`, `mail`, `tel`, `deliver`, `send_forum_answers`, `reg_date`, `group_id`, `status`) VALUES 
(1, 'admin', 'd9d1b168eac8f197e0576b56cfc23ece', 'Test Petrovich', 'test@test.com', '0451051510', 'tgrgtrbrbtbr', '', 0, 1, '1'),
(4, 'shand', 'b023cf413b9bb1ec10062ac92ad4a183', 'shand', 'shand@yandex.ru', '111', '45454', '', 1182841866, 5, '1'),
(5, 'dima', '5b48ebd944c64524268b0837e72b33a8', 'Дима', 'yakatut@mail.ru', '', '', '', 1217502425, 2, '1');

-- --------------------------------------------------------

-- 
-- Структура таблицы `fw_users_groups`
-- 

CREATE TABLE `fw_users_groups` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `priv` tinyint(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=6 ;

-- 
-- Дамп данных таблицы `fw_users_groups`
-- 

INSERT INTO `fw_users_groups` (`id`, `name`, `priv`) VALUES 
(1, 'Разработчик', 0),
(2, 'Администратор', 1),
(3, 'Оператор', 5),
(4, 'Демо', 8),
(5, 'Пользователь', 9);
