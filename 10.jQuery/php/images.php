<?php
	if($_POST){
		$img = $_POST['img'];
		switch ($img) {
			case '1':
				echo "img/naruto.jpg";
				break;
			case '2':
				echo "img/gara.jpg";
				break;
			case '3':
				echo "img/sasuke.jpg";
				break;
			default:
				echo "img/noimg.jpg";
				break;
		}
	} 







 ?>