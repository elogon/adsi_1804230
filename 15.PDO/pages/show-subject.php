<!-- Page Wrapper -->
  <div id="wrapper">

   <?php include 'menu-teacher.php'; ?>

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <?php include 'navbar-teacher.php' ?>

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="fa fa-search"> Consultar Materia</h1>
          </div>

          <!-- Content Row -->
          <div class="row">

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-6 mb-4">
              <?php if ($_GET): ?>
                <?php
                  $names = $_GET['name'];
                  $subject = showSubject($name, $conn);
                ?>
                <table class="table table-striped table-bordered table-hover">
                  <?php foreach ($subjects as $sb): ?>
                    <input type="hidden" name="names" value="<?php echo $sb['names'] ?>">
                  
                  <tr>
                    <th>
                      <td><?php echo $sb['name'] ?></td>
                    </th>
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