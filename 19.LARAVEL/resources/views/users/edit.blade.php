<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Editar</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
  <div class="container">
          <!-- Page Heading -->
          <div class="col-md-8 offset-2">
            <h1> <i class="fa fa-plus"></i> 
            &nbsp;Editar Usuario</h1>
          
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item ">
            <a href="{{ url('users') }}">
              <i class="fa fa-home"></i>
              Lista Usuarios
            </a>
          </li>
          <li class="breadcrumb-item ">
            <i class="fa fa-plus"></i>
              Editar Usuario
          </li>
        </ol>
      </nav>
          <!-- Content Row -->
          <div class="row">

            <div class="col-xl-6 mb-4">
              <form action="/users/{{$user->id}}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="_method" value="PUT">
                <div class="form-group">
                  <label for="fullname">Nombre Completo:</label>
                  <input type="text" class="form-control" name="fullname" value="{{ $user-> fullname }}" required>
                </div>
                <!--  -->
                <div class="form-group">
                  <label for="email">Correo Electrónico:</label>
                  <input type="email" class="form-control" name="email" value="{{ $user->email}}" required>
                </div>
                <!--  -->
                <div class="form-group">
                  <label for="phone">Teléfono:</label>
                  <input type="phone" class="form-control" name="phone" value="{{ $user->phone}}" required>
                </div>
                <!--  -->
                <div class="form-group">
                  <label for="birthdate">Fecha de Nacimiento:</label>
                  <input type="date" class="form-control" name="birthdate" value="{{ $user->birthdate}}" required>
                </div>
                <!--  -->
                <div class="form-group">
                  <label for="gender">Género:</label>
                  <input type="gender" class="form-control" name="gender" value="{{$user->gender}}" required>
                </div>
                <!--  -->
                <div class="form-group">
                  <label for="address">Dirección:</label>
                  <input type="address" class="form-control" name="address" value="{{$user->address}}" required>
                </div>
                <!-- <div class="form-group">
                  <label for="photo">Foto:</label>
                  <input type="file" class="form-control-file" accept="image/*" name="photo">
                </div> -->
        <!--  -->
                <div class="form-group">
                  <button class="btn btn-success">
                    <i class="fa fa-save"></i>
                    Guardar
                  </button>
                  <button type="reset" class="btn btn-danger">
                    <i class="fa fa-eraser"></i>
                    Limpiar
                  </button>
                
              </form>
            </div>
          </div>
        </div>
        </div>
</body>
</html>