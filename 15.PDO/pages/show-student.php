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
            <h1 class="fa fa-search"> Consultar Aprendiz</h1>
          </div>

          <!-- Content Row -->
          <div class="row">

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-6 mb-4">
              <?php if ($_GET): ?>
                <?php
                  $id = $_GET['id'];
                  $student = showStudent($id, $conn);
                ?>
                <table class="table table-striped table-bordered table-hover">
                  <?php foreach ($student as $st): ?>
                    <input type="hidden" name="id" value="<?php echo $st['id'] ?>">
                  <tr>
                    <td colspan="2" class="text-center">
                      <img class="rounded-circle img-thumbnail" src="<?php echo $url.$st['photo'] ?>"  style="width: 14rem; height: 14rem;" width="240px">
                    </td>
                  </tr>
                  <tr>
                      <th>Nombre Completo</th>
                      <td><?php echo $st['names'] ?></td>
                  </tr>
                  <tr>
                    <th>Correo Electronico</th>
                      <td><?php echo $st['email'] ?></td>
                  </tr>
                  <tr>
                    <th>Nacimiento</th>
                      <td><?php echo $st['birthdate'] ?></td>
                  </tr>
                  <tr>
                    <th>Estado</th>
                    <td>
                      <?php if($st['status'] == "Active"): ?>
                        <span class="badge badge-success">
                          <i class="fa fa-check"></i> Activo
                        </span>
                      <?php else: ?>
                        <span class="badge badge-danger">
                          <i class="fa fa-times"></i> Inactivo
                        </span>
                      <?php endif ?>
                    </td>
                  </tr>
                <?php endforeach ?>
                </table>
              <?php endif ?>
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