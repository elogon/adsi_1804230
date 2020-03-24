<?php 
	if(isset($_SESSION['unames'])){
		if($_SESSION['urole'] == "Teacher"){
			echo "<script>window.location.replace('dashboard-teacher.php');</script>";
		}else{
			echo "<script>window.location.replace('dashboard-student.php');</script>";
		}
	}
?>