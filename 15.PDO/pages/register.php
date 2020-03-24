<body class="bg-gradient-info">

  <div class="container">

    <div class="card o-hidden border-0 shadow-lg my-5">
      <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
          <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
          <div class="col-lg-7">
            <div class="p-5">
              <div class="text-center">
                <h1 class="h4 text-gray-900 mb-4">
                <i class="fa fa-user"></i>
                Registro de Estudiantes
              </h1>
              </div>
              <form action="" class="user" method="post">
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="text" class="form-control form-control-user" name="names" placeholder="Nombre Completo" required>
                  </div>
                  <div class="col-sm-6">
                    <input type="date" class="form-control form-control-user" name="birthdate" placeholder="Fecha Nacimiento" required>
                  </div>
                </div>
                <div class="form-group">
                  <input type="email" class="form-control form-control-user" name="email" placeholder="Correo Electrónico" required>
                </div>
                <div class="form-group ">
                  <div class="mb-3 mb-sm-0">
                    <input type="password" class="form-control form-control-user" name="password" placeholder="Contraseña" required>
                  </div>
                  <hr>
                <button  class="btn btn-primary btn-user btn-block">
                  <i fa fa-save></i>
                  Registrar
                </button>
                <hr>
              </form>
              <div class="text-center">
              <a class="btn btn-link" href="index.php">
                <i class="fa fa-arrow-left"></i>
                Ingreso de Usuarios
              </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php
      if ($_POST) {
        $names     = $_POST['names'];
        $birthdate = $_POST['birthdate'];
        $email     = $_POST['email'];
        $password  = md5($_POST['password']);

        if(addStudent($names, $birthdate, $email, $password, $conn)){
          $_SESSION['message'] = "El Estudiante $names se Adiciono con Exito!";
        }
      } 
    ?>
  </div>