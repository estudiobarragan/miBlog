<div>
  {{-- Comentarios --}}
  
  <div class="flex justify-between">
    @auth
      <button wire:click="toogle">
        Comentar el post:<i class="fas fa-comment pl-1 text-green-400 pt-2 cursor-pointer"></i>
      </button>
    @endauth
    <div class="justify-right" >
      <a wire:click="$emit('abrirReply')" class="align-right cursor-pointer"><i class="fas fa-plus text-blue-400"></i></a>
      <a wire:click="$emit('cerrarReply')" class="align-right cursor-pointer"><i class="fas fa-minus text-blue-400"></i></a>
    </div>
  </div>

  @auth
    @if($verModal=='visible')
      @livewire('comments.modal-input-comment', ['comentario_id' => 0, 'post_id' => $post->id, 'key'=>'inp'.random_int(100,999).$post->id])
    @endif
  @endauth

  <div class="bg-white shadow-lg rounded-lg overflow-hidden">
    @foreach($post->comments as $comment)
      @livewire('comments.show-comment',['comment'=> $comment,'masSangria'=> 0 ,'key'=>'post'.random_int(100,999).$comment->id])
      <hr>
    @endforeach
  </div>
</div>
