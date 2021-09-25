<div class="card">
  <div class="card-header">    
    <input wire:model="search" class="form-control" placeholder="Ingres el nombre de post a buscar">
  </div>

  @if($posts->count())
    <div class="card-body">
      <table class="table table-striped">
        
        <thead>
          <tr>
            <th wire:click="order_id" role="button">ID</th>
            <th>Titulo</th>
            <th>Autor</th>
            <th>Publicador</th>
            <th>Estado</th>
            <th class="text-center">Acciones</th>
          </tr>
        </thead>

        <tbody>
          @foreach ($posts as $post)
              <tr>
                <td>{{$post->id}}</td>
                <td>{{$post->name}}</td>
                <td>{{$post->user->name}}</td>
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



                 {{--  @can('admin.approves.show') --}}
                    @if($post->publicador_id == null && $post->user_id != auth()->user()->id)
                      <td class="text-center" width="10px;">
                        <a href="{{ route( 'admin.approves.show', $post ) }}">
                          <i class="far fa-thumbs-up"></i>
                        </a>                          
                      </td>
                    @endif
                  {{-- @endcan --}}


                  {{-- @can('publicador',$post) --}}
                    {{-- @can('admin.approves.edit') --}}
 
                        <td class="text-center" width="10px;">
                          <a href="{{ route( 'admin.approves.edit', $post ) }}">
                            <i class="fas fa-user-edit"></i>
                          </a>                          
                        </td>

                    {{-- @endcan --}}
                  {{-- @endcan --}}

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


