INSERT IGNORE INTO fw_modules (id, name, title, section, status) VALUES (NULL,'ferms', 'Фермы', 'front_support', '1');
DROP TABLE IF EXISTS fw_ferms;
CREATE TABLE fw_ferms (id integer not null auto_increment,name varchar(255) not null, publish_date integer not null, sort_order integer not null,cat_id integer not null,primary key (id), foreign key(cat_id) references fw_categor on delete cascade on update cascade);
DROP TABLE IF EXISTS fw_ferms_urls;
CREATE TABLE fw_ferms_urls (id integer not null auto_increment,ferm_id integer not null,url varchar(255) not null, primary key(id), foreign key (ferm_id) references fw_ferms(id) on delete cascade on update cascade);