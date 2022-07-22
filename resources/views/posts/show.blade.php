<x-app-layout>
  <div class="container py-8">
    <div class="inline-flex">
      <div>
        <h1 class="text-4xl font-bold text-gray-600">{{$post->name}}</h1>
      </div>
      <div class="">
        @auth()
          @if($post->user->id != Auth::user()->id)
            @if(Maize\Markable\Models\Bookmark::has($post,Auth::user()))
              <a href="{{route('posts.noseguir',['post',$post->id])}}" class="float-right rounded-full bg-blue-400 w-7 h-7 text-center pt-1 hover:bg-blue-100 hover:text-gray-600">
                <i class="far fa-bookmark text-white"></i>
              </a>
            @else
              <a href="{{route('posts.seguir',['post',$post->id])}}" class="float-right rounded-full w-7 h-7 text-center pt-1 text-blue-600 font-extrabold hover:bg-blue-200">
                <i class="far fa-bookmark"></i>
              </a>
            @endif
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
              
              @auth()
                @if($post->user->id != Auth::user()->id)
                  @if(Maize\Markable\Models\Favorite::has($post->user,Auth::user()))
                    <a href="{{route('posts.noseguir',['user',$post->user])}}" class="ml-20 bg-red-200 hover:bg-red-500 hover:text-white text-red-800 text-sm py-1 px-2 rounded-3xl ">
                      <i class="fa fa-user-minus"></i>
                    </a>
                  @else
                    <a href="{{route('posts.seguir',['user',$post->user])}}" class="ml-20 bg-blue-200 hover:bg-blue-500 hover:text-white text-blue-800 text-sm py-1 px-2 rounded-3xl ">
                      <i class="fa fa-user-plus"></i>
                    </a>
                  @endif
                @endif
                
              @endauth()
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