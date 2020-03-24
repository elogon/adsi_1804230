<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Clase Final</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-md-6 offset-md-3 mt-5">
				<h1 class="h3 text-center">Clase Final</h1>
				<hr>
				<ul class="list-group">
					<?php
					final class Fruit {
						private $name;
						private $color;

						public function __construct($nm, $cl) {
							$this->name  = $nm;
							$this->color = $cl;
						}

						public function getInfoFruit() {
							return "<li class='list-group-item'>".$this->name." | ".$this->color."</li>";
						}
					} 
					# Error: Una clase final no puede heredar
					#class Orange extends Fruit {}

					$frt = new Fruit('Pinapple', 'Yellow');
					echo $frt->getInfoFruit();
					$frt = new Fruit('Apple', 'Green');
					echo $frt->getInfoFruit();
					$frt = new Fruit('Orange', 'Orange');
					echo $frt->getInfoFruit();

					?>
				</ul>
				
			</div>
		</div>
	</div>
</body>
</html>