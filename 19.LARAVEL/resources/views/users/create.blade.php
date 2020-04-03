<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Crear Usuario</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
	<h1 class="text-center">Crear Usuarios</h1>
	<div class="row">
		<div class="col-md-6 offset-3">
			<hr>
			<a href="{{url('users')}}" class="btn btn-success">
			<i class="fa fa-arrow-left"></i>
			Ir a Lista de Usuario</a>
			<hr>
	<form action="{{url('users')}}" method="post">
		@csrf
		<div class="form-group">
              		<label for="fullname">Nombre Completo:</label>
              		<input type="text" class="form-control" name="fullname" value="{{old('fullname')}}" required>
              	</div>
              	<!--  -->
                <div class="form-group">
                  <label for="email">Correo Electrónico:</label>
                  <input type="email" class="form-control" name="email" value="{{old('email')}}"required>
                </div>
                <!--  -->
                <div class="form-group">
                  <label for="phone">Teléfono:</label>
                  <input type="phone" class="form-control" name="phone" value="{{old('phone')}}" required>
                </div>
                <!--  -->
              	<div class="form-group">
              		<label for="birthdate">Fecha de Nacimiento:</label>
              		<input type="date" class="form-control" name="birthdate" value="{{old('birthdate')}}" required>
              	</div>
              	<!--  -->
              	<div class="form-group">
                  <label for="gender">Género:</label>
                  <input type="gender" class="form-control" name="gender" value="{{old('gender')}}" required>
                </div>
              	<!--  -->
              	<div class="form-group">
              		<label for="address">Dirección:</label>
              		<input type="address" class="form-control" name="address" value="{{old('address')}}" required>
              	</div>
              	<div class="form-group">
              		<label for="password">Contraseña:</label>
              		<input type="password" class="form-control" name="password" value="{{old('password')}}" required>
              	</div>
              	<div class="form-group">
              		<label for="photo">Foto:</label>
              		<input type="file" class="form-control-file" accept="imgs/*" name="photo">
              	</div>
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
              	</div>
	</form>
		</div>
	</div>
	
</body>
</html>