<!-- Page Wrapper -->
  <div id="wrapper">

   <?php include 'menu-teacher.php'; ?>

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <?php include 'navbar-teacher.php' ?>

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="fa fa-plus"> Adicionar Aprendiz</h1>
          </div>

          <!-- Content Row -->
          <div class="row">

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-6 mb-4">
              <form action="" method="post" enctype="multipart/form-data">
                <div class="form-group">
                  <label for="names">Nombre Completo: </label>
                  <input type="text" class="form-control" name="names" required>
                </div>

                <div class="form-group">
                  <label for="birthdate">Fecha Nacimiento: </label>
                  <input type="date" class="form-control" name="birthdate" placeholder="DD/MM/AAAA" required>
                </div>

                <div class="form-group">
                  <label for="email">Correo Electrónico: </label>
                  <input type="email" class="form-control" name="email" required>
                </div>

                <div class="form-group">
                  <label for="photo">Foto: </label>
                  <input type="file" class="form-control-file" accept="image/*" name="photo" required>
                </div>

                <div class="form-group">
                  <label for="password">Contraseña: </label>
                  <input type="password" class="form-control" name="password" required>
                </div>

                <div class="form-group">
                  <button class="btn btn-success">
                    <i class="fa fa-save"></i>
                    Guardar
                  </button>
                  <button type="reset" class="btn btn-dark">
                    <i class="fa fa-eraser"></i>
                    Limpiar
                  </button>
                </div>
              </form>
              <?php 
                if($_POST){
                  /*var_dump($_POST);
                  var_dump($_FILES);*/

                  $names = $_POST['names'];
                  $birthdate = $_POST['birthdate'];
                  $email = $_POST['email'];
                  $password = md5($_POST['password']);
                  $path = "public/imgs/";
                  $photo = $path.time().".".pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
                  move_uploaded_file($_FILES['photo']['tmp_name'], '../'.$photo);

                  if(saveStudent($names, $birthdate, $email, $photo, $password, $conn)){
                    $_SESSION['message'] = "El estudiante $names se Adicionó con Éxito!";
                    echo "<script>
                      setTimeout(function(){
                        window.location.replace('../mod-users.php');
                      },1200);
                    </script>";
                  }
                }
              ?>
            </div>   
          </div>
        </div>
      </div>
      <!-- /.container-fluid -->

      
      <!-- End of Main Content -->

      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Todos los derechos reservados &copy; <?php echo date('Y'); ?></span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->
  </div>
  <!-- End of Page Wrapper -->