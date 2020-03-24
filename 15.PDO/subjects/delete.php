<?php include '../config/app.php'; ?>
<?php include '../config/database.php'; ?>
<?php include '../config/security-teacher.php'; ?>

<?php 
	if($_GET){
		$id = $_GET['id'];
		if(deleteSubject($id, $conn)){
			$_SESSION['message'] = "La materia fue eliminada con Éxito!";
	            echo "<script>
	              setTimeout(function(){
	                window.location.replace('../mod-subjects.php');
	              },1200);
	            </script>";
		}
	}

?>
<?php $conn = null; ?>
<?php include '../includes/footer.php'; ?>