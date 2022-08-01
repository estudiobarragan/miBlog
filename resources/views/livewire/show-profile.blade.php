<div  x-cloak>
  <div class="mt-2 text-gray-700 font-bold text-2xl">
    ¿Quien es {{$author->name}}?
  </div>

  <div class="mt-1 text-gray-500 text-sm">
    {!!$author->profile->biografia!!}  
  </div>

  <hr>
  <div class="text-center">
    <a target="_blank" class="mr-1" href="{{$this->author->profile->website}}"><i class="fas fa-blog"></i></a>
    <a target="_blank" class="mr-1" href="{{$this->author->profile->facebook}}"><i class="fab fa-facebook"></i></a>
    <a target="_blank" class="mr-1" href="{{$this->author->profile->instagram}}"><i class="fab fa-instagram"></i></a>
    <a target="_blank" class="mr-1" href="{{$this->author->profile->telegram}}"><i class="fab fa-telegram"></i></a>
    <a target="_blank" class="mr-1" href="{{$this->author->profile->twitter}}"><i class="fab fa-twitter-square"></i></a>
    <a target="_blank" class="mr-1" href="{{$this->author->profile->tiktok}}"><i class="fab fa-tiktok"></i></a>
  </div>
  <hr>

  <div class="text-gray-700 font-bold text-xl mb-1">Post publicados</div>
  @foreach($posts as $post)
    <a href="{{$url.$post->slug}}" class="text-gray-700 text-sm hover:bg-gray-200 hover:text-blue-300">* {{$post->name}}</a><br>
  @endforeach
</div>
