<x-app-layout>
  <div class="container py-8">
    <div class="grid grid-cols-3">
      <div class="col-span-2 text-right">
        <h1 class="uppercase text-right text-base md:text-3xl font-bold py-2">Ultimos post</h1>
      </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

        {{-- @foreach ($posts as $post)
          <article class="w-full h-80 bg-cover bg-center @if($loop->first) md:col-span-2 @endif" @if($post->image)
              style="background-image: url( {{Storage::url($post->image->url)}} );">
            @else
              style="background-image: url({{asset('/img-default/post-default.webp')}});">
            @endif
            <div class="w-full h-full px-8 flex flex-col justify-center">

              <div>
                @foreach ($post->tags as $tag)
                  <a href="{{route('posts.tag',$tag)}}" class="inline-block px-3 h-6 bg-{{$tag->color}}-600 text-white rounded-full">{{$tag->name}}</a>                
                @endforeach
              </div>


              <h1 class="text-4xl text-white leading-8 font-bold mt-2">
                <a href="{{ route( 'posts.show', $post ) }}">
                  {{$post->name}}
                </a>
              </h1>
            </div>
          </article>
        @endforeach --}}

        @foreach ($posts as $post)
          <article class="@if($loop->first) md:col-span-2 @endif">
            <x-card-post :post="$post"></x-card-post>
          </article>
        @endforeach
    </div>

    <div class="mt-4">
      {{$posts->links()}}
    </div>

  </div>
</x-app-layout>