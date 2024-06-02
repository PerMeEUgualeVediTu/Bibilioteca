-- creating database

CREATE DATABASE BIB100;
USE BIB100;

-- creating user

CREATE USER 'bibmin'@'localhost' IDENTIFIED WITH mysql_native_password BY 'bibcz42DF100*';
GRANT ALL PRIVILEGES ON BIB100.* TO 'bibmin'@'localhost';
FLUSH PRIVILEGES;

-- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- --

-- -- Primitives

-- Tabella 'Genere'

CREATE TABLE genere (
	ID int NOT NULL PRIMARY KEY AUTO_INCREMENT,
	genere varchar(35) NOT NULL
);

-- Tabella 'Persona'

CREATE TABLE persona (
	ID int NOT NULL PRIMARY KEY AUTO_INCREMENT,
	CF varchar(14) NOT NULL,
	nome varchar(35) NOT NULL,
	cognome varchar(35) NOT NULL,
	Identificativo int NOT NULL
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

INSERT INTO genere(genere) VALUES ("la roba che si fuma tolkien");
INSERT INTO genere(genere) VALUES ("balin shit");
INSERT INTO genere(genere) VALUES ("il profumo magico");
INSERT INTO genere(genere) VALUES ("genere serio");

INSERT INTO persona(CF,nome,cognome,Identificativo) VALUES ("GGGGGGGG","Giorgio1","Vanni1",23456789);
INSERT INTO persona(CF,nome,cognome,Identificativo) VALUES ("GGGGGGGG","Giorgio2","Vanni2",23456790);
INSERT INTO persona(CF,nome,cognome,Identificativo) VALUES ("GGGGGGGG","Giorgio3","Vanni3",23456791);
INSERT INTO persona(CF,nome,cognome,Identificativo) VALUES ("GGGGGGGG","Giorgio4","Vanni4",23456792);

INSERT INTO autore(CF,nome,cognome,biografia) VALUES ("TTTTTTTT","JRR","Tolkien","buon uomo ciao");
INSERT INTO autore(CF,nome,cognome,biografia) VALUES ("TTTTTTTT","Lebron James","My sunshine","buon uomo ciao");
INSERT INTO autore(CF,nome,cognome,biografia) VALUES ("TTTTTTTT","No","Cap","buon uomo ciao");
INSERT INTO autore(CF,nome,cognome,biografia) VALUES ("TTTTTTTT","On","Cod","buon uomo ciao");

INSERT INTO biblioteca(luogo_biblioteca) VALUES ("Io dove");
INSERT INTO biblioteca(luogo_biblioteca) VALUES ("Io quando");
INSERT INTO biblioteca(luogo_biblioteca) VALUES ("Io perche");
INSERT INTO biblioteca(luogo_biblioteca) VALUES ("Io anche no");

INSERT INTO opere(autore,biblio,titolo,anno,genere) VALUES (1,2,"il signore con l'anello",1969,1);
INSERT INTO opere(autore,biblio,titolo,anno,genere) VALUES (1,1,"Uomi piccoli e Gangialf",1942,1);
INSERT INTO opere(autore,biblio,titolo,anno,genere) VALUES (1,2,"Le similitudini",1936,1);

INSERT INTO opere(autore,biblio,titolo,anno,genere) VALUES (2,2,"Bed time story",1969,1);
INSERT INTO opere(autore,biblio,titolo,anno,genere) VALUES (2,1,"Esattamente",1942,1);
INSERT INTO opere(autore,biblio,titolo,anno,genere) VALUES (2,2,"LA diversita",1969,1);

INSERT INTO opere(autore,biblio,titolo,anno,genere) VALUES (3,2,"Bed time story 3",1969,1);
INSERT INTO opere(autore,biblio,titolo,anno,genere) VALUES (3,1,"Esattamente 3 ",1942,1);
INSERT INTO opere(autore,biblio,titolo,anno,genere) VALUES (3,2,"LA diversita 3",1969,1);

INSERT INTO opere(autore,biblio,titolo,anno,genere) VALUES (4,2,"Bed time story 4",1969,1);
INSERT INTO opere(autore,biblio,titolo,anno,genere) VALUES (4,1,"Esattamente 4",1942,1);
INSERT INTO opere(autore,biblio,titolo,anno,genere) VALUES (4,2,"LA diversita 4",1969,1);

INSERT INTO prestito(ID_persona,ID_opera,data_prestito,fine_prestito) VALUES (0,0,0,120);

show tables;