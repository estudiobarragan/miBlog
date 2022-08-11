<x-app-layout>
  <div class="container py-8">
    <div class="inline-flex">
      <div>
        <h1 class="text-4xl font-bold text-gray-600">{{$post->name}}</h1>
      </div>
      <div class="">
        @auth()
          @if($post->user->id != Auth::user()->id)
            @livewire('bookmark-card-post', ['post'=> $post])
          @endif
        @endauth()
      </div>
    </div>

    <div class="text-lg text-gray-500 mb-2">
      {!!$post->extract!!}
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
      {{-- Contenido principal --}}
      <div class="lg:col-span-2">
        <figure class="relative">
          @if($post->image)
            <img class="w-full h-80 object-cover object-center" src="{{Storage::url($post->image->url)}}" alt="">
          @else
            <img class="w-full h-80 object-cover object-center" src="{{asset('/img-default/post-default.webp')}}" alt="">
          @endif
          <div class="absolute left-0 top-0 text-gray-100 bg-red-500 rounded-full px-3 py-1 text-sm">
            <a href="#"><strong>{{ $post->categoria->name }}</strong></a>
          </div>
          <div class="absolute left-0 bottom-0 ">
            @foreach($post->tags as $tag)
              <a class="inline-block bg-{{$tag->color}}-700 rounded-full px-3 py-1 text-sm text-{{$tag->color}}-100 mr-2" 
                  href="#">
                {{'#'.$tag->name}}
              </a>
            @endforeach
          </div>
        </figure>

        <div class="mt-2 flex place-content-between">
          <div class="text-gray-700 items-center text-sm">
            <strong>Publicado el: {{ Illuminate\Support\Carbon::parse($post->publicar)->format('j F, Y')}}</strong>
          </div>

          <div class="items-center grid lg:grid-cols-2 sm:grid-cols-1">
            @auth()
              <div class="inline-flex lg:ml-20 space-x-1">
                @livewire('reaction-post',['type'=>'thumbup', 'post'=>$post, 'group'=>'+'])            
                @livewire('reaction-post',['type'=>'heart', 'post'=>$post, 'group'=>'+'])            
                @livewire('reaction-post',['type'=>'star', 'post'=>$post, 'group'=>'+']) 
              </div>
              <div class="inline-flex space-x-1 ml-2">
                @livewire('reaction-post',['type'=>'thumbdown', 'post'=>$post, 'group'=>'-'])
                @livewire('reaction-post',['type'=>'brokenheart', 'post'=>$post, 'group'=>'-'])
                @livewire('reaction-post',['type'=>'unhappy', 'post'=>$post, 'group'=>'-'])
              </div>
            @endauth
          </div>

          <div class="text-gray-700 items-center text-sm">
            <a href="#"><strong>Autor: {{$post->user->name}}</strong></a>
          </div>
        </div>

        <div class="text-base text-gray-500 mt-4 text-justify">
          {!!$post->body!!}
        </div>
      </div>

      {{-- Contenido relacionado --}}
      <aside>
        <div class="card bg-gray-100 mb-2 shadow-lg border-2" x-data="{open:false}">
          <div class="card-body flow-root">
            <div class="float-left">
              @if($post->user->profile_photo_path)
                <img class="w-36 h-36 object-cover object-center rounded-full" src="{{Storage::url($post->user->profile_photo_path)}}" alt="">
              @else
                <img class="w-36 h-36 object-cover object-center rounded-full" src="{{asset('/img-default/perfil-default.png')}}" alt="">
              @endif
            </div>
            <div class="float-center mt-2">
              <h1 class="text-xl font-bold text-gray-600 text-center cursor-pointer">
                <a @click="open = !open">{{$post->user->name}}</a>
              </h1>
              <h1 class="text-sm font-bold text-blue-300 text-center cursor-pointer">
                <a @click="open = !open">{{$post->user->email}}</a>
              </h1>
              <h1 class="text-sm font-bold text-blue-300 mb-4 text-center cursor-pointer">
                <a @click="open = !open">{{$role}}</a>
              </h1>
              @auth()
                <div class="text-center">
                  @if($post->user->id != Auth::user()->id)
                    @livewire('follow-model',['user' => $post->user])
                  @endif
                </div>
              @endauth()
            </div>
          </div>

          <div class="card-footer">
            @if(isset($post->user->profile))
              <div x-cloak x-show="open" @click.away="open = false">
                @livewire('show-profile',['author'=>$post->user] )
              </div>
            @endif
          </div>
        </div>
        <h1 class="text-2xl font-bold text-gray-600 my-6 text-center">
          Mas en {{$post->categoria->name}}
        </h1>

        <ul>
          @foreach ($similares as $similar)
            <li class="mb-4">
              <a class="flex" href="{{route('posts.show',$similar)}}">
                @if($similar->image)
                  <img class="w-36 h-20 object-cover object-center flex-none" src="{{Storage::url($similar->image->url)}}" alt="$similar->name">
                @else
                  <img class="w-full h-80 object-cover object-center" src="{{asset('/img-default/post-default.webp')}}" alt="">
                @endif
                <span class="ml-2 text-gray-600">{{$similar->name}}</span>
              </a>

            </li>
          @endforeach
        </ul>
      </aside>
    </div>

  </div>

</x-app-layout>