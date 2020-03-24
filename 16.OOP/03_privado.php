<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Atributos/Métodos (Privados)</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-md-6 offset-md-3">
				<h1 class="h4 text-center">Atributos/Métodos (Privados)</h1>
				<form action="" method="post">
					<div class="form-group">
						<label for="nf">Numero de Filas:</label>
						<input type="number" name="nf" class="form-control" min="1" max="99" required>
					</div>
					<div class="form-group">
						<label for="nc">Numero de Columnas:</label>
						<input type="number" name="nc" class="form-control" min="1" max="99" required>
					</div>
					<div class="from-group">
						<button class="btn btn-dark" type="submit">
							Gráficar Tabla
						</button>
					</div>
				</form>
			</div>
 		</div>
 		<div class="row">
 			<div class="col-md-12">
 				<?php 
 					if($_POST){
 						$nf = $_POST['nf'];
 						$nc = $_POST['nc'];

 						class Table {
 							private $nf;
 							private $nc;

 							public function __construct($nf, $nc) {
 								$this->nf = $nf;
 								$this->nc = $nc;

 							}
 							public function drawTable(){
 								$this->startTable();
 								for ($i=1; $i <= $this->nf ; $i++) { 
 									echo "<tr>";
 									for ($j=1; $j <= $this->nc ; $j++) { 
 										echo "<td>";
 										echo "F:".$i."C:".$j;
 										echo "</td>";

 									}
 									echo "</tr>";
 								}
 								$this->endTable();
 							}
 							private function startTable(){
 								echo "<table class='table table-striped table-bordered'>";
 							}
 							private function endTable(){
 								echo "</table";
 							
 							}
 						}
 						$tbl = new Table($nf, $nc);
 						$tbl->drawTable();
 					}
 				?>
 			</div>
 		</div>
	</div>
</body>
</html>




