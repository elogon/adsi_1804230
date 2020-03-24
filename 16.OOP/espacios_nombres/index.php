<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Nombre de Espacios</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-md-6 offset-md-3 mt-5">
				<h1 class="h3 text-center">Nombre de Espacios</h1>
				<hr>
				<ul class="list-group">
				<?php 
					include 'electric/Pokemon.php';
					include 'fire/Pokemon.php';
					include 'water/Pokemon.php';

					use \electric\Pokemon as Pke;
					use \fire\Pokemon as Pkf;		
					use \water\Pokemon as Pkw;

					$pk = new Pke('Pikachu', 'Yellow');
					echo $pk->getInfoPokemon();

					$pk = new Pkf('Charmander', 'Orange');
					echo $pk->getInfoPokemon();

					$pk = new Pkw('Squirtle', 'Aqua');
					echo $pk->getInfoPokemon();
					
				?>
				</ul>
			</div>
		</div>
	</div>
</body>
</html>