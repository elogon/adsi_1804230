<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Método Abstracto</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-md-6 offset-md-3 mt-5">
				<h1 class="h3 text-center">Método Abstracto</h1>
				<hr>
				<ul class="list-group">
				<?php 
				   abstract class VideoGame {
				   	 protected $name;
				   	 protected $platform;
				   	 protected $year;

				   	 public function __construct($nm, $pt, $yr){
				   	 	$this->name     = $nm;
				   	 	$this->platform = $pt;
				   	 	$this->year     = $yr;


				   	 }

				   	 public abstract function getInfoVideoGame();
				   }

				   class Zelda extends VideoGame {
				   	  public function getInfoVideoGame() {
				   	  	return $this->name." | ".$this->platform." | ".$this->year;
				   	  }
				   }

				   $vg1 = new Zelda('Zelda Ocarine of Time','Nintendo 64', 1999);
				   echo "<li class='list-group-item'>".$vg1->getInfoVideoGame()."</li>";

				   $vg2 = new Zelda('Zelda Majora Mask','Nintendo 64', 2000);
				   echo "<li class='list-group-item'>".$vg2->getInfoVideoGame()."</li>";

				   $vg3 = new Zelda('Zelda Twilight Princess','Nintendo Wii ', 2006);
				   echo "<li class='list-group-item'>".$vg3->getInfoVideoGame()."</li>";

				   $vg4 = new Zelda('Zelda Breath of the Wild','Nintendo Switch', 2017);
				   echo "<li class='list-group-item'>".$vg4->getInfoVideoGame()."</li>";
				?>
				</ul>
			</div>
		</div>
	</div>
</body>
</html>