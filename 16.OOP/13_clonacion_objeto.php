<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Clonacion de Objetos</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-md-6 offset-md-3 mt-5">
				<h1 class="h3 text-center">Clonacion de Objetos</h1>
				<hr>
				<ul class="list-group">
					<?php
					
					class Sheep {
						private $name;
						private $weight;

						public function __construct($nm, $wg) {
							$this->name   = $nm;
							$this->weight = $wg;
						}

						public function getInfoSheep() {
							return "<li class='list-group-item'>".$this->name." - ".$this->weight."</li>";
						}
					}

					$sh = new Sheep("Margarete", 200);
					$sc = clone($sh);
					echo $sc->getInfoSheep();
					
					?>
				</ul>
				
			</div>
		</div>
	</div>
</body>
</html>