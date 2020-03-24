<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Ciclos (Do While)</title>
	<link rel="stylesheet" href="css/bootstrap-reboot.min.css">
	<link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
	<main class="container">
		<section class="row mt-5">
			<div class="col-md-8 offset-md-2 text-center">
				<h1 class="text-center text-dark">Ciclos (Do While)</h1>
				<hr>
				<nav>
					<ul class="pagination pagination-sm ustify-content-center ">
						<li class="page-item"><a class="page-link" href="#">Previous</a></li>
						<?php 
								for ($i=1; $i <=100 ; $i++) {
								    if($i % 5 == 0) {
										if($i == 50) {
											echo '<li class="page-item active"><a class="page-link" href="#">'.$i.'</a></li>';
										} else {
											echo '<li class="page-item"><a class="page-link" href="#">'.$i.'</a></li>';
										}
								   		
								    }
								}
						?>
						<li class="page-item"><a class="page-link" href="#">Next</a></li>
					</ul>
				</nav>
			</div>
		</section>
	</main>
	<script src="js/jquery-3.4.1.js"></script>
	<script src="js/bootstrap.min.js"></script>
</body>
</html>