
# Modificar Tabla (Agregar llave foranea)
ALTER TABLE pokemons
ADD FOREIGN KEY(trainer_id)
REFERENCES trainers(id);

# Modificar Tabla (Renombrar Columna)
ALTER TABLE trainers 
CHANGE gym gym_id INT NOT NULL;

#Crear Tabla
CREATE TABlE gyms (
id INT AUTO_INCREMENT,
name VARCHAR(32) NOT NULL,
PRIMARY KEY(id));

# Modificar Tabla (Agregar llave foranea)
ALTER TABLE trainers
ADD FOREIGN KEY(gym_id)
REFERENCES gyms(id);