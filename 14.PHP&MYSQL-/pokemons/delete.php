<?php 
	include '../config/app.php';
	include '../config/db.php';

 	if(isset($_GET['id'])) {
 		$id = $_GET['id'];
 		$sql = "DELETE FROM pokemons WHERE id = ".$id;
 		if (mysqli_query($con, $sql)) {
 			$_SESSION['message'] = "El pokemon fue eliminado con exito!";
 			echo "<script>window.location.replace('index.php');</script>";
 		}else {
 			echo "Error".mysqli_error($con);
 		}

 	}
 ?>