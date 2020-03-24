<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Funciones (Parametros)</title>
	<link rel="stylesheet" href="css/bootstrap-reboot.min.css">
	<link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
	<main class="container">
		<section class="row mt-5">
			<div class="col-md-8 offset-md-2">
				<h1 class="text-center text-dark">Fuciones (Parametros)</h1>
				<hr>

				<?php 
				    function show_info($name, $description) {
						echo '<h1 class="display-4">'.$name.'</h1>';
						echo '<p class="lead">'.$description.'</p>';
					}
				?>
				<div class="jumbotron">
					<div class="container">
					  <?php 
					  	$desc = "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sint nemo laborum, dolores excepturi sed, natus recusandae harum in, sit magni quas eos nostrum.";
					  	show_info('Saitama Sensei', $desc); 
					  	show_info('Garou', "One punch man season 2"); 


					  ?>
					</div>
				</div>
			</div>
			
			
		</section>
	</main>
	<script src="js/jquery-3.4.1.js"></script>
	<script src="js/bootstrap.min.js"></script>
</body>
</html>