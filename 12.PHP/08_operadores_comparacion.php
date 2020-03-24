<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Operadores Comparación</title>
	<link rel="stylesheet" href="css/bootstrap-reboot.min.css">
	<link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
	<main class="container">
		<section class="row mt-5">
			<div class="col-md-8 offset-md-2">
				<h1 class="text-center text-dark">Operadores Comparación</h1>
				<hr>
				<table class="table table-bordered table-striped table-hover table-dark">
					<thead class="bg-secondary text-uppercase">
						<tr>
							<th>Operador</th>
							<th>Descripción</th>
							<th>Ejemplo</th>
							<th>Resultado</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td> == </td>
							<td> Es Igual </td>
							<td>5==8;</td>
							<td><?php echo var_dump(5==8); ?></td>
						</tr>
						<tr>
							<td> != </td>
							<td> No es Igual </td>
							<td>5!=8;</td>
							<td><?php echo var_dump(5!=8); ?></td>
						</tr>
						<tr>
							<td> <> </td>
							<td> No es Igual </td>
							<td>5<>8;</td>
							<td><?php echo var_dump(5<>8); ?></td>
						</tr>
						<tr>
							<td> > </td>
							<td> Es Mayor que </td>
							<td>5>8;</td>
							<td><?php echo var_dump(5>8); ?></td>
						</tr>
						<tr>
							<td> < </td>
							<td> Es Menor que </td>
							<td>5<8;</td>
							<td><?php echo var_dump(5<8); ?></td>
						</tr>
						<tr>
							<td> >= </td>
							<td> Es Mayor o Igual que </td>
							<td>5>=8;</td>
							<td><?php echo var_dump(5>=8); ?></td>
						</tr>
						<tr>
							<td> <= </td>
							<td> Es Menor o Igual que </td>
							<td>5<=8;</td>
							<td><?php echo var_dump(5<=8); ?></td>
						</tr>
					</tbody>
				</table>
			</div>
		</section>
	</main>
	<script src="js/jquery-3.4.1.js"></script>
	<script src="js/bootstrap.min.js"></script>
</body>
</html>