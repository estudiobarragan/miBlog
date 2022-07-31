<div class="{{$vercomponente}}">
  <div class="conteiner">
    <div class="card">
      <div class="card-title row">
        <div class="col"></div>
        <div class="col">
          <h3 class="text-center">Notificaciones</h3>
        </div>
        <div class="col">
          {{-- <p class="text-right">x</p> --}}
          <h6 wire:click="$set('vercomponente', 'invisible')"  class="btn btn-success btn-sm text-right">x</h6>
        </div>
      </div>
      <div class="card-body">
         <table class="table table-striped table-hover fs-6">
          <thead>
            <th>Aviso</th>
            <th>Post</th></th>
            <th>Titulo</th>
            <th>Estado</th>
            <th>Evaluado</th>
            <th>Leida</th>
          </thead>
          <tbody>
            @foreach ($notifications as $notify)
              @php
                $post=App\Models\Post::findOrFail($notify->data['post']);
                $estado=$post->state->name;
                $id=$notify->id;
              @endphp
                
              <tr>
                @if($notify->data['name']=='Post rechazado')
                 <td>
                  <a class="btn btn-danger btn-sm" wire:click="motivos({{$notify->data['post']}})">
                    {{$notify->data['name']}}
                  </a>
                  </td>
                @else
                  <td class="fs-6">{{$notify->data['name']}}</td>
                @endif
                <td class="fs-6">{{$notify->data['post']}}</td>

                @can('admin.posts.edit')
                  @can('author',$post)
                    @if($post->state->id ==1)
                      <td>
                        <a class="btn btn-primary btn-sm" href="{{route('admin.posts.edit',$post)}}">
                          {{$notify->data['title']}}
                        </a>
                      </td>
                    @else
                      <td>{{$notify->data['title']}}</td>
                    @endif
                  @endcan
                @else
                  <td>{{$notify->data['title']}}</td>
                @endcan
                
                
                <td class="fs-6">{{$estado}}</td>
                <td class="fs-6">{{$notify->created_at}}</td>
                
                <td class="btn btn-primary btn-sm" wire:click="markread({{$notify}})">
                  leida? 
                </td>

              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <div class="card-footer">
        @if(isset($postReject))
          {{-- MODAL para ver motivos del rechazo  --}}
          <div class="{{$vermodal}}">
            <div class="d-flex justify-content-between">
              <div class="start-0">
                <h3>FUNDAMENTOS</h3>
              </div>
              <div class="end-0">
                <h6 wire:click="$set('vermodal', 'invisible')" class="btn btn-success btn-sm">x</h6>
              </div>
            </div>
            <div>
              <h5 class="text-3xl text-blue-600">Se ha rechazado su curso: </h5> 
              <a class="text-blue-800" href="">{{$postReject->name}}</a><br><br>

              <h5>El editor de su curso: <strong>{{$postReject->editor->name}}</strong> recientemente ha rechazado su curso.
                El feedback que realizo nuestro editor dice:<strong>{!! $approve->feedback !!}</strong>
              </h5>
              
              <hr>
              <h3>Observaciones adicionales</h3>
              <ul>        
                <li>Nivel: @if($approve->level==1) Inicial @elseif($approve->level==2) Intermedio @elseif($approve->level==3) Avanzado @endif </li>
                <li>Tiempo de lectura: {{$approve->timeToRead}} minutos</li>
                <li>¿Posee citas con enlace a fuentes externas?: @if($approve->linksSource == 1) Si @else No @endif </li>
                <li>¿El post es comprensible?: @if($approve->understandable == 1) Si @else No @endif </li>
                <li>¿El post posee un titulo acorde al contenido?: @if($approve->title == 1) Si @else No @endif </li>
                <li>¿El post posee una imagen acorde al contenido?: @if($approve->image == 1) Si @else No @endif </li>
                <li>¿El post posee un extracto o resumen y es acorde al contenido?: @if($approve->summary == 1) Si @else No @endif </li>
                <li>¿El post posee conclusiones y es acorde al contenido?: @if($approve->conclusion == 1) Si @else No @endif </li>
                <li>¿El post posee ejemplos y son apropiados y suficientes?: @if($approve->examples == 1) Si @else No @endif </li>
                <li>¿El post posee etiquetas acordes y suficientes?: @if($approve->tagRight == 1) Si @else No @endif </li>
                <li>¿El post fue categorizado en forma adecuada con el contenido?: @if($approve->categoryRight == 1) Si @else No @endif </li>    
              </ul>
              <h5>Cualquier duda, por favor comuniquese con el editor de este post para mas aclaraciones, a su correo: <strong>{{$postReject->editor->email}}</strong>. Muchas gracias por colaborar con este blog !</h5>
              <br>
              <h4>Atte: Jose Maria</h4>
              <h4>Administrador</h4>
            </div>
          </div>
        @endif
      </div>
    </div>

  </div>
</div>
