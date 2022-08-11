<div class="mb-8 bg-white shadow-lg rounded-lg overflow-hidden md:{{$colspan}}">
  <div class="relative">
    @if($post->image)
      <img class="w-full h-72 object-cover object-center" src="{{Storage::url($post->image->url)}}" alt="">
      @else
      <img class="w-full h-72 object-cover object-center" src="{{asset('/img-default/post-default.webp')}}" alt="">    
    @endif

    <div class="absolute left-0 top-0 text-gray-100 bg-red-500 rounded-full px-3 py-1 text-sm hover:bg-gray-500">
      {{-- <a href="{{ route('posts.categoria',$post->categoria) }}"> --}}
      <a wire:click="categoria({{$post->categoria}})" class="cursor-pointer">
        <strong>{{$fabCategory.$post->categoria->name }}</strong>
      </a>
    </div>
  </div>

  <div class="px-6 py-4">
    <h1 class="font-bold text-xl mb-2 hover:bg-gray-100">
      <a href="{{route('posts.show',$post)}}">{{$post->name}}</a>
    </h1>

    <div class="text-gray-700 text-base">
      {!!$post->extract!!}
    </div>

    <div class="flex place-content-between mt-2 ">
      <div class="text-gray-700 text-base float-left">
        {{-- <strong>{{$post->updated_at->format('j F, Y')}}</strong> --}}
        <strong>{{ Illuminate\Support\Carbon::parse($post->publicar)->format('j F, Y')}}</strong>
      </div>
      @auth()
        <div class="flex content-between">
          @livewire('show-reaction-post',['post'=>$post])
        </div>
      @endauth
      <div class="text-gray-700 text-base float-right  hover:bg-gray-100">
        <a wire:click="autor({{$post->user}})" class="cursor-pointer">
          <strong>{{$fabAuthor.$post->user->name}}</strong>
        </a>
      </div>
    </div>
    
  </div>
  <hr>
  
  <div class="px-6 pt-4 pb-2">
    @foreach($post->tags as $tag)
      <a class="inline-block bg-{{$tag->color}}-700 rounded-full px-3 py-1 text-sm text-{{$tag->color}}-100 mr-2 shadow-xl hover:bg-gray-500 cursor-pointer" 
          wire:click="etiqueta({{$tag}})">{{$fabTag[$loop->index].$tag->name}}
      </a>
    @endforeach
    
    <div class="float-right flex">
      <div>
        @livewire('show-like-post', ['post'=> $post])
      </div>
      @auth()
        @if($post->user->id != Auth::user()->id)
          <div class="inline-flex">
            @livewire('bookmark-card-post', ['post'=> $post])
          </div>
        @endif
      @endauth()
    </div>
      
  </div>
</div>
