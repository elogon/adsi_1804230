<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Subir Archivos</title>
	<link rel="stylesheet" href="css/bootstrap-reboot.min.css">
	<link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
	<main class="container">
		<section class="row mt-5">
			<div class="col-md-8 offset-md-2">
				<h1 class="text-center text-dark">Subir Archivos</h1>
				<hr>
				<form action="" method="POST" enctype="multipart/form-data">
					<div class="form-group">
						<input type="file" class="form-control-file" name="foto" accept="image/*">
					</div>
					<div class="form-group">
						<button class="btn btn-success" type="submit" >Subir Foto</button>
					</div>
				</form>
				<?php if ($_FILES): ?>
					<?php if ($_FILES['foto']['error'] > 0): ?>
						<div class="alert alert-danger">
							<strong>Error:></strong> Debe seleccionar una imagen.
						</div>
					<?php else: ?>
						<?php move_uploaded_file($_FILES['foto']['tmp_name'], 'uploads/'.$_FILES['foto']['name']) ?>
						<div class="alert alert-success">
							<strong>
								El archivo se ha subido con exito!
							</strong>
							<li>
								<?php echo $_FILES['foto']['name'] ?>
							</li>
							<li>
								<?php echo $_FILES['foto']['type'] ?>
							</li>
							<li>
								<?php echo round($_FILES['foto']['size'] / 1024)?> KB
							</li>
						</div>
					<?php endif ?>
				<?php endif ?>
			</div>
		</section>
	</main>
	<script src="js/jquery-3.4.1.js"></script>
	<script src="js/bootstrap.min.js"></script>
</body>
</html>