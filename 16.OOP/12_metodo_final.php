<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Método Final</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-md-6 offset-md-3 mt-5">
				<h1 class="h3 text-center">Método Final</h1>
				<hr>
				<ul class="list-group">
					<?php
					class Fruit {
						private $name;

						public function __construct($nm) {
							$this->name  = $nm;
						}

						final public function getInfoFruit() {
							return "<li class='list-group-item'>".$this->name."</li>";
						}
					} 
					class Apple extends Fruit {
						#Error: No se puede sobreescribir un método final
						public function getInfoFruit() {

						}
					}

					$frt = new Apple('Apple Green');
					echo $frt->getInfoFruit();
					$frt = new Apple('Apple Red');
					echo $frt->getInfoFruit();
					$frt = new Apple('Apple Bited');
					echo $frt->getInfoFruit();

					?>
				</ul>
				
			</div>
		</div>
	</div>
</body>
</html>