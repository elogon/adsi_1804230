<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Instancia de</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-md-6 offset-md-3 mt-5">
				<h1 class="h3 text-center">Instancia de</h1>
				<hr>
				<ul class="list-group">
					<?php
						class Bike {
							protected $brand;
							protected $price;
							protected $type;

							public function __construct($brand, $price){
								$this->brand = $brand;
								$this->price = $price;
							}

							public function setBike($type){
								if ($type instanceOf Road)   $this->type =  'Road';
								if ($type instanceOf Mtb)    $this->type =  'Mtb';
								if ($type instanceOf Enduro) $this->type =  'Enduro';
							}
							public function getInfoBike() {
								return "<li class='list-group-item'>".$this->brand." - $".$this->price." - ".$this->type."</li>";
							}
						}
						class Road extends Bike { }
						class Mtb extends Bike { }
						class Enduro extends Bike { }

						$bk = new Road('Specialized', 4000);
						$bk->setBike($bk);
						echo $bk->getInfoBike();

						$bk = new Mtb('Trek', 3200);
						$bk->setBike($bk);
						echo $bk->getInfoBike();

						$bk = new Enduro('SantaCruz', 5200);
						$bk->setBike($bk);
						echo $bk->getInfoBike();

					?>
				</ul>
				
			</div>
		</div>
	</div>
</body>
</html>