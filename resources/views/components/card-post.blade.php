@props(['post'])

<article class="mb-8 bg-white shadow-lg rounded-lg overflow-hidden">
  <div class="relative">
    @if($post->image)
      <img class="w-full h-72 object-cover object-center" src="{{Storage::url($post->image->url)}}" alt="">
      @else
      <img class="w-full h-72 object-cover object-center" src="{{asset('/img-default/post-default.webp')}}" alt="">    
    @endif
    <div class="absolute left-0 top-0 text-gray-100 bg-red-500 rounded-full px-3 py-1 text-sm">
      <a href="{{ route('posts.categoria',$post->categoria) }}"><strong>{{ $post->categoria->name }}</strong></a>
    </div>
  </div>

  <div class="px-6 py-4">
    <h1 class="font-bold text-xl mb-2">
      <a href="{{route('posts.show',$post)}}">{{$post->name}}</a>
    </h1>

    <div class="text-gray-700 text-base">
      {!!$post->extract!!}
    </div>

    <div class="flow-root mt-2 ">
      <div class="text-gray-700 text-base float-left">
        <strong>{{$post->updated_at->format('j F, Y')}}</strong>
      </div>
      <div class="text-gray-700 text-base float-right">
        <a href="{{ route('posts.user',$post->user) }}"><strong>{{$post->user->name}}</strong></a>
      </div>
    </div>
    
  </div>
  <hr>
  <div class="px-6 pt-4 pb-2">
    @foreach($post->tags as $tag)
      <a class="inline-block bg-{{$tag->color}}-700 rounded-full px-3 py-1 text-sm text-{{$tag->color}}-100 mr-2 shadow-xl" 
          href="{{route('posts.tag',$tag)}}">
        {{'#'.$tag->name}}
      </a>
    @endforeach

    @auth()
      @if($post->user->id != Auth::user()->id)
        @if(Maize\Markable\Models\Bookmark::has($post,Auth::user()))
          <a href="{{route('posts.noseguir',['post',$post->id])}}" class="float-right rounded-full bg-blue-400 w-7 h-7 text-center pt-1">
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
</article>