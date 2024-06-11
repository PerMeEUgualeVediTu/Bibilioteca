CREATE TABLE Users (
	User_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT, -- primary key column
	User_name VARCHAR(20) NOT NULL,
	E_mail VARCHAR(40) NOT NULL,
	Password_hash CHAR(64) NOT NULL,
    Password_salt CHAR(64) NOT NULL,
	Register_date INT NOT NULL,
	User_icon CHAR(32) NOT NULL
);

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