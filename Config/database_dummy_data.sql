INSERT INTO genere(genere) VALUES ("la roba che si fuma tolkien");
INSERT INTO genere(genere) VALUES ("balin shit");
INSERT INTO genere(genere) VALUES ("il profumo magico");
INSERT INTO genere(genere) VALUES ("genere serio");

INSERT INTO autore(CF,nome,cognome,biografia) VALUES ("TTTTTTTT","JRR","Tolkien","buon uomo ciao");
INSERT INTO autore(CF,nome,cognome,biografia) VALUES ("TTTTTTTT","Lebron James","My sunshine","buon uomo ciao");
INSERT INTO autore(CF,nome,cognome,biografia) VALUES ("TTTTTTTT","No","Cap","buon uomo ciao");
INSERT INTO autore(CF,nome,cognome,biografia) VALUES ("TTTTTTTT","On","Cod","buon uomo ciao");
INSERT INTO autore(CF,nome,cognome,biografia) VALUES ("DDDDDDDD","Dante","Aliqueri","buon uomo ciao");

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

INSERT INTO opere(autore,biblio,titolo,anno,genere) VALUES (5,2,"il sama kutra",1969,1);
INSERT INTO opere(autore,biblio,titolo,anno,genere) VALUES (5,2,"il kama sutra",1969,1);

INSERT INTO prestito(ID_persona,ID_opera,data_prestito,fine_prestito) VALUES (0,0,0,120);
