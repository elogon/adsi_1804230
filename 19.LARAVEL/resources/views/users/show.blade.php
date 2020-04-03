<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Consulta Usuario</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-md-8 offset-2">
				<hr>
				<a href="{{ url('users') }}" class="btn btn-success"> 
					<i class="fa fa-arrow-left"></i>
					Ir a Lista de Usuarios
				</a>
				<hr>
				<table class="table table-striped">
					<tr>
						<td colspan="2" class="text-center">
							<img src="{{ asset($user->photo) }}" class="img-thumbnail" width="120px">
						</td>
					</tr>
					<tr>
						<th>Nombre Completo:</th>
						<td>{{ $user->fullname }}</td>
					</tr>
					<tr>
						<th>Correo Electrónico:</th>
						<td>{{ $user->email }}</td>
					</tr>
					<tr>
						<th>Teléfono:</th>
						<td>{{ $user->phone }}</td>
					</tr>
					<tr>
						<th>Fecha de Nacimiento:</th>
						<td>
	                        {{ $user->birthdate }}
	                        &nbsp; | &nbsp;
	                        @php use \Carbon\Carbon; @endphp
	                        {{ Carbon::createFromDate($user->birthdate)->diff(Carbon::now())->format('%y años, %m meses y %d días') }}
                    	</td>
					</tr>
					<tr>
						<th>Genero:</th>
						<td>
	                        @if ($user->gender == "Female")
	                            Mujer
	                        @else
	                            Hombre    
	                        @endif
	                    </td>
					</tr>
					<tr>
						<th>Dirección:</th>
						<td>{{ $user->address }}</td>
					</tr>
					<tr>
						<th>Estado:</th>
						<td>
							@if ($user->status == "1")
	                            <span class="btn btn-success">Activo</span>
	                        @else
	                            <span class="btn btn-danger">Inactivo</span>    
	                        @endif
						</td>
					</tr>
				</table>
			</div>
		</div>
	</div>
</body>
</html>