<?php 
	include '../config/app.php';
	include '../config/db.php'
?>

<?php include '../includes/header.php'; ?>

			<div class="col-md-8 offset-md-2">
				<h1 class="text-center text-muted">
					<i class="fa fa-pen fa-2x"></i>
					MODIFICAR POKEMON
				</h1>
				<hr>
				<nav area-label = "breadcrumb">
					<ol class="breadcrumb">
						<li class="breadcrumb-item">
							<a href="<?php echo $url; ?>">
								<i class="fa fa-home"></i>
								Inicio
							</a>
						</li>
						<li class="breadcrumb-item">
							<a href="<?php echo $url; ?>pokemons/">
								<i class="fa fa-paw"></i>
								Módulo Pokemones
							</a>
						</li>
						<li class="breadcrumb-item active" aria-current="page">
							Modificar Pokemon
						</li>
					</ol>
				</nav>
				
				<br><br>
				<?php 
						if(isset($_GET['id'])){
							$id = $_GET['id'];
							$sql = "SELECT * FROM pokemons WHERE id = $id";
							$result = mysqli_query($con, $sql);
							while($row = mysqli_fetch_array($result)){
				?>
				<form action="" method="post">
					<div class="form-group">
						<input type="hidden" name="id" value="<?php echo $row['id'] ?>">
						<label for="name">Nombre: </label>
						<input class="form-control" type="text" name="name" value="<?php echo $row['name'] ?>" required>
					</div>
					<div class="form-group">
						<label for="name">Tipo: </label>
						<input class="form-control" type="text" name="type" value="<?php echo $row['type'] ?>" required>
					</div>
					<div class="form-group">
						<label for="name">Fuerza: </label>
						<input class="form-control-range" type="range" name="strength" min="0" max="2000" step="5" value="<?php echo $row['strength'] ?>" oninput="ostrength.value=this.value" required>
						<output id="ostrength" class="badge badge-dark"></output>
					</div>
					<div class="form-group">
						<label for="stamina">Resistencia: </label>
						<input class="form-control-range" type="range" name="stamina" min="0" max="2000" step="5" value="<?php echo $row['stamina'] ?>" oninput="ostamina.value=this.value" required>
						<output id="ostamina" class="badge badge-dark"></output>
					</div>
					<div class="form-group">
						<label for="speed">Velocidad: </label>
						<input class="form-control-range" type="range" name="speed" min="0" max="2000" step="5" value="<?php echo $row['speed'] ?>" oninput="ospeed.value=this.value" required>
						<output id="ospeed" class="badge badge-dark"></output>
					</div>
					<div class="form-group">
						<label for="accuracy">Precisión: </label>
						<input class="form-control-range" type="range" name="accuracy" min="0" max="2000" step="5" value="<?php echo $row['accuracy'] ?>" oninput="oaccuracy.value=this.value" required>
						<output id="oaccuracy" class="badge badge-dark"></output>
					</div>
					<div class="form-group">
						<?php 
							$sql= "SELECT * FROM trainers";
							$result = mysqli_query($con, $sql);
						?>
						<label for="trainer_id">Entrenador: </label>
						<select name="trainer_id" class="form-control">
							<option value="">Seleccione...</option>
							<?php while($rowt = mysqli_fetch_array($result)){ ?>
								<option value="<?php echo $rowt['id'] ?>"<?php if($rowt['id'] == $row['trainer_id']): ?> selected <?php endif ?>>
									<?php echo $rowt['name'] ?>	
								</option>
							<?php } ?>
						</select>
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-success">
							<i class="fa fa-save"></i>
							Modificar Pokemon
						</button>
						<button type="submit" class="btn btn-light">
							<i class="fa fa-eraser"></i>
							Limpiar formulario
						</button>
					</div>
				</form>
				<?php }} ?>
				<?php 
					if ($_POST) {
						$id         = mysqli_real_escape_string($con, $_POST['id']);
						$name       = mysqli_real_escape_string($con, $_POST['name']);
						$type       = mysqli_real_escape_string($con, $_POST['type']);
						$strength   = mysqli_real_escape_string($con, $_POST['strength']);
						$stamina    = mysqli_real_escape_string($con, $_POST['stamina']);
						$speed      = mysqli_real_escape_string($con, $_POST['speed']);
						$accuracy   = mysqli_real_escape_string($con, $_POST['accuracy']);
						$trainer_id = mysqli_real_escape_string($con, $_POST['trainer_id']);

						$sql = "UPDATE pokemons SET name = '$name', 
													type = '$type', 
													strength = $strength, 
													stamina = $stamina, 
													speed = $speed, 
													accuracy = $accuracy, 
													trainer_id = $trainer_id
													WHERE id = $id";

						if (mysqli_query($con, $sql)) {
							$_SESSION['message'] = "El pokemón ".$name." fué modificado con éxito!";
							echo "<script>window.location.replace('index.php');</script>";
						}else{
							echo "Error".mysqli_error($con);
						}
					}
				?>
			</div>	

<?php include '../includes/footer.php'; ?>