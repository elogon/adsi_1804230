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
            <h1 class="fa fa-book"> Módulo Materias</h1>
          </div>

          <!-- Content Row -->
          <div class="row">

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-12 mb-4">
              <a class="btn btn-success" href="subjects/add.php">
                <i class="fa fa-plus"></i>
                Adicionar Materias
              </a>
              <hr>
              <?php $subjects = listSubject($conn); ?>
              <table id="dataTable" class="table table-bordered table-hover table-striped">
                <thead>
                  <tr>
                    <th>ID </th>
                    <th>Nombre Materia</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>ID</th>
                    <th>Nombre Materia</th>
                  </tr>
                </tfoot>
                <tbody>
                  <?php foreach ($subjects as $subject): ?>
                    <tr>
                      <td><?php echo $subject['id']; ?></td>
                      <td><?php echo $subject['name']; ?></td>
                      <td>
                      
                        <a class="btn btn-sm btn-light" href="subjects/edit.php?id=<?php echo $subject['id']; ?>">
                          <i class="fa fa-pen"></i>
                        </a>
                        <a class="btn btn-sm btn-danger btn-delete" href="javascript:;" data-id="<?php echo $subject['id']; ?>" data-dir="subjects">
                          <i class="fa fa-trash"></i>
                        </a>
                      </td>
                    </tr>
                  <?php endforeach ?>
                </tbody>
              </table>
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