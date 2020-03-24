# Modificar registros de una tabla
UPDATE trainers
SET name = "Brock", level = 5
WHERE id = 3;

UPDATE pokemons
SET trainer_id = 4
WHERE id = 15
OR id = 17
OR id = 19;

UPDATE pokemons
SET trainer_id = 5
WHERE id >= 12 AND id <= 14;