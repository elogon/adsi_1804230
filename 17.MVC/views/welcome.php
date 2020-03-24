<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>MVC - OOP</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>

	<div class="container">
		<div class="row">
			<div class="col-md-10 offset-md-1 mt-5">
				<h1> <i class="fa fa-users"></i> Lista de Usuarios</h1>
				<hr>
				<a href="?method=add" class="btn btn-success mb-3">
					<i class="fa fa-plus"></i> 
					Adicionar Usuario
				</a>
				<table class="table table-striped table-hover">
					<thead>
						<tr>
							<th>Nombre Completo</th>
							<th class="d-none d-sm-table-cell">Fecha Nacimiento</th>
							<th class="d-none d-sm-table-cell">Correo Electrónico</th>
							<th>Rol</th>
							<th>Acciones</th>
						</tr>
					</thead>
					<tbody>
						<?php 
							while($row = mysqli_fetch_array($data)) {
						?>
							<tr>
								<td><?php echo $row['names'] ?></td>
								<td class="d-none d-sm-table-cell"><?php echo $row['birthdate'] ?></td>
								<td class="d-none d-sm-table-cell"><?php echo $row['email'] ?></td>
								<td><?php echo $row['role'] ?></td>
								<td>
									<a href="?method=show&id=<?php echo $row['id'] ?>" class="btn btn-light btn-sm"><i class="fa fa-search"></i></a>
									<a href="?method=edit&id=<?php echo $row['id'] ?>" class="btn btn-light btn-sm"><i class="fa fa-pencil"></i></a>
									<a href="javascript:;" class="btn btn-danger btn-sm btn-delete" data-id="<?php echo $row['id'] ?>"><i class="fa fa-trash"></i></a>
								</td>
							</tr>
						<?php
							}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<script src="https://cdn.jsdelivr.net/npm/jquery@3.4.1/dist/jquery.min.js"></script>
	<script>
		$(document).ready(function() {
			$('.btn-delete').click(function(event) {
				$id = $(this).attr('data-id');
				if(confirm("Realmente desea eliminar este Usuario?")) {
					window.location.replace('?method=delete&id='+$id);
				}
			});
		});
	</script>
</body>
</html>