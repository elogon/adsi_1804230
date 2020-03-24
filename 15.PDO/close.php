<?php
	session_start();

	unset($_SESSION['message']);
	unset($_SESSION['error']);
    unset($_SESSION['unames']);
    unset($_SESSION['uphoto']);
    unset($_SESSION['urole']);
    unset($_SESSION['ustatus']);

    if(session_destroy()){
    	echo "<script>window.location.replace('index.php')</script>";
    }
?>