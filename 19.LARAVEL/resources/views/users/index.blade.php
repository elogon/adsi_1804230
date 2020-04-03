<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Lista de Usuarios</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-md-10 offset-1">
				<h1>Lista de Usuarios</h1>
		<hr>
		<a href="{{ url('users/create') }}" class="btn btn-success">
					<i class="fa fa-plus"></i> 
					Adicionar Usuario
				</a>
				<br><br>
		<hr>
		@if (session('message'))
			{{ session('message') }}
		@endif
		<table class="table table-striped">
				<thead>
					<tr>
						<th>Nombre Completo</th>
						<th>Correo Electrónico</th>
						<th>Teléfono</th>
						<th>Acciones</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($users as $user)
						<tr>
							<td>{{ $user->fullname }}</td>
							<td>{{ $user->email }}</td>
							<td>{{ $user->phone }}</td>
							<td>
									<a href="{{ url('users/'.$user->id) }}" class="btn btn-sm btn-primary">
										<i class="fa fa-search"></i>
									</a>
									<a href="{{ url('users/'.$user->id.'/edit/') }}" class="btn btn-sm btn-primary">
										<i class="fa fa-pencil"></i>
									</a>
									<form action="/users/{{$user->id}}" method="POST" style="display: inline-block;">
										@csrf
										@method('delete')
										<input type="hidden" name="_method" value="DELETE">
										<button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Estas seguro quires eliminar el usuario')">
											<i class=" fa fa-trash"></i>
										</button>
									</form>
				
								</td>
						</tr>
					@endforeach
				</tbody>
					</div>
				</div>
			</div>

		</table>
	
</body>
</html>