-- creating database

CREATE DATABASE BIB100;
USE BIB100;

-- creating user

-- form mysql
CREATE USER 'bibmin'@'localhost' IDENTIFIED WITH mysql_native_password BY 'bibcz42DF100*';
-- for maria
CREATE USER 'bibmin'@'localhost' IDENTIFIED BY 'bibcz42DF100*';

GRANT ALL PRIVILEGES ON BIB100.* TO 'bibmin'@'localhost';
FLUSH PRIVILEGES;

-- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- --

-- -- Login

-- Tabella 'Sessioni'

CREATE TABLE Sessions (
	Session_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	Session_token VARCHAR (64) NOT NULL,
	Session_ip VARCHAR(45) NOT NULL,
	Logged_user_id INT NOT NULL,
	Session_start INT NOT NULL
);

-- Tabella 'Procedure'

CREATE TABLE Procedures (
	Procedure_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	Procedure_end INT NOT NULL,
	Procedure_desc VARCHAR(100) NOT NULL
);

-- -- Primitives

-- Tabella 'Genere'

CREATE TABLE genere (
	ID int NOT NULL PRIMARY KEY AUTO_INCREMENT,
	genere varchar(35) NOT NULL
);

-- Tabella 'Persona'

CREATE TABLE persona (
	ID int NOT NULL PRIMARY KEY AUTO_INCREMENT,
	nome varchar(35) NOT NULL,
	cognome varchar(35) NOT NULL,
	E_mail VARCHAR(40) NOT NULL,
	Password_hash CHAR(64) NOT NULL,
    Password_salt CHAR(64) NOT NULL,
	Register_date INT NOT NULL,
	User_icon CHAR(32) NOT NULL
);

-- Tabella 'Autore'

CREATE TABLE autore (
	ID int NOT NULL PRIMARY KEY AUTO_INCREMENT,
	CF varchar(14) NOT NULL,
	nome varchar(35) NOT NULL,
	cognome varchar(35) NOT NULL,
	biografia varchar(200) NOT NULL
	-- aggiungi dati aggiuntivi
);

-- Tabella 'Luogo'

CREATE TABLE biblioteca (
	ID int NOT NULL PRIMARY KEY AUTO_INCREMENT,
	luogo_biblioteca varchar(35) NOT NULL -- to chouse how to store position
);

-- -- Derivates

-- -- Tabella 'Opere'

CREATE TABLE opere (
	ID int NOT NULL PRIMARY KEY AUTO_INCREMENT,
	autore int NOT NULL, -- linked to Autore
	biblio int NOT NULL, -- linked to Bibioteca // where is stored, supposed to change
	genere int NOT NULL, -- linked to Genere
	titolo varchar(35) NOT NULL,
	anno int NOT NULL
);

-- Tabella 'prestito'

CREATE TABLE prestito (
	ID int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
	ID_persona int NOT NULL,
	ID_opera int NOT NULL,
	data_prestito int NOT NULL, -- saved as the time.h result
	fine_prestito int NOT NULL,
	onorato bit NOT NULL -- 0 if not onorato 1 if onorato
);

-- Tabelle per il login

CREATE TABLE Procedures (
	Procedure_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	Procedure_end INT NOT NULL,
	Procedure_desc VARCHAR(100) NOT NULL
);

CREATE TABLE Sessions (
	Session_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	Session_token CHAR (64) NOT NULL,
	Session_ip CHAR(45) NOT NULL,
	Logged_user_id INT NOT NULL,
	Session_start INT NOT NULL
);