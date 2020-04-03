</div>
    <form action="/users/{{$user->id}}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="_method" value="DELETE">
    <input type="submit" value="Eliminar registro">
    <div class="form-group" class="btn btn-danger">
    </div>