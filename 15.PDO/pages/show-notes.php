<!-- Page Wrapper -->
  <div id="wrapper">

    <?php include 'menu-teacher.php'; ?>
  

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>

          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">

            
            <div class="topbar-divider d-none d-sm-block"></div>

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php if(isset($_SESSION['unames'])) echo $_SESSION['unames'];?></span>
                <img class="img-profile rounded-circle" src="../<?php if(isset($_SESSION['uphoto'])) echo $_SESSION['uphoto']; ?>">
              </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="#">
                  <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                  Mi Perfil
                </a>
                <a class="dropdown-item" href="#">
                  <i class="fas fa-users fa-sm fa-fw mr-2 text-gray-400"></i>
                  Modulo Aprendices
                </a>
                 <a class="dropdown-item" href="#">
                  <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                  Modulo Calificaciones
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="close.php" >
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Cerrar Sesión
                </a>
              </div>
            </li>

          </ul>

        </nav>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-start mb-4">
            <h1 class=" h3 mb-0 text-gray-800"><i class="fa fa-search">Consultar Materia</i></h1>
          </div>
          <!-- Content Row -->
          <div class="row">
  
            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-6 mb-4 ">
              <?php if($_GET): ?>
              <?php 
                $id = $_GET['id'];
                $note = showNotes($id, $conn);
               ?>
              <table class="table table-striped table-bordered table-hover">
                <?php foreach ($note as $nt): ?>
                  
                <tr>
                  <td colspan="2" class="text-center">
                   <img class="rounded-circle img-thumbnail" src="<?php echo $url.$nt['photo']; ?>" style="width: 14rem; height: 14rem;">
                  </td>
                </tr>
                <tr>
                  <th>Nombre Completo</th>
                  <td><?php echo $nt['uname'] ?></td>
                </tr>
                <tr>
                  <th>Materia</th>
                  <td><?php echo $nt['sname'] ?></td>
                </tr>
                <tr>
                  <th>Nota 1</th>
                  <td><?php echo $nt['nt1'] ?></td>
                </tr>
                <tr>
                  <tr>
                  <th>Nota 2</th>
                  <td><?php echo $nt['nt2'] ?></td>
                </tr>
                <tr><tr>
                  <th>Nota 3</th>
                  <td><?php echo $nt['nt3'] ?></td>
                </tr>
                <tr>
                <th>Nota Final</th>
                  <td>
                  <?php if (round($nt['fnote'], 1) >=3.5): ?>
                    <span class="badge badge-success">
                       <?php echo round($nt['fnote'], 1); ?>
                    </span>
                  <?php else: ?>
                    <span class="badge badge-danger">
                       <?php echo round($nt['fnote'], 1); ?>
                    </span>
                  <?php endif ?>
                </td>
                </tr>
                <tr>
                <?php endforeach ?>
              </table>
            <?php endif ?>
            </div>
          </div>
        </div>
      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Todos los Derechos Reservados &copy;<?php echo date('Y')?></span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>