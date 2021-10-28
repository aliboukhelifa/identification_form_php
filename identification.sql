CREATE DATABASE identification; 
CREATE extension pgcrypto;

CREATE TABLE account (
	user_id serial PRIMARY KEY,
	email VARCHAR (255) UNIQUE NOT NULL,
	password TEXT NOT NULL,
	created_on TIMESTAMP NOT NULL
);

INSERT INTO account (email, password, created_on) VALUES (
  'ali@paris8.fr',
  crypt('M1informatique2021@', gen_salt('bf')), '2021-10-28');

INSERT INTO account (email, password, created_on) VALUES (
  'christophe@atos.fr',
  crypt('chris.php@welovehack.fr', gen_salt('bf')), '2021-10-28');
