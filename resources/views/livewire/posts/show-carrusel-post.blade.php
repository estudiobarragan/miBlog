<div>
  <div class="mt-14 text-center">
    <h1 class="md:uppercase md:text-3xl sm:text-xs font-bold inline-flex">
      {{$type}}
      @php($ms = rand())
      @if($type=="Autor")
        : {{ $this->value->name}} 
        @auth()
          @livewire('follow-model',['user' => $this->value,key('autor-'.$ms) ])
        @endauth()
      @endif
      @if($type=="Categoria")
        : {{ $this->value->name}}
        @auth()
          @livewire('follow-model',['categoria' => $this->value,key('categoria-'.$ms)])
        @endauth()
      @endif
      @if($type=="Etiqueta")
        : {{ $this->value->name}}
        @auth()
          @livewire('follow-model',['tag' => $this->value,key('tag-'.$ms)])
        @endauth()
      @endif
    </h1>
  </div>

  <div class="mb-2 mt-2">
    {{$posts->links()}}
  </div>

  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 md:gap-2 lg:gap-4 xl:gap-6">
    @foreach ($posts as $post)
    
      @livewire('posts.show-card-carrusel-post',['post'=>$post,'indice'=> 1, key('post-'.$ms) ])
     
    @endforeach
    <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a>
  </div>

</div>
