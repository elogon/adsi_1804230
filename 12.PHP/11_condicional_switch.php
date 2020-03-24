<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Condicional (swicth)</title>
	<link rel="stylesheet" href="css/bootstrap-reboot.min.css">
	<link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
	<main class="container">
		<section class="row mt-5">
			<div class="col-md-8 offset-md-2">
				<h1 class="text-center text-dark">Condicional (swicth)</h1>
				<hr>
				<?php  
					$day = date('n');
					echo $day;
					switch ($day) {
						case 1:
							echo '<ul class="list-group">
							  <li class="list-group-item list-group-item-secondary">Primer trimestre</li>
							  <li class="list-group-item active">Enero</li>
							  <li class="list-group-item ">Febrero</li>
							  <li class="list-group-item ">Marzo</li>
							  </ul>';

							break;

						case 2:
							echo '<ul class="list-group">
								  <li class="list-group-item list-group-item-secondary">Primer trimestre</li>
								  <li class="list-group-item ">Enero</li>
								  <li class="list-group-item active">Febrero</li>
								  <li class="list-group-item ">Marzo</li>
								  </ul>';
							break;

						case 3:
							echo '<ul class="list-group">
								  <li class="list-group-item list-group-item-secondary">Primer trimestre</li>
								  <li class="list-group-item ">Enero</li>
								  <li class="list-group-item ">Febrero</li>
								  <li class="list-group-item active">Marzo</li>
								  </ul>';
							break;
						
						case 4:
							echo '<ul class="list-group">
								  <li class="list-group-item list-group-item-secondary">Primer trimestre</li>
								  <li class="list-group-item ">Enero</li>
								  <li class="list-group-item ">Febrero</li>
								  <li class="list-group-item active">Marzo</li>
								  </ul>';
							break;

						case 5:
							echo '<ul class="list-group">
								  <li class="list-group-item list-group-item-secondary">Primer trimestre</li>
								  <li class="list-group-item ">Abril</li>
								  <li class="list-group-item ">Mayo</li>
								  <li class="list-group-item active">Junio</li>
								  </ul>';
							break;

						case 6:
							echo '<ul class="list-group">
								  <li class="list-group-item list-group-item-secondary">Primer trimestre</li>
								  <li class="list-group-item ">Abril</li>
								  <li class="list-group-item ">Mayo</li>
								  <li class="list-group-item active">Junio</li>
								  </ul>';
							break;

						case 7:
							echo '<ul class="list-group">
									  <li class="list-group-item list-group-item-secondary">Tercer trimestre</li>
									  <li class="list-group-item active">Julio</li>
									  <li class="list-group-item ">Agosto</li>
									  <li class="list-group-item ">Septiembre</li>
									  </ul>';

							break;

						case 8:
							echo '<ul class="list-group">
								  <li class="list-group-item list-group-item-secondary">Tercer trimestre</li>
								  <li class="list-group-item ">Julio</li>
								  <li class="list-group-item active">Agosto</li>
								  <li class="list-group-item ">Septiembre</li>
								  </ul>';
							break;

						case 9:
							echo '<ul class="list-group">
								  <li class="list-group-item list-group-item-secondary">Tercer trimestre</li>
								  <li class="list-group-item ">Julio</li>
								  <li class="list-group-item ">Agosto</li>
								  <li class="list-group-item active">Septiembre</li>
								  </ul>';
							break;

						default:
							echo '<ul class="list-group">
								  <li class="list-group-item list-group-item-secondary">Cuarto trimestre</li>
								  <li> class="list-group-item active">Año</li>
								  </ul>';
								  
							break;
					}
				?>
			
			</div>
			
			
		</section>
	</main>
	<script src="js/jquery-3.4.1.js"></script>
	<script src="js/bootstrap.min.js"></script>
</body>
</html>