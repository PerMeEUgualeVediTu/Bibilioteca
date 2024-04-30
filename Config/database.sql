-- creating database

CREATE DATABASE BIB100;
USE BIB100;

-- creating user

CREATE USER 'bibmin'@'localhost' IDENTIFIED WITH mysql_native_password BY 'bibcz42DF100*';
GRANT ALL PRIVILEGES ON BIB100 TO 'bibmin'@'localhost';
FLUSH PRIVILEGES;

-- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- --

-- -- Primitives

-- Tabella 'Persona'

CREATE TABLE persona (
	ID int NOT NULL PRIMARY KEY AUTO_INCREMENT,
	CF varchar(14) NOT NULL,
	nome varchar(35) NOT NULL,
	cognome varchar(35) NOT NULL,
	Identificativo int NOT NULL,
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
	tipo varchar(25) NOT NULL,
	autore int NOT NULL, -- linked to Autore
	biblio int NOT NULL, -- linked to Bibioteca // where is stored, supposed to change
	titolo varchar(35) NOT NULL
);

-- Tabella 'prestito'

CREATE TABLE prestito (
	ID int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
	ID_persona varchar(14) NOT NULL,
	ID_opera varchar(14) NOT NULL,
	data_prestito date NOT NULL,
	fine_prestito date NOT NULL
);
