<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Condicional (if-else-elseif)</title>
	<link rel="stylesheet" href="css/bootstrap-reboot.min.css">
	<link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
	<main class="container">
		<section class="row mt-5">
			<div class="col-md-8 offset-md-2 text-center">
				<h1 class="text-dark">Condicional (if-else-elseif)</h1>
				<hr>
				<?php $day = date('D'); ?>
				<?php if ($day == "Mon"): ?>
					<span class="badge badge-pill badge-warning">Hoy es lunes</span>
				<?php elseif ($day == "Tue"): ?>
					<span class="badge badge-pill badge-warning">Hoy es Martes</span>
				<?php elseif ($day == "Wed"): ?>
					<span class="badge badge-pill badge-warning">Hoy es Miercoles</span>
				<?php elseif ($day == "Thu"): ?>
					<span class="badge badge-pill badge-warning">Hoy es Jueves</span>
				<?php elseif ($day == "Fri"): ?>
					<span class="badge badge-pill badge-warning">Hoy es Viernes</span>
				<?php else: ?>
					<span class="badge badge-pill badge-success">Feliz fin de Semana</span>
				<?php endif ?>
			</div>
		</section>
	</main>

	<script src="js/jquery-3.4.1.js"></script>
	<script src="js/bootstrap.min.js"></script>
</body>
</html>