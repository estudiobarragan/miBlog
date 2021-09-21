<x-app-layout>
  <div class="container py-8">
    <h1 class="text-4xl font-bold text-gray-600">{{$post->name}}</h1>

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
            <a href="{{ route('posts.categoria',$post->categoria) }}"><strong>{{ $post->categoria->name }}</strong></a>
          </div>
          <div class="absolute left-0 bottom-0 ">
            @foreach($post->tags as $tag)
              <a class="inline-block bg-{{$tag->color}}-700 rounded-full px-3 py-1 text-sm text-{{$tag->color}}-100 mr-2" 
                  href="{{route('posts.tag',$tag)}}">
                {{'#'.$tag->name}}
              </a>
            @endforeach
          </div>
        </figure>

        <div class="flow-root">
          <div class="mt-2 text-gray-700 float-left">
            <strong>Publicado el: {{$post->updated_at->format('j F, Y')}}</strong>
          </div>
          <div class="mt-2 text-gray-700 float-right">
            <a href="{{ route('posts.user',$post->user) }}"><strong>Autor: {{$post->user->name}}</strong></a>            
          </div>
        </div>

        <div class="text-base text-gray-500 mt-4 text-justify">
          {!!$post->body!!}
        </div>
      </div>

      {{-- Contenido relacionado --}}
      <aside>
        <div class="card bg-gray-100 mb-2 shadow-lg border-2">
          <div class="card-body flow-root">
            <div class="float-left">
              @if($post->user->profile_photo_path)
                <img class="w-36 h-36 object-cover object-center rounded-full" src="{{Storage::url($post->user->profile_photo_path)}}" alt="">
              @else
                <img class="w-36 h-36 object-cover object-center rounded-full" src="{{asset('/img-default/perfil-default.png')}}" alt="">
              @endif
            </div>
            <div class="float-center mt-2">
              <h1 class="text-2xl font-bold text-gray-600 text-center">
                {{$post->user->name}}
              </h1>
              <h1 class="text-1xl font-bold text-blue-300 mb-4 text-center">
                {{$post->user->email}}
              </h1>
              
              <a href="#" class="ml-20 bg-blue-200 hover:bg-blue-500 hover:text-white text-blu-500 text-center py-2 px-4 rounded">Seguir</a>

            </div>
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