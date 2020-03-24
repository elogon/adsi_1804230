<?php include 'config/app.php'; ?>

<?php include 'includes/header.php'; ?>

			<div class="col-md-8 offset-md-2">
				<h1 class="text-center text-muted">PHP & MYSQL</h1>
				<hr>
				<div class="jumbotron text-center">
					<img src="<?php echo $imgs ?>logo.png" width="180px">
					<br><br>
					<div class="btn-group-vertical">
						<a class="btn btn-outline-dark" href="pokemons/index.php">
							<i class="fa fa-paw fa-2x"></i>
							Módulo Pokemones
						</a>
						<a class="btn btn-outline-dark"href="trainers/">
							<i class="fa fa-users fa-2x"></i>
							Módulo Entrenadores
						</a>
						<a class="btn btn-outline-dark"href="gyms/">
							<i class="fa fa-building fa-2x"></i>
							Módulo Gimnasios
						</a>
					</div>
				</div>
			</div>	

<?php include 'includes/footer.php'; ?>