# Consultar todos los registros
SELECT * FROM pokemons;

# Consultar un solo campo
SELECT name FROM pokemons;

# Consultar varios campos
SELECT name, speed FROM pokemons;

# Consultar valores distintos
SELECT DISTINCT type FROM pokemons;

# Consultar registros con un criterio especifico
SELECT * 
FROM pokemons 
WHERE type = 'Agua';

SELECT * 
FROM pokemons 
WHERE type = 'Agua' OR type = 'Electrico';

SELECT *
FROM pokemons
WHERE strength > 1000;

SELECT *
FROM pokemons
WHERE type <> 'Agua';

SELECT *
FROM pokemons
WHERE type = 'Agua'
AND speed > 80;

SELECT *
FROM pokemons
WHERE stamina 
BETWEEN 200
AND 300;

# Ordenar Ascendente
SELECT * FROM pokemons ORDER BY strength;
SELECT * FROM pokemons ORDER BY strength ASC;

# Ordenar Descendente
SELECT * FROM pokemons ORDER BY strength DESC;

SELECT *
FROM pokemons
WHERE speed > 100
ORDER BY speed DESC;

# Limite y en que fila comenzar
SELECT *
FROM pokemons
LIMIT 10;

SELECT *  
FROM pokemons 
LIMIT 5 
OFFSET 10;

SELECT *  FROM pokemons LIMIT 10, 5;

# Buscar (LIKE)
# Mostrar resultados que inician con 'A'
SELECT *
FROM pokemons
WHERE type
LIKE "A%";
# Mostrar resultados que terminen con 'l'
SELECT *
FROM pokemons
WHERE type
LIKE "%l";
# Mostrar resultados que contenga 'ma'
SELECT *
FROM pokemons
WHERE name
LIKE "%ma%";
# Mostrar resultados que cumple 'Pikachu'
SELECT *
FROM pokemons
WHERE name
LIKE "P_k_c_u";
# Mostrar resultados que no contenga 'ma'
SELECT *
FROM pokemons
WHERE name
NOT LIKE "%ma%";

# Mostrar resultados con varios valores 'IN'
SELECT *
FROM pokemons
WHERE type
IN ('Fuego', 'Electrico');

# Mostrar resultados dentro de un rango (BETWEEN)
SELECT *
FROM pokemons
WHERE speed 
BETWEEN 90
AND 100;

# Alias
SELECT t.name AS name_trainer, 
	   p.name AS name_pokemon, 
	   p.type AS type_pokemon
FROM trainers AS t, pokemons AS p
WHERE t.id = p.trainer_id;

SELECT t.name AS name_trainer, 
p.name AS name_pokemon, 
p.type AS type_pokemon
FROM trainers AS t, pokemons AS p
WHERE t.id = p.trainer_id
ORDER BY t.name ASC;

SELECT t.name AS name_trainer, 
p.name AS name_pokemon, 
p.type AS type_pokemon
FROM trainers AS t, pokemons AS p
WHERE t.id = p.trainer_id 
AND p.type = "Agua" OR p.type = "Fuego" 
ORDER BY t.name ASC;

SELECT COUNT(p.id) AS number_pokemons
FROM pokemons AS p, trainers AS t
WHERE t.id = p.trainer_id
AND t.id = 1;

SELECT t.name AS name_trainer, COUNT(p.id) AS number_pokemons
FROM pokemons AS p, trainers AS t
WHERE t.id = p.trainer_id
GROUP BY t.name;


# inner join
SELECT trainers.name AS name_trainer, gyms.name AS name_gym, 
pokemons.name AS name_pokemon
FROM trainers
INNER JOIN gyms
ON trainers.gym_id = gyms.id
INNER JOIN pokemons
ON pokemons.trainer_id = trainers.id
ORDER BY trainers.name;

# left join
SELECT trainers.name AS name_trainer, gyms.name AS name_gym, 
COUNT(pokemons.id) AS num_pokemons
FROM trainers
LEFT JOIN gyms
ON trainers.gym_id = gyms.id
LEFT JOIN pokemons
ON pokemons.trainer_id = trainers.id
GROUP BY trainers.id;

# right join
SELECT trainers.name AS name_trainer, gyms.name AS name_gym, 
pokemons.name AS name_pokemon
FROM trainers
RIGHT JOIN gyms
ON trainers.gym_id = gyms.id AND trainers.id = 1
RIGHT JOIN pokemons
ON pokemons.trainer_id = trainers.id;

# join
SELECT trainers.name AS name_trainer, gyms.name AS name_gym, 
pokemons.name AS name_pokemon
FROM trainers
JOIN gyms
ON trainers.gym_id = gyms.id AND trainers.id = 1
JOIN pokemons
ON pokemons.trainer_id = trainers.id
ORDER BY trainers.name;

# union (unir consultas)
SELECT name FROM trainers
UNION
SELECT name FROM gyms
UNION
SELECT name FROM pokemons;

# vistas (views)
CREATE VIEW num_pokemons AS
SELECT trainers.name AS name_trainer, gyms.name AS name_gym, 
COUNT(pokemons.id) AS num_pokemons
FROM trainers
LEFT JOIN gyms
ON trainers.gym_id = gyms.id
LEFT JOIN pokemons
ON pokemons.trainer_id = trainers.id
GROUP BY trainers.id;

# consultar vista
SELECT * FROM num_pokemons;

