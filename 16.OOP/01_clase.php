<?php 
	// Clase

	class VideoGame {

		//Atributos (Caracteristicas propias del objeto)

		public $name;       // Nombre del VideoJuego
		public $platform;  // Plataforma
		public $price;    // Precio
		public $year;    // Año de Lanzamiento

		// Métodos (Acciones-Lógica)

		public function setAttributes($name, $platform, $price, $year) {
			$this -> name     = $name;
			$this -> platform = $platform;
			$this -> price    = $price;
			$this -> year     = $year;
		}

		public function getAttributes() {
			return $this -> name." - ".
				   $this -> platform." - ".
				   $this -> price." - ". 
				   $this -> year;
		}

	}

	$vg1 = new VideoGame; // Crear el Objeto
	$vg1 ->setAttributes('pokemon Espada', 'Nitento Switch', 50, 2019);
	echo $vg1 ->getAttributes();

	echo "<hr>";

	$vg2 = new VideoGame; 
	$vg2 ->setAttributes('Mario Oddykey', 'Nitento Switch', 40, 2017);
	echo"El Nombre del Video Juego es:" .$vg2 ->name;


 ?>