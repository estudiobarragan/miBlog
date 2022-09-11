<div>
  <div class="ml-{{$sangria}} mt-2">
    <div class="flex align-middle mb-2">
      @if($sangria>0)
        <div class="border-l-2 border-gray-200 pr-1"></div>
      @endif
      <img class="w-10 h-10 rounded-full" src="{{Storage::url($comment->user->image->url)}}">
      <span class="w-16 ml-1 text-sm text-blue-600 mt-2">{{$comment->user->name}}:</span>

      @if($comment->replies->count()!=0)
        <p wire:click="toogle" class="text-sm mt-2 ml-1 w-3/4 cursor-pointer">{{$comment->mensaje}}</p>
      @else
        <p class="text-sm mt-2 ml-1 w-3/4 ">{{$comment->mensaje}}</p>
      @endif
      
      {{-- Mostrar like para comentarios --}}
      <div class="sm:absolute sm:left-1/2 md:pl-40 lg:pl-32 pl-2 flex">
        @auth()
          <div class="text-sm text-pink-100 cursor-pointer w-6 pt-1">
            {{-- @if(auth()->user()->id != $comment->user->id) --}}
            @livewire('reaction-comment',['comment'=>$comment],key('reac'.random_int(100,999).$comment->id))
          </div>
          {{-- boton de comentar --}}
          <i  wire:click="toogleModal" class="fas fa-comment pl-1 text-green-400 pt-3 cursor-pointer"></i>
          @if(auth()->user()->id == $comment->user->id)
            <div wire:click="$set('confirmingDeletion',true)" class="text-red-400 pt-2 cursor-pointer">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
            </div>
          @endif
        @else
          {{-- Mostrar cantidad de likes --}}
          <div class="text-sm text-pink-100 cursor-pointer w-6">
            @livewire('reaction-comment',['comment'=>$comment],key('reac'.random_int(100,999).$comment->id))
          </div>
        @endauth
        
      </div>
    </div>
    {{-- modal input --}}
    @if($verModal=='visible')
      @livewire('comments.modal-input-comment', ['comentario_id' => $comment->id , 'post_id' => 0], key('inp'.random_int(100,999).$comment->id))
    @endif  
    @if($confirmingDeletion)
      <div>
        <div wire:click="$set('confirmingDeletion',false)" class="text-center text-white bg-red-500 rounded shadow-2xl cursor-pointer">
          ¿seguro borra su comentario?
        </div>
        <div class="grid grid-cols-2 text-center cursor-pointer" @click.outside="$set('confirmingDeletion',false)">
          <p wire:click="delete" class="text-white bg-red-500 cursor-pointer rounded border border-white">Si</p>
          <p wire:click="$set('confirmingDeletion',false)" class="text-white bg-red-500 cursor-pointer rounded border border-white">No</p>
        </div>
      </div>
    @endif

    {{-- si tiene replicas --}}
    @if($comment->replies->count()!=0)
      <p wire:click="showReplies(true)" class="{{$ver}} cursor-pointer text-sm font-bold ml-14  -mt-3 mb-1">
        <i class="fas fa-ellipsis-h text-red-400 font-bold"></i>
      </p>
      @if($verRep=='visible')
        <div class="{{$verRep}}">
          @foreach($comment->replies as $reply)
            @livewire('comments.show-comment', ['comment' => $reply,'masSangria'=>4,'openAll'=>$openAll], key('rere'.random_int(100,999).$reply->id))
          @endforeach
        </div>
      @endif
    @endif
  </div>
</div>