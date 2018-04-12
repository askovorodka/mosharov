DROP TABLE IF EXISTS fw_guestbook;
CREATE TABLE fw_guestbook(id integer not null auto_increment primary key,author varchar(255) not null,message text not null,answer text,insert_date integer not null,author_mail varchar(255),status bit not null default 1,tema varchar(255));
