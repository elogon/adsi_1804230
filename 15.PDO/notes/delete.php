<?php include '../config/app.php'; ?>
<?php include '../config/database.php'; ?>
<?php include '../config/security-teacher.php'; ?>

<?php 
	if($_GET){
		$id = $_GET['id'];
		if(deleteNote($id, $conn)){
			$_SESSION['message'] = "Las Notas fueron eliminadas con Éxito!";
	            echo "<script>
	              setTimeout(function(){
	                window.location.replace('../mod-notes.php');
	              },1200);
	            </script>";
		}
	}

?>
<?php $conn = null; ?>
<?php include '../includes/footer.php'; ?>