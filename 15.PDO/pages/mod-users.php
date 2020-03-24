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
            <h1 class="fa fa-users"> Módulo Aprendices</h1>
          </div>

          <!-- Content Row -->
          <div class="row">

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-12 mb-4">
              <a class="btn btn-success" href="students/add.php">
                <i class="fa fa-plus"></i>
                Adicionar Estudiantes
              </a>
              <hr>
              <?php $students = listStudents($conn); ?>
              <table id="dataTable" class="table table-bordered table-hover table-striped">
                <thead>
                  <tr>
                    <th>Nombre Completo</th>
                    <th>Correo Electrónico</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>Nombre Completo</th>
                    <th>Correo Electrónico</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                  </tr>
                </tfoot>
                <tbody>
                  <?php foreach ($students as $student): ?>
                    <tr>
                      <td><?php echo $student['names']; ?></td>
                      <td><?php echo $student['email']; ?></td>
                      <td>
                         <?php if($student['status'] == "Active"): ?>
                        <span class="badge badge-success">
                          <i class="fa fa-check"></i> Activo
                        </span>
                      <?php else: ?>
                        <span class="badge badge-danger">
                          <i class="fa fa-times"></i> Inactivo
                        </span>
                      <?php endif ?>
                      </td>
                      <td>
                        <a class="btn btn-sm btn-light" href="students/show.php?id=<?php echo $student['id']; ?>">
                          <i class="fa fa-search"></i>
                        </a>
                        <a class="btn btn-sm btn-light" href="students/edit.php?id=<?php echo $student['id']; ?>">
                          <i class="fa fa-pen"></i>
                        </a>
                        <a class="btn btn-sm btn-danger btn-delete" href="javascript:;" data-id="<?php echo $student['id']; ?>" data-dir="students">
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