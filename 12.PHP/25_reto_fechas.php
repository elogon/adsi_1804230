<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Reto Fechas</title>
	<link rel="stylesheet" href="css/bootstrap-reboot.min.css">
	<link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
	<main class="container">
		<section class="row mt-5">
			<div class="col-md-4 offset-md-4">
				<h1 class="text-center text-dark">Reto Fechas</h1>
				<hr>
				<form action="" method="POST">
					<div class="form-group">
						<label for="birthdate">Fecha Nacimiento</label>
						<input type="date" id="birthdate" name="birthdate" class="form-control" placeholder="'mm/dd/yyyy">
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-outline-success">Calcular edad</button>
						
					</div>
				</form>
				<?php  
					if($_POST) {
						//$bd    = $_POST['birthdate'];
						//$day   = substr($bd, 0, 2);
						$day   = date('d', strtotime($_POST['birthdate']));
						$month = date('m', strtotime($_POST['birthdate']));
						$year  = date('Y', strtotime($_POST['birthdate']));
 
						$born  = mktime(0, 0, 0, $month, $day, $year);
						$today = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
						$edad  = round(($today-$born)/(60*60*24*365.25));
						echo $edad;
					}
					
				?>
				
			</div>
			
			
		</section>
	</main>
	<script src="js/jquery-3.4.1.js"></script>
	<script src="js/bootstrap.min.js"></script>
</body>
</html>