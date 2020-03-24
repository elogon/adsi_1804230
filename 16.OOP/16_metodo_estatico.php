<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Método Estático </title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-md-6 offset-md-3 mt-5">
				<h1 class="h3 text-center">Método Estático</h1>
				<hr>
				<ul class="list-group">
					<?php
						class Car {
							public $brand;
							public $reference;

							 
							public static function InfoCar($brand, $reference) {
								return "<li class='list-group-item'>".$brand." - ".$reference."</li>";
							}
						}
						echo Car::InfoCar('Volkswagen', 'Tiguan');
						echo Car::InfoCar('Renault', 'Koleos');
						echo Car::InfoCar('Mazda', 'CX-5');
					?>
				</ul>
				
			</div>
		</div>
	</div>
</body>
</html>