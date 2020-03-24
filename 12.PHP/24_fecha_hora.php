<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Fecha y Hora</title>
	<link rel="stylesheet" href="css/bootstrap-reboot.min.css">
	<link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
	<main class="container">
		<section class="row mt-5">
			<div class="col-md-6 offset-md-3">
				<h1 class="text-center text-dark">Fecha y Hora</h1>
				<hr>
				<div class="jumbotron">
					<p class="lead text-center">
						<strong>hora-minutos-segundos</strong>
						<?php echo date('h:i:s' ) ?>
					</p>
					<p class="lead text-center">
						<strong>dia-mes-año</strong>
						<?php echo date('d-m-Y') ?>
					</p>
					<p class="lead text-center">
						<strong>Nombre dia:</strong>
						<?php echo date('l') ?>
					</p>
					<p class="lead text-center">
						<strong>Año Completo:</strong>
						<?php echo date('Y') ?>
					</p>
					
					<p class="lead text-center">
						<strong>Zona Horaria:</strong>
						<?php echo date('e') ?>
					</p>
					<p class="lead text-center">
						<strong>Tiempo UNIX:</strong>
						<?php echo time() ?>
					</p>
				</div>
				
			</div>
			
			
		</section>
	</main>
	<script src="js/jquery-3.4.1.js"></script>
	<script src="js/bootstrap.min.js"></script>
</body>
</html>