<?php 
	include '../config/app.php';
	include '../config/db.php'
?>

<?php include '../includes/header.php'; ?>

			<div class="col-md-8 offset-md-2">
				<h1 class="text-center text-muted">
					<i class="fa fa-pen fa-2x"></i>
					MODIFICAR ENTRENADOR
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
								<i class="fa fa-users"></i>
								Módulo Entrenador
							</a>
						</li>
						<li class="breadcrumb-item active" aria-current="page">
							Modificar Entrenador
						</li>
					</ol>
				</nav>
				
				<br><br>
				<?php 
						if(isset($_GET['id'])){
							$id = $_GET['id'];
							$sql = "SELECT * FROM trainers WHERE id = $id";
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
						<label for="name">Nivel: </label>
						<input class="form-control" type="number" name="level" value="<?php echo $row['level'] ?>" required>
					</div>
					<div class="form-group">
						<?php 
							$sql= "SELECT * FROM gyms";
							$result = mysqli_query($con, $sql);
						?>
						<label for="trainer_id">Gimnasio: </label>
						<select name="gym_id" class="form-control">
							<option value="">Seleccione...</option>
							<?php while($rowg = mysqli_fetch_array($result)){ ?>
								<option value="<?php echo $rowg['id'] ?>"<?php if($rowg['id'] == $row['gym_id']): ?> selected <?php endif ?>>
									<?php echo $rowg['name'] ?>	
								</option>
							<?php } ?>
						</select>
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-success">
							<i class="fa fa-save"></i>
							Modificar Entrenador
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
						$id     = mysqli_real_escape_string($con, $_POST['id']);
						$name   = mysqli_real_escape_string($con, $_POST['name']);
						$level  = mysqli_real_escape_string($con, $_POST['level']);
						$gym_id = mysqli_real_escape_string($con, $_POST['gym_id']);

						$sql = "UPDATE trainers SET name     = '$name', 
													level    = $level, 
													gym_id   = $gym_id
													WHERE id = $id";

						if (mysqli_query($con, $sql)) {
							$_SESSION['message'] = "El entrenador ". $name ." fué modificado con éxito!";
							echo "<script>window.location.replace('index.php');</script>";
						}else{
							echo "Error".mysqli_error($con);
						}
					}
				?>
			</div>	

<?php include '../includes/footer.php'; ?>