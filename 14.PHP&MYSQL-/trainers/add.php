<?php 
	include '../config/app.php';
	include '../config/db.php'
?>

<?php include '../includes/header.php'; ?>

			<div class="col-md-8 offset-md-2">
				<h1 class="text-center text-muted">
					<i class="fa fa-plus fa-2x"></i>
					ADICIONAR ENTRENADOR
				</h1>
				<hr>
				<nav aria-label="breadcrumb">
					<ol class="breadcrumb">
						<li class="breadcrumb-item">
							<a href="<?php echo $url; ?>">
								<i class="fa fa-home"></i>
								Inicio
							</a>
						</li>
						<li class="breadcrumb-item">
							<a href="<?php echo $url; ?>trainers/">
								<i class="fa fa-users"></i>
								Módulo Entrenadores
							</a>
						</li>
						<li class="breadcrumb-item active" aria-current="page">
							Adicionar Entreandor
						</li>
					</ol>
				</nav>
				<hr>
				<form action="" method="post">
					<div class="form-group">
						<label for="name">Nombre:</label>
						<input class="form-control" type="text" name="name" required>
					</div>
				
					<div class="form-group">
						<label for="name">Nivel:</label>
						<input class="form-control" type="number" name="level"  required>
					</div>
					
					

					<div class="form-group">
						<?php 
							$sql = "SELECT * FROM gyms";
							$result = mysqli_query($con, $sql)
						?>
						<label for="trainer_id">Gimnasio:</label>
						<select name="gym_id" class="form-control" required>
							<option value="">Seleccione...</option>
							<?php while($row = mysqli_fetch_array($result)) { ?>
								<option value="<?php echo $row['id'] ?>">
									<?php echo $row['name'] ?>
								</option>
							<?php } ?>
						</select>
					</div>

					<div class="form-group">
						<button type="submit" class="btn- btn-success">
							<i class="fa fa-save"></i>
							Crear Entrenador
						</button>
					

						<button type="reset" class="btn- btn-light" onclick="">
							<i class="fa fa-eraser"></i>
							Limpiar formulario
						</button>
					</div>
				</form>
				<?php 
					if($_POST) {
						$name 	  = mysqli_real_escape_string($con, $_POST['name']);
						$level	  = mysqli_real_escape_string($con, $_POST['level']);
						$gym_id = mysqli_real_escape_string($con, $_POST['gym_id']);

						$sql = "INSERT INTO trainers VALUES(DEFAULT, '$name', $level, 
						                                   			  $gym_id)";
						if (mysqli_query($con, $sql)) {
							$_SESSION['message'] ="El entrenador" . $name . "fue adicionado con exito!";
							echo "<script>window.location.replace('index.php');</script>";
						} else {
							echo "Error".mysqli_error($con);
						}
					}
				?>
			</div>

<?php include '../includes/footer.php'; ?>