INSERT IGNORE INTO fw_modules (name, title, section, status) VALUES ('otr', 'Отраслевые решения', 'front_support', '1');
INSERT IGNORE INTO fw_conf (conf_key, conf_value, section,name,section_name) VALUES ('OTR_PER_PAGE', '30', 'otr','Отраслевых решений на страницу','Отраслевые решения');
DROP TABLE IF EXISTS fw_otr;
CREATE TABLE IF NOT EXISTS fw_otr (id int(11) unsigned NOT NULL auto_increment,title varchar(255) NOT NULL default '',small_text text NOT NULL,text text NOT NULL,PRIMARY KEY  (id));
