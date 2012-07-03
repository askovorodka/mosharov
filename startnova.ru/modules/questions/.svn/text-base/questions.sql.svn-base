INSERT IGNORE INTO fw_modules (name, title, section, status) VALUES ('questions', 'Вопросы', 'front_support', '1');
DROP TABLE IF EXISTS fw_questions;
DROP TABLE IF EXISTS fw_answers;
CREATE TABLE IF NOT EXISTS fw_questions (id int(11) unsigned NOT NULL auto_increment,answer_id integer NOT NULL,question varchar(150) NOT NULL,description text NOT NULL ,PRIMARY KEY  (id));
CREATE TABLE IF NOT EXISTS fw_answers (id int(11) unsigned NOT NULL auto_increment,question_id integer NOT NULL,answer varchar(150) NOT NULL,PRIMARY KEY  (id));
