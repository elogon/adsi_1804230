 <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-info sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item <?php if ($section == 'dashboard'): ?> active <?php endif ?>">
        <a class="nav-link" href="index.php">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Escritorio</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Nav Item - Tables -->
      <li class="nav-item <?php if ($section == 'myprofile'): ?> active <?php endif ?>">
        <a class="nav-link" href="<?php echo $url; ?>mystprofile.php">
          <i class="fas fa-fw fa-user"></i>
          <span>Mi perfil</span></a>
      </li>

       <li class="nav-item <?php if ($section == 'mynotes'): ?> active <?php endif ?>">
        <a class="nav-link" href="<?php echo $url; ?>mynotes.php">
          <i class="fas fa-fw fa-list"></i>
          <span>Mis Calificaciones</span></a>
      </li>
      

      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>
    <!-- End of Sidebar -->