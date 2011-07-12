INSERT IGNORE INTO fw_modules (id, name, title, section, status) VALUES (NULL,'categors', 'Категории', 'front_support', '1');
DROP TABLE IF EXISTS fw_categors;
CREATE TABLE fw_categors (id integer not null auto_increment,name varchar(255) not null, primary key (id));