# Acceder a Base de Datos (Mysql) local en el navegador web:
# http://localhost/phpmyadmin

# Acceder a Base de Datos (Mysql) local en la línea de comandos:
# $ cd /Application/MAMP/Library/
# $ ./mysql --version
# $ ./mysql -u root -p

# Mostrar version de Mysql:
SELECT version();

# Mostrar Bases de Datos:
SHOW databases;

# Crear una Base de Datos
CREATE DATABASE adsi1804230;

# Conectar a una Base de Datos
CONNECT mysql;

# Usar Base de Datos
USE adsi1804230;

# Mostrar tablas
SHOW tables;

# Crear Tabla
CREATE TABLE trainers (
id int AUTO_INCREMENT,
name varchar(32) NOT NULL,
level int NOT NULL DEFAULT 1,
gym_id INT NOT NULL,
FOREIGN KEY(gym_id) REFERENCES gyms(id)
PRIMARY KEY(id));

CREATE table pokemons2 (
id INT AUTO_INCREMENT,
name VARCHAR(32) NOT NULL,
type VARCHAR(32) NOT NULL,
strength INT NOT NULL,
stamina INT NOT NULL,
speed INT NOT NULL,
accuracy INT NOT NULL,
PRIMARY KEY(id));
# Agregar Columna
ALTER TABLE pokemons 
ADD COLUMN trainer_id INT NOT NULL
AFTER accuracy;
# Eliminar Columna
ALTER TABLE pokemons 
DROP COLUMN trainer_id;

# Descripción Tabla
DESCRIBE pokemons;

# Insertar Registro
INSERT INTO pokemons VALUES ( DEFAULT, 'pikachu', 'Electrico', 90, 80, 96, 79);
INSERT INTO pokemons VALUES ( DEFAULT, 'charmander', 'Fuego', 95, 78, 80, 82);
INSERT INTO pokemons VALUES ( DEFAULT, 'bulbasaour', 'Planta', 80, 88, 70, 75);
INSERT INTO pokemons VALUES ( DEFAULT, 'squirtle', 'Agua', 70, 90, 75, 90);
INSERT INTO pokemons VALUES ( DEFAULT, 'Snorlax', 'Normal', 180, 320, 50, 180);
INSERT INTO pokemons VALUES ( DEFAULT, 'Vaporeon', 'Agua', 186, 260, 90, 168);
INSERT INTO pokemons VALUES ( DEFAULT, 'Lapras', 'Agua', 111, 255, 100, 168);
INSERT INTO pokemons VALUES ( DEFAULT, 'Blastoise', 'Agua', 720, 158, 70, 222);
INSERT INTO pokemons VALUES ( DEFAULT, 'Golem', 'Agua', 500, 160, 80, 198);
INSERT INTO pokemons VALUES ( DEFAULT, 'Dragonite', 'Dragon', 900, 250, 120, 182);
INSERT INTO pokemons VALUES ( DEFAULT, 'Exeggutor', 'Planta', 596, 190, 90, 232);
INSERT INTO pokemons VALUES ( DEFAULT, 'Omaster', 'Roca', 1500, 140, 112, 202);
INSERT INTO pokemons VALUES ( DEFAULT, 'Muk', 'Veneno', 1070, 210, 112, 180);
INSERT INTO pokemons VALUES ( DEFAULT, 'Onix', 'Roca', 662, 70, 80, 90);
INSERT INTO pokemons VALUES ( DEFAULT, 'Poliwag', 'Agua', 815, 80, 70, 108);
INSERT INTO pokemons VALUES ( DEFAULT, 'Mankey', 'Agua', 563, 80, 70, 122);
INSERT INTO pokemons VALUES ( DEFAULT, 'Magnemite', 'Electrico', 750, 50, 40, 128);
INSERT INTO pokemons VALUES ( DEFAULT, 'Pidgey', 'Normal', 818, 80, 95, 90);
INSERT INTO pokemons VALUES ( DEFAULT, 'Gastly', 'Fantasma', 750, 60, 60, 82);
INSERT INTO pokemons VALUES ( DEFAULT, 'Rattata', 'Normal', 810, 60, 65, 22);

# Crear copia de seguridad (Backup) de la BD:
$ ./mysqldump -u root -p adsi1804230 > /Users/ofaczero/Desktop/ADSI/adsi-1804230/13-SQL/backup.sql
DROP DATABASE adsi1804230;

# Recuperar copia de seguridad (Backup) de la BD: 
CREATE DATABASE adsi1804230;
$ ./mysql -u root -p adsi1804230 < /Users/ofaczero/Desktop/ADSI/adsi-1804230/13-SQL/backup.sql

# Insertar datos de una tabla a otra
 INSERT INTO pokemons_bk SELECT * FROM pokemons;


