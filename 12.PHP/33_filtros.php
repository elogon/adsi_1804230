<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Filtros</title>
	<link rel="stylesheet" href="css/bootstrap-reboot.min.css">
	<link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
	<main class="container">
		<section class="row mt-5">
			<div class="col-md-6 offset-md-3">
				<h1 class="text-center text-dark">Filtros</h1>
				<hr>
				<form action="" method="POST">
					<div class="form-group">
						<input type="number" class="form-control" name="age" placeholder="Ingresar la edad">
						
					</div>
					<div class="form-group">
						<input type="email" class="form-control" name="email" placeholder="Ingrese correo electronico">
						
					</div>
					<div class="form-group">
						<input type="url" class="form-control" name="url" placeholder="Ingresar dirección de internet">
						
					</div>
					<div class="form-group">
						<input type="submit" value="Calcular" class="btn btn-success">
					</div>
				</form>
				<?php  
					if ($_POST) {
						function validate_age($age) {
							if ($age < 18) {
								throw new Exception("Usted no puede votar!");
								
							}
							return true;
						}

						try {
							validate_age($_POST['age']);
							echo '<div class="alert alert-success">
									Usted puede votar!
								  </div>';
						} catch (Exception $e) {
							echo '<div class="alert alert-danger">
									Error: '.$e->getMessage().'
								  </div>';
						}
					}
				?>
			</div>
			
			
		</section>
	</main>
	<script src="js/jquery-3.4.1.js"></script>
	<script src="js/bootstrap.min.js"></script>
</body>
</html>