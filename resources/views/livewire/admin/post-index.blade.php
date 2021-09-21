<div class="card">
  @if(session('success'))
    
    <div class="alert alert-success">
      <strong>{{ session('success') }}</strong>
    </div>
    
   @endif
   <div class="card-header">    
    <input wire:model="search" class="form-control" placeholder="Ingres el nombre de post a buscar">
  </div>

  @if($posts->count())
    <div class="card-body">
      <table class="table table-striped">
        
        <thead>
          <tr>
            <th>ID</th>
            <th>Titulo</th>
            <th>Autor</th>
            <th>Editor</th>
            <th>Publicador</th>
            <th>Estado</th>
            <th colspan="2" class="text-center">Acciones</th>
          </tr>
        </thead>

        <tbody>
          @foreach ($posts as $post)
              <tr>
                <td>{{$post->id}}</td>
                <td>{{$post->name}}</td>
                <td>{{$post->user->name}}</td>
                <td>
                  @isset($post->editor)
                    {{$post->editor->name}}                    
                  @endisset
                </td>
                <td>
                  @isset($post->publicador)
                    {{$post->publicador->name}}                    
                  @endisset
                </td>
                <td width="20px;">
                  <div class="{{$post->state->color}} text-center px-2 rounded shadow">
                    {{$post->state->name}}
                  </div>
                </td>

                @can('admin.posts.edit')
                  @can('author',$post)
                    @if($post->state->id ==1)
                      <td width="10px;">
                        <a class="btn btn-primary btn-sm" href="{{route('admin.posts.edit',$post)}}">
                          <i class="fas fa-edit"></i>
                        </a>
                      </td>
                    @endif
                  @endcan
                @endcan

                @can('admin.posts.destroy')
                  @can('author',$post)
                    @if($post->state->id ==1)
                      <td width="10px;">
                        <form action="{{route('admin.posts.destroy',$post)}}" method="POST">
                          @csrf
                          @method('delete')
                          <button class="btn btn-danger btn-sm" type="submit">
                            <i class="fas fa-trash-alt"></i>
                          </button>
                        </form>
                      </td>
                    @endif
                  @endcan
                @endcan
              </tr>

          @endforeach
        </tbody>

      </table>
    </div>

    <div class="card-footer">
      {{$posts->links()}}
    </div>
  @else
    <div class="card-body">
      <strong>No hay ningun registro</strong>
    </div>
  @endif
</div>
