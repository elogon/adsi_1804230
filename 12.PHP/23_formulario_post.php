<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Funciones (POST)</title>
	<link rel="stylesheet" href="css/bootstrap-reboot.min.css">
	<link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
	<main class="container">
		<section class="row mt-5">
			<div class="col-md-6 offset-md-3">
				<h1 class="text-center text-dark">Fuciones (POST)</h1>
				<hr>
				<form action="" method="POST">
					<div class="form-group">
						<label for="name" >Nombre:</label>
						<input type="text" class="form-control" name="name" id="name">
					</div>
					<div class="form-group">
						<label for="email" >Email:</label>
						<input type="text" class="form-control" name="email" id="email">
					</div>
					<div class="form-group">
						<input type="submit" class="btn btn-success" value="Enviar Formulario">
						<input type="reset" class="btn btn-light" value="Limpiar Formulario">
					</div>
				</form>
				<?php if ($_POST): ?>
					<div class="alert alert-success	">
						<strong>Nombre: </strong> <?php echo $_POST['name']; ?>
						<br>
						<strong>Email: </strong>  <?php echo $_POST['email']; ?>
					</div>
					
				<?php endif ?>
				

				
			</div>
			
			
		</section>
	</main>
	<script src="js/jquery-3.4.1.js"></script>
	<script src="js/bootstrap.min.js"></script>
</body>
</html>