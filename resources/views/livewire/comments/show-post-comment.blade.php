<div>
  {{-- Comentarios --}}
  
  <div class="flex justify-between mr-3">
    @auth
      <button wire:click="toogle">
        Comentarios al post:<i class="fas fa-comment pl-1 text-green-400 pt-2 cursor-pointer" alt="boton_comentar"></i>
      </button>
    @else
      <p>Comentarios al post:</p>
    @endauth
    
    @if($post->comments->count()>0)
      <div class="justify-right" >
        <p wire:click.prevent="recargar" class="align-right cursor-pointer">
          <i class="fas fa-sync-alt text-blue-400" alt="boton_actualizar"></i>
        </p>
      </div>
    @endif
  </div>

  @auth
    @if($verModal=='visible')
      @livewire('comments.modal-input-comment', ['comentario_id' => 0, 'post_id' => $post->id], key('inp'.random_int(100,999).$post->id))
    @endif
  @endauth

  <div class="bg-white shadow-lg rounded-lg overflow-hidden">
    @foreach($post->comments as $comment)
      @livewire('comments.show-comment',['comment'=> $comment,'masSangria'=> 0], key('post'.random_int(100,999).$comment->id))
      <hr>
    @endforeach
  </div>
</div>
