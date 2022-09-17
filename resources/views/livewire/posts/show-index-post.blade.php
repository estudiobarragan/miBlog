<div>
  <div class="mt-14 text-center">
    <h1 class="md:uppercase md:text-3xl sm:text-xs font-bold inline-flex">
      {{$type}}
      @php($ms = rand())
      @if($type=="Autor")
        : {{ $this->value->name}} 
        @auth()
          @livewire('follow-model',['user' => $this->value],key('autor-'.$ms) )
        @endauth()
      @endif
      @if($type=="Categoria")
        : {{ $this->value->name}}
        @auth()
          @livewire('follow-model',['categoria' => $this->value],key('categoria-'.$ms))
        @endauth()
      @endif
      @if($type=="Etiqueta")
        : {{ $this->value->name}}
        @auth()
          @livewire('follow-model',['tag' => $this->value],key('tag-'.$ms))
        @endauth()
      @endif
    </h1>
  </div>

  <div class="mb-2 mt-2">
    {{$posts->links()}}
  </div>

  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse ($posts as $post)
      @livewire('posts.show-card-post',['post'=>$post,'indice'=> $loop->index], key('post-'.$ms) )
    @empty
      <div class="text-gray-700 text-center mt-4 ml-4">
        <p>No hay posts para ver.</p>
      </div>
    @endforelse
  </div>

</div>