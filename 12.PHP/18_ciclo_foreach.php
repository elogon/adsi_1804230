<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Ciclos (For Each)</title>
	<link rel="stylesheet" href="css/bootstrap-reboot.min.css">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<style>	
		button.btn-custom { 
			background-color: #721c8a; 
			color: #fff;
				
		}
		button.btn-custom:hover {
			color:fff;
			background-color: #5a1771;
		}
	</style>
</head>
<body>
	<main class="container">
		<section class="row mt-5">
			<div class="col-md-8 offset-md-2 text-center">
				<h1 class="text-dark">Ciclos (For Each)</h1>
				<hr>
				
				<?php 
					$buttons = array('btn-danger', 'btn-warning', 'btn-success', 'btn-primary', 'btn-info', 'btn-secondary', 'btn-dark', 'btn-light', 'btn-link', 'btn-custom');	
				?>
				<?php foreach ($buttons as $button): ?>
					<button class="btn btn-lg btn-block <?php echo $button; ?>">	
						<?php echo $button; ?>
					</button>
				<?php endforeach ?>
			</div>
		</section>
	</main>
	<script src="js/jquery-3.4.1.js"></script>
	<script src="js/bootstrap.min.js"></script>
</body>
</html>