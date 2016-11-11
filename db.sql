/* create database and select */
-- DROP DATABASE poll;
CREATE DATABASE IF NOT EXISTS poll;
USE poll;

/* create table */
CREATE TABLE IF NOT EXISTS poll_list (
	pid INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	question TEXT NOT NULL,
	type INT(1) NOT NULL DEFAULT 1,
	comments INT(1) NOT NULL DEFAULT 0,
	spam_prevention INT(1) NOT NULL DEFAULT 0,
	multiple INT(1) NOT NULL DEFAULT 0,
	isvisible INT(1) NOT NULL DEFAULT 1,
	uid INT,
	created_at TIMESTAMP NOT NULL default CURRENT_TIMESTAMP,
 	updated_at TIMESTAMP NOT NULL ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS poll_options (
	opid INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	answer TEXT NOT NULL,
	count INT NOT NULL default 0,
	pid INT NOT NULL,
	created_at TIMESTAMP NOT NULL default CURRENT_TIMESTAMP,
 	updated_at TIMESTAMP NOT NULL ON UPDATE CURRENT_TIMESTAMP,
	FOREIGN KEY (pid) REFERENCES poll_list(pid)
);

CREATE TABLE IF NOT EXISTS users
(
	user_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	username VARCHAR(255) NOT NULL UNIQUE,
	password VARCHAR(255) NOT NULL,
	first_name VARCHAR(255) NOT NULL,
	last_name VARCHAR(255) NOT NULL,
	email VARCHAR(255) NOT NULL UNIQUE,
	gender VARCHAR(20) NOT NULL,
 	country VARCHAR(255) NOT NULL,
 	address VARCHAR(255),
 	profile_picture VARCHAR(255),
	created_at TIMESTAMP NOT NULL default CURRENT_TIMESTAMP,
 	updated_at TIMESTAMP NOT NULL ON UPDATE CURRENT_TIMESTAMP
);
INSERT INTO users VALUES(0,'admin','$2y$10$Jt59m3eVd/TrbmX6b.oUBeW09EWm4qssObtZReJFXz8jhnaPnF6fG','Admin', 'Admin', '', 'Male', 'Global', '', '', '', '');

CREATE TABLE IF NOT EXISTS comments (
	cid INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	comment TEXT,
	user INT NOT NULL,
	pid INT NOT NULL,
	created_at TIMESTAMP NOT NULL default CURRENT_TIMESTAMP,
 	updated_at TIMESTAMP NOT NULL ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS site_details (
	id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	sitename varchar(255) DEFAULT 'POLL',
	description text,
	about text,
	privacy text,
	disclaimer text,
	tos text,
	ad1 text,
	ad2 text
);
INSERT INTO site_details VALUES (1,'Poll', 'A Poll website', '', '', '', '', '', '');