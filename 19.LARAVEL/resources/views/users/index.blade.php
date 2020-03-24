<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Lista de Usuarios</title>
</head>
<body>
	<h1>Lista de Usuarios</h1>
	<hr>
	<a href="{{ url('users/create') }}">Adicionar Usuario</a>
	<hr>
	@if (session('message'))
		{{ session('message') }}
	@endif
<table>
		<thead>
			<tr>
				<th>Nombre Completo</th>
				<th>Correo Electrónico</th>
				<th>Teléfono</th>
				<th>Contraseña</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($users as $user)
				<tr>
					<td>{{ $user->fullname }}</td>
					<td>{{ $user->email }}</td>
					<td>{{ $user->phone }}</td>
					<td>{{ $user->password ]}</td>
				</tr>
			@endforeach
		</tbody>
	</table>
</body>
</html>