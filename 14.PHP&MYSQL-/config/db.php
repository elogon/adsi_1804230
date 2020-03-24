<?php 
	//Configuración base de datos
	$host = "localhost";
	$user = "root";
	$pass = "";
	$ndb = "adsi1804230";
	//Conexión base de datos
	$con = mysqli_connect($host, $user, $pass, $ndb);
	if(mysqli_connect_errno()){
		echo "<span class='alert alert-danger'><strong>Error: </strong>".mysqli_connect_error()."</span>";
	}