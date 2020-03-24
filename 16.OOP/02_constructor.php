<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Metodo Constructor</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>
	<div class="container">
		<div class="row">
	<?php 
	
	class PlayList {
		// Attributes
		private $name;
		private $artist  =array();
		private $album   =array();
		private $image   =array();
		private $year  	 =array();
		private $type    =array();

		// Método Constructor
		public function __constructor($nm) {
			$this->name  = $nm;
		}
		public function setPlayList($ar, $al, $im, $y, $t) {
			// To do
			$this->artist[]  =$ar;
			$this->album[]   =$al;
			$this->image[]   =$im;
			$this->year[]    =$y;
			$this->type[]    =$t;
		}
		public function getPlayList() {
			for ($i=0; $i < count($this->artist); $i++){
			echo "<div class='col-md-4'>";
			echo "<div class='card'>";
  			echo "<img src='".$this->image[$i]."' class='card-img-top'>";
  			echo "<div class='card-body'>";
  			echo "<h5 class='card-title'>".$this->name."</h5>";
  			echo "</div>";
  			echo "<ul class='list-group list-group-flush'>";
  			echo "<li class='list-group-item'>".$this->artist[$i]."</li>";
  			echo "<li class='list-group-item'>".$this->album[$i]."</li>";
  			echo "<li class='list-group-item'>".$this->year[$i]."</li>";
  			echo "<li class='list-group-item'>".$this->type[$i]."</li>";
  			echo "</ul>";
  			echo "</div>";
			echo "</div>";
			}
		}
	}

	$pl = new PlayList('Variada 2019');
	$pl->setPlayList ('Metallica', 'Master of Puppets', 'http://tiny.cc/0pfchz',1998, 'Metal');
	$pl->setPlayList ('GreenDay', 'Dookie', 'http://tiny.cc/5xfchz',1997, 'Pop Punk');
	$pl->setPlayList ('Limpbizkit', 'Results May Vary', 'http://tiny.cc/t3fchz',2000, 'Pop Punk');
	$pl->getPlayList();
 ?>
 		</div>
	</div>
</body>
</html>

