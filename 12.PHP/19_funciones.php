<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Funciones</title>
	<link rel="stylesheet" href="css/bootstrap-reboot.min.css">
	<link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
	<main class="container">
		<section class="row mt-5">
			<div class="col-md-8 offset-md-2">
				<h1 class="text-center text-dark">Fuciones</h1>
				<hr>
				<?php 
				    function show_name() {
						echo "Jeremias Springfield";
					}
				?>
				<div class="jumbotron">
					<div class="container">
						<h1 class="display-4"><?php show_name(); ?></h1>
						<p class="lead">This is a modified jumbotron that occupies the entire horizontal space of its parent.</p>
					</div>
				</div>
			</div>
			
			
		</section>
	</main>
	<script src="js/jquery-3.4.1.js"></script>
	<script src="js/bootstrap.min.js"></script>
</body>
</html>