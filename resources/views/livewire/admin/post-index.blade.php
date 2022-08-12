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

                  @can('admin.publication.pause')
                    @if($post->state->id ==5 || $post->state->id ==6)
                      <td width="10px;">
                        <a class="btn btn-primary btn-sm" wire:click="pausar({{$post->id}})">
                          <i class="far fa-pause-circle"></i>
                        </a>
                      </td>
                    @endif
                  @endcan

                  @can('admin.publication.destroy')
                    @if($post->state->id ==6 || $post->state->id ==7 )
                      <td width="10px;">
                        <a class="btn btn-danger btn-sm" wire:click="cancelar({{$post->id}})">
                          <i class="fas fa-ban"></i>
                        </a>
                      </td>
                    @endif
                  @endcan

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
                          {{-- <form action="{{route('admin.posts.destroy',$post)}}" method="POST">
                            @csrf
                            @method('delete')
                            <button class="btn btn-danger btn-sm" type="submit">
                              <i class="fas fa-trash-alt"></i>
                            </button>
                          </form> --}}
                          <a wire:click="confirmDestroy({{$post}})" class="btn btn-primary btn-sm" href="#">
                            <i class="fas fa-trash-alt"></i>
                          </a>
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
@push('css')
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.4.26/sweetalert2.min.css">
@endpush

@push('js')
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.4.26/sweetalert2.all.min.js"></script>
  <script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function () {
      @this.on('triggerDelete', postID => {
        Swal.fire({
          title: '¿Esta seguro?',
          text: 'Post borrador sera eliminado!',
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#aaa',
          confirmButtonText: 'Borrar!'
        }).then((result) => {
          //if user clicks on delete
          if (result.value) {
            // calling destroy method to delete
            @this.call('destroy',postID)
            // success response
            Swal.fire({title: 'Post borrado satisfactoriamente!', icon: 'success'});
          } else {
              Swal.fire({
                title: 'Operacion Cancelada!',
                icon: 'success'
              });
            }
        });
      });
    })
  </script>
@endpush