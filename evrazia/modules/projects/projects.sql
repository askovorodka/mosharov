INSERT IGNORE INTO fw_modules (id, name, title, section, status) VALUES (NULL,'projects', 'Проекты', 'front_support', '1');
DROP TABLE IF EXISTS fw_projects;
CREATE TABLE fw_projects (id integer not null auto_increment,name varchar(255) not null,publish_date integer not null,sort_order integer,cat_id integer not null, primary key (id), foreign key (cat_id) references fw_categor (id) on delete cascade on update cascade);
DROP TABLE IF EXISTS fw_projects_urls;
CREATE TABLE fw_projects_urls (id integer not null auto_increment,p_id integer not null,url varchar(255) not null, primary key (id), foreign key (p_id) references fw_projects (id) on delete cascade on update cascade);
DROP TABLE IF EXISTS fw_project_url_text;
CREATE TABLE fw_project_url_text (id integer not null auto_increment, url_id integer not null, text text, primary key (id), foreign key (url_id) references fw_projects_urls(id) on delete cascade on update cascade);