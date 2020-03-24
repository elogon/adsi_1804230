 <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-danger sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item active">
        <a class="nav-link" href="<?php echo $url; ?>">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Escritorio</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Nav Item - Tables -->
      <li class="nav-item <?php if ($section == 'myprofile'): ?> active <?php endif ?>">
        <a class="nav-link" href="<?php echo $url; ?>myprofile.php">
          <i class="fas fa-fw fa-user"></i>
          <span>Mi perfil</span></a>
      </li>

      <li class="nav-item <?php if ($section == 'users'): ?> active <?php endif ?>">
        <a class="nav-link" href="<?php echo $url; ?>mod-users.php">
          <i class="fas fa-fw fa-users"></i>
          <span>Módulo Aprendices</span></a>
      </li>

       <li class="nav-item <?php if ($section == 'subjects'): ?> active <?php endif ?>">
        <a class="nav-link" href="<?php echo $url; ?>mod-subjects.php">
          <i class="fas fa-fw fa-book"></i>
          <span>Módulo Materias</span></a>
      </li>

       <li class="nav-item <?php if ($section == 'notes'): ?> active <?php endif ?>">
        <a class="nav-link" href="<?php echo $url; ?>mod-notes.php">
          <i class="fas fa-fw fa-list"></i>
          <span>Módulo Calificaciones</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>
    <!-- End of Sidebar -->