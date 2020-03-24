<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Herencia</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-md-6 offset-md-3">
				<h1 class="h3">Herencia</h1>
				<hr>
				<?php
					class ArithmeticOperation {
						protected $n1;
						protected $n2;
						protected $rs;

						public function __construct($n1, $n2){
							$this->n1 = $n1;
							$this->n2 = $n2;

						}
					}
					class Sum extends ArithmeticOperation {
						public function calculate(){
							return $this->rs = "La suma de ".$this->n1." y ".$this->n2."=".($this->n1 + $this->n2);
						}
					}
					class Subtraction extends ArithmeticOperation {
						public function calculate(){
							return $this->rs = "La resta de ".$this->n1." y ".$this->n2." = ".($this->n1 - $this->n2);
						}
					}
					class Division extends ArithmeticOperation {
						public function calculate(){
							return $this->rs = "La division entre ".$this->n1." y ".$this->n2." = ".($this->n1 / $this->n2);
						}
					}
					class Product extends ArithmeticOperation {
						public function calculate(){
							return $this->rs = "El producto de ".$this->n1." por ".$this->n2." = ".($this->n1 * $this->n2);
						}
					}

					class Exponentiation extends ArithmeticOperation {
						public function calculate(){
							return $this->rs = "El Número ".$this->n1." elevado a la ".$this->n2." = ".pow($this->n1, $this->n2);
						}
					}

					$op = new Sum(7, 23);
					echo "<div class='alert alert-info'>";
					echo $op->calculate();
					echo "</div>";

					$op = new Subtraction(89, 45);
					echo "<div class='alert alert-info'>";
					echo $op->calculate();
					echo "</div>";

					$op = new Division(45, 3);
					echo "<div class='alert alert-info'>";
					echo $op->calculate();
					echo "</div>";

					$op = new Product(25, 2);
					echo "<div class='alert alert-info'>";
					echo $op->calculate();
					echo "</div>";

					$op = new Exponentiation(4, 3);
					echo "<div class='alert alert-info'>";
					echo $op->calculate();
					echo "</div>";
				 ?>

			</div>
 		</div>
	</div>
</body>
</html>