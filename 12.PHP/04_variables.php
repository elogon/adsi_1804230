<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Variables</title>
	<link rel="stylesheet" href="css/bootstrap-reboot.min.css">
	<link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
	<main class="container">
		<section class="row mt-5">
			<div class="col-md-8 offset-md-2">
				<h1 class="text-center text-dark">Variables</h1>
				<hr>
				<?php 
					$alert1   = 'alert alert-success alert-dimissible fade show';
					$alert2   = 'alert alert-warning alert-dimissible fade show'; 
					$alert3   = 'alert alert-danger alert-dimissible fade show';
					$user1 = 1;
					$user2 = 2;
					$user3 = 3;
				?>
				<div class="<?php echo $alert1; ?>"> 
					<strong>El usuario <?php echo $user1; ?> cumple con los requisitos de ingreso</strong> 
					<button type="button" class="close" data-dismiss="alert">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="<?php echo $alert2; ?>"> 
					<strong>La información del usuario <?php echo $user2; ?> es incompleta</strong> 
					<button type="button" class="close" data-dismiss="alert">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="<?php echo $alert3; ?>"> 
					<strong>El Usuario <?php echo $user3; ?> no se encuentra registrado</strong>
					<button type="button" class="close" data-dismiss="alert">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
			</div>
			
			
		</section>
	</main>
	<script src="js/jquery-3.4.1.js"></script>
	<script src="js/bootstrap.min.js"></script>
</body>
</html>