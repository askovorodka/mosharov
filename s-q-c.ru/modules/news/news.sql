INSERT IGNORE INTO fw_modules (id, name, title, section, status) VALUES (7, 'news', 'Новости', 'front_support', '1');
INSERT IGNORE INTO fw_conf (conf_key, conf_value, section) VALUES ('NEWS_PER_PAGE', '30', 'news');
INSERT IGNORE INTO fw_conf (conf_key, conf_value, section) VALUES ('NEWS_PER_PAGE_FRONT_ARCHIVE', '10', 'news');
DROP TABLE IF EXISTS fw_news;
CREATE TABLE IF NOT EXISTS fw_news (id int(11) unsigned NOT NULL auto_increment,title varchar(255) NOT NULL default '',small_text text NOT NULL,text text NOT NULL,publish_date int(15) NOT NULL default '0',PRIMARY KEY  (id));