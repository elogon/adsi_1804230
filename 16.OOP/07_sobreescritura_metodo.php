<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Sobre Escritura Metodo</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-md-6 offset-md-3">
				<h1 class="h4 text-center">Sobre Escritura Metodo</h1>
				<hr>
				<?php
					class Vehicle {
						protected $brand;
						protected $refer;

						public function __construct($brand, $refer){
							$this->brand = $brand;
							$this->refer = $refer;
						}
						public function getVehicle() {
							echo "<li class='list-group-item'> <strong>Marca:</strong> ".$this->refer."</li>";
						}
					} 
					class Auto extends Vehicle {
						public function getVehicle() {
							echo "<li class='list-group-item'> <strong>Referencia:</strong> ".$this->brand."</li>";
							parent::getVehicle();
						}
					}
					$vh = new Auto('Audi', 'A5 SportBack');
					$vh->getVehicle();

					$vh = new Auto('Audi', 'A5 Coupe');
					$vh->getVehicle();

					$vh = new Auto('Audi', 'A5 Sedán');
					$vh->getVehicle();
				?>
 			</div>
 		</div>
	</div>
</body>
</html>




