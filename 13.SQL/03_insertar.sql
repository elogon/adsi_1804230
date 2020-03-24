# Insertar forma corta (No se especifica los nombres de columnas)
INSERT INTO trainers VALUES (
DEFAULT, "Ash Ketchum", 7, "Paleta");

INSERT INTO trainers VALUES ( 
DEFAULT, "Misty", 4, "Estrella");

INSERT INTO trainers VALUES ( 
DEFAULT, "Brok", 6, "Tierra");

# Insertar forma larga (Se especifica los nombres de columnas)
INSERT INTO trainers (id, name, level, gym) VALUES ( 
DEFAULT, "Serena", 4, "Diamante");

INSERT INTO trainers (id, name, level, gym) VALUES ( 
DEFAULT, "Oak", 9, "Escuela");