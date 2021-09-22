<div class="card">
  @if(session('success'))
    
    <div class="alert alert-success">
      <strong>{{ session('success') }}</strong>
    </div>
    
   @endif
   <div class="card-header">    
    <input wire:model="search" class="form-control" placeholder="Ingres el nombre de post a buscar">
  </div>

  
    <div class="card-body">
      <table class="table table-striped">
        
        <thead>
          <tr>
            <th wire:click="order_id" role="button">ID</th>
            <th>Titulo</th>
            <th>Autor</th>
            <th>Editor</th>
            <th>Publicador</th>
            <th width="80px;">
              
              <div class="dropdown">
                <button class="btn btn-light dropdown-toggle" type="button" data-toggle="dropdown">
                  <strong>Estados</strong>
                  <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                  <li><a wire:click="stateFilter(0)" class="text-dark" href="#">Todos</a></li> 
                  @foreach ($estados as $estado)
                    <li><a wire:click="stateFilter({{$estado->id}})" class="text-dark" href="#">{{$estado->name}}</a></li>                      
                  @endforeach
                  
                </ul>
              </div>

            </th>
            <th>Acciones</th>
          </tr>
        </thead>
        @if($posts->count())
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
        @else
        </table>
          <div class="card-body">
            <strong>No hay ningun registro</strong>
          </div>
        @endif
    </div>

    @if($posts->count())
      <div class="card-footer">
        {{$posts->links()}}
      </div>
    @endif

</div>
@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
@stop