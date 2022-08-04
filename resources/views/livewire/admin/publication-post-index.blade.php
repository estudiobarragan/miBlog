<div class="card">
  <div class="card-header">    
    <input wire:model="search" class="form-control" placeholder="Ingres el nombre de post a buscar">
  </div>
  
  @if($posts->count())
    <div class="card-body">
      <table class="table table-striped">
        
        <thead>
          <tr>
            <th wire:click="order_id" role="button" class="text-sm">
              @if($order_id =="asc")
                Id<i class="fas fa-sort-up fa-xs"></i>
              @else
                Id<i class="fas fa-sort-down fa-xs"></i>
              @endif
            </th>
            <th>Titulo</th>
            <th>Autor</th>
            <th>Categoria</th>
            <th>Etiquetas</th>
            <th>Publicador</th>
            <th>Estado</th>
            <th class="text-center col-span-2" width="10px">Acciones</th>
          </tr>
        </thead>

        <tbody class="text-sm">
          @foreach ($posts as $post)
            <tr>
              <td>{{$post->id}}</td>
              <td>{{$post->name}}</td>
              <td>{{$post->user->name}}</td>
              <td>{{$post->categoria->name}}</td>
              <td>
                @foreach ($post->tags as $tag)
                  {{$tag->name}}
                  @if (!$loop->last)
                    |
                  @endif
                @endforeach
              </td>
              <td>
                @if($post->publicador !=null)
                  {{$post->publicador->name}}
                @endif
              </td>
              <td width="20px;">
                <div class="{{$post->state->color}} text-center px-2 rounded shadow">
                  @if($post->publicador_id == null)
                    {{$post->state->name}}
                  @else
                    {{$post->publicar}}
                  @endif
                </div>
              </td>

              @can('admin.publication.create')
                @if($post->publicador_id == null)
                  <td wire:click.prevent="edit({{$post}})" class="text-center" width="5px">
                    <a href="#">
                      <i class="fas fa-clock"></i>
                    </a>                          
                  </td>
                @endif
              @endcan


              @can('admin.publication.edit')
                @if($post->publicador_id != null)
                  <td wire:click.prevent="edit({{$post}})" class="text-center" width="5px">
                    <a href="#">
                      <i class="fas fa-stamp"></i>
                    </a>                          
                  </td>
                @endif
              @endcan

            </tr>

          @endforeach
        </tbody>

      </table>
    </div>

    <div class="card-footer">
      {{$posts->links()}}
    </div>

    {{-- Modal para editar fecha de publicacion --}}
    <div class="modal" @if($showModal) style="display:block"@endif>
      <div class="modal-dialog" role="document">
        <div class="modal-content">

          <div class="modal-header">
            <h5 class="modal-title">Fecha de publicacion</h5>
            <button wire:click="close" type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <div class="input-group date">
                <input wire:model="fechaPublicar" class="form-control hidden" id="datepicker">
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button wire:click="save" type="submit" class="btn btn-primary">Save changes</button>
            <button wire:click="close" type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>

        </div>
      </div>
    </div>
  @else
    <div class="card-body">
      <strong>No hay ningun registro</strong>
    </div>
  @endif

  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/pikaday/pikaday.js"></script>
  <script>
    var picker = new Pikaday({
        field: document.getElementById('datepicker'),
        onSelect: function() {
            @this.set('fechaPublicar',this.getMoment().format('DD-MMM-YYYY'));
        }
    });
  </script>
  
</div>


