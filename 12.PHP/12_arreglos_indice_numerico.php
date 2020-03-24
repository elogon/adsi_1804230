<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Arreglos (Índice Numérico)</title>
	<link rel="stylesheet" href="css/bootstrap-reboot.min.css">
	<link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
	<main class="container">
		<section class="row mt-5">
			<div class="col-md-8 offset-md-2">
				<h1 class="text-center text-dark">Arreglos (Índice Numérico)</h1>
				<hr>
				<?php  
					#Asignación de Índice automatico
					$cars = array('Volswagen', 'Toyota', 'Renault');
					#Asignación de Índice manual
					$cars[3] = 'Fiat';
					$cars[4] = 'Mazda';
					$cars[5] = 'Chevrolet';

					var_dump($cars);
					<div class="dropdown">
  					<a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
   					    Dropdown link
						 </a>

					  <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
					    <a class="dropdown-item" href="#">Action</a>
					    <a class="dropdown-item" href="#">Another action</a>
					    <a class="dropdown-item" href="#">Something else here</a>
					  </div>
					</div>
				?>
			</div>
				
			
		</section>
	</main>
	<script src="js/jquery-3.4.1.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/dropdown.js"></script>
</body>
</html>