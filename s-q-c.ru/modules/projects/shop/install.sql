DROP TABLE IF EXISTS fw_projects;
CREATE TABLE fw_projects(id integer not null auto_increment,name varchar(255) not null,publish_date integer not null,sort_order integer not null,cat_id integer not null,primary key(id),foreign key (cat_id) references fw_categor);
DROP TABLE IF EXISTS fw_categor;
CREATE TABLE fw_categor (id integer not null auto_increment,name varchar(255) not null,primary key(id));
DROP TABLE IF EXISTS fw_ferms;
CREATE TABLE fw_ferms (id integer not null auto_increment,name varchar(255) not null,publish_date integer not null,sort_order integer not null,cat_id integer not null,primary key (id),foreign key(cat_id) REFERENCES fw_categor) ENGINE = INNODB;
DROP TABLE IF EXISTS fw_ferms_urls;
CREATE TABLE fw_ferms_urls (id INTEGER NOT NULL AUTO_INCREMENT, ferm_id INTEGER NOT NULL, url VARCHAR(255) NOT NULL, PRIMARY KEY (id),INDEX(ferm_id),FOREIGN KEY (ferm_id) REFERENCES fw_ferms.id ON UPDATE CASCADE ON DELETE CASCADE) ENGINE = INNODB;