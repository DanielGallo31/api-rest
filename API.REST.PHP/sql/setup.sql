DROP DATABASE if exists code_pills;

CREATE DATABASE IF NOT EXISTS code_pills DEFAULT CHARACTER SET utf8 DEFAULT COLLATE utf8_general_ci;
USE code_pills;
CREATE TABLE IF NOT EXISTS listado_clientes(
		id INT AUTO_INCREMENT,
		email VARCHAR(255) NOT NULL,
		name VARCHAR(255) NOT NULL,
		city VARCHAR(255) NOT NULL,
        telephone VARCHAR(255) NOT NULL,
		PRIMARY KEY (id)
)  ENGINE=INNODB;

INSERT INTO listado_clientes (email,name,city,telephone)
VALUES
	("Angel@gmail.com","Angel","Bogota",3002004240),
	("Fede@gmail.com","Federico","Medellin",4002003443),
	("Suzan@gmail.com","Suzan","Mexico",2001003113);


CREATE TABLE IF NOT EXISTS users(
		id INT AUTO_INCREMENT,
		user VARCHAR(255) NOT NULL,
		passw VARCHAR(255) NOT NULL,
		PRIMARY KEY (id)
)  ENGINE=INNODB;

INSERT INTO users (user,passw)
VALUES
	("Damian","12345");

