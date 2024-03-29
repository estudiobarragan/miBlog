<div>
  @if(session('success'))  
    <div class="alert alert-success">
      <strong>{{ session('success') }}</strong>
    </div>        
  @endif

  <div class="card">

    <div class="card-header">
      <input wire:model="search" class="form-control" placeholder="Ingres nombre o correo de un usuario">
    </div>
    @if($users->count())
      <div class="card-body">

        <table class="table table-striped">
          <thead>
            <tr>
              <th wire:click="order_id" role="button">ID</th>
              <th>Nombre</th>
              <th>Email</th>
              <th>Tarea</th>
              <th></th>
            </tr>
          </thead>

          <tbody>
            @foreach ($users as $user)
                <tr>
                  <td>{{$user->id}}</td>
                  <td>{{$user->name}}</td>
                  <td>{{$user->email}}</td>

                  <td>
                    @foreach($user->roles as $rol)
                      {{$rol->name}}
                    @endforeach
                  </td>
                  <td width="10px;">
                    @can('admin.users.edit')
                      <a class="btn btn-primary" href="{{route('admin.users.edit',$user)}}">
                        Editar
                      </a>
                    @endcan
                  </td>
                </tr>
            @endforeach
          </tbody>
        </table>

      </div>

      <div class="card-footer">
        {{$users->links()}}
      </div>        
    @else
      <div class="card">
        <div class="card-body">
          <strong>No hay registros</strong>
        </div>
      </div>
    @endif
  </div>
</div>
