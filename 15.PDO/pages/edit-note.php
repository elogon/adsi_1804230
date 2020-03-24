<!-- Page Wrapper -->
  <div id="wrapper">

   <?php include 'menu-teacher.php'; ?>

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <?php include 'navbar-teacher.php'; ?>

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="fa fa-pen"> Modificar Notas</h1>
          </div>

          <!-- Content Row -->
          <div class="row">

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-6 mb-4">
              <form action="" method="post" enctype="multipart/form-data">
                <?php $id = $_GET['id']; ?>
                <?php $note = showNotes($id, $conn) ?>
                <?php foreach ($note as $nt  ): ?>
                <div class="form-group">
                  <label for="names">Materia: </label>
                  <select name="subject_id" class="form-control">
                    <?php $sbs = listSubject($conn); ?>
                    <option value="">Seleccione..</option>
                    <?php foreach ($sbs as $sb): ?>
                      <option value="<?php echo $sb['id'] ?>" <?php if($nt['subject_id'] == $sb['id']) echo "selected" ?>><?php echo $sb['name'] ?></option>
                    <?php endforeach ?>
                  </select>
                </div>

               <div class="form-group">
                  <label for="names">Estudiante: </label>
                  <select name="user_id" class="form-control">
                    <?php $sts = listStudents($conn); ?>
                    <option value="">Seleccione..</option>
                    <?php foreach ($sts as $st): ?>
                      <option value="<?php echo $st['id'] ?>" <?php if($st['status'] == "Inactive") echo "disabled"; ?> <?php if($nt['user_id'] == $st['id']) echo "selected" ?>><?php echo $st['names']; ?></option>
                    <?php endforeach ?>
                  </select>
                </div>

                <div class="form-group">
                  <label for="nt1">Nota 1:</label>
                  <input type="number" class="form-control" name="nt1" step="0.1" min="0" max="5" value="<?php echo $nt['nt1'] ?>" required>
                </div>

                <div class="form-group">
                  <label for="nt2">Nota 2:</label>
                  <input type="number" class="form-control" name="nt2" step="0.1" min="0" max="5" value="<?php echo $nt['nt2'] ?>"required>
                </div>

                <div class="form-group">
                  <label for="nt3">Nota 3:</label>
                  <input type="number" class="form-control" name="nt3" step="0.1" min="0" max="5" value="<?php echo $nt['nt3'] ?>"required>
                </div>

                <div class="form-group">
                  <button class="btn btn-success">
                    <i class="fa fa-save"></i>
                    Modificar
                  </button>
                  <button type="reset" class="btn btn-dark">
                    <i class="fa fa-eraser"></i>
                    Limpiar
                  </button>
                </div>
                <?php endforeach ?>
              </form>
              <?php 
                if($_POST){
                  
                  $id         = $_POST['id'];
                  $subject_id = $_POST['subject_id'];
                  $user_id    = $_POST['user_id'];
                  $nt1        = $_POST['nt1'];
                  $nt2        = $_POST['nt2'];
                  $nt3        = $_POST['nt3'];

                  if(updateNote($id, $subject_id, $user_id, $nt1, $nt2, $nt3, $conn)){
                    $_SESSION['message'] = "Las notas se modificaron con Éxito!";
                    echo "<script>
                      setTimeout(function(){
                        window.location.replace('../mod-notes.php');
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