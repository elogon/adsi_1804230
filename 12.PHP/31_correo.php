<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Correo Electrónico</title>
	<link rel="stylesheet" href="css/bootstrap-reboot.min.css">
	<link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
	<main class="container">
		<section class="row mt-5">
			<div class="col-md-8 offset-md-2">
				<h1 class="text-center text-dark">Correo Electrónico</h1>
				<hr>
				<form action="" method="POST">
					<div class="form-group">
						<input type="email" class="form-control" name="email" placeholder="Correo">
					</div>
					<div class="form-group">
						<textarea name="text" class="form-control" name="subject" placeholder="Asunto"></textarea>
						
					</div>
					
					<div class="form-group">
						<textarea name="message" rows="4" class="form-control" placeholder="Mensaje"></textarea>
						
					</div>
					<div class="form-group">
						<input type="submit" value="Enviar" class="btn btn-outline-success">
						<input type="reset" value="Limpiar" class="btn btn-outline-secondary">
						
					</div>
				</form>
				<?php 
					if ($_POST) {
						$email   = $_POST['email'];
						$subject = $_POST['subject'];
						$message = $_POST['message'];
					
				?>
				<?php if (mail('jtvillada6@misena.edu.co', "Asunto: $subject", "Mensaje: $message", "De: $email")): ?>
					<div class="alert alert-success">
						El email se ha enviado con exito!
					</div>
				<?php else: ?>
					<div class="alert alert-danger">
						El email no pudo enviar
					</div>
					
				<?php endif ?>
			<?php } ?>
			</div>
			
			
		</section>
	</main>
	<script src="js/jquery-3.4.1.js"></script>
	<script src="js/bootstrap.min.js"></script>
</body>
</html>