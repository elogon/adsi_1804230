0<?php 
	include '../config/app.php';
	include '../config/db.php'
?>

<?php include '../includes/header.php'; ?>

			<div class="col-md-8 offset-md-2">
				<h1 class="text-center text-muted">
					<i class="fa fa-paw fa-2x"></i>
					MÓDULO POKEMONES
				</h1>
				<hr>
				<nav arial-label="breadcrumb">
					<ol class="breadcrumb">
						<li class="breadcrumb-item">
							<a href="<?php echo $url; ?>">
								<i class="fa fa-home"></i>
							Inicio
							</a>
						</li>
						<li class="breadcrumb-item active" aria-current="page">
							Módulo Pokemones
						</li>
					</ol>
				</nav>
				<?php
					$sql = "SELECT t.name AS name_trainer, p.* 
							FROM trainers AS t, pokemons AS p 
							WHERE t.id = p.trainer_id ORDER BY p.id ASC";
					$result = mysqli_query($con, $sql);

				?>
				<a href="add.php" class="btn btn-success">
					<i class="fa fa-plus"></i>
					Adicionar Pokemon
				</a>
				<br><br>
				<table class="table table-hover table table-striped table-bordered">
					<thead class="thead-dark text-center">
						<tr>
							<th>Nombre</th>
							<th>Tipo</th>
							<th>Entrenador</th>
							<th>Acciones</th>
						</tr>
					</thead>
					<tbody class="text-center">
						<?php while($row = mysqli_fetch_array($result)){ ?>
							<tr>
								<td><?php echo $row['name']; ?></td>
								<td><?php echo $row['type']; ?></td>
								<td><?php echo $row['name_trainer']; ?></td>
								<td>
									<a href="show.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-light">
										<i class="fa fa-search"></i>
									</a>
									<a href="update.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-light">
										<i class="fa fa-pen"></i>
									</a>
									<a href="javascript:;" class="btn btn-sm btn-danger btn-delete" data-id="<?php echo $row['id']; ?>">
										<i class="fa fa-trash"></i>
									</a>
								</td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>	

<?php include '../includes/footer.php'; ?>