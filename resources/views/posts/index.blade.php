<x-app-layout>
  <div class="container py-4">
    <div class="bg-gray-400 h-10 w-full mb-2 z-50 flex">
      <div x-data="{open:false}" class="flex">
        <div class="text-white ml-2">
          {{__('Categorias ')}}
          <i class="fas fa-caret-down cursor-pointer" x-on:click="open=!open" @click.outside="open = false"></i>
        </div>
        <div x-show="open" class="bg-blue-100 shadow-lg rounded-b-lg text-sm overscroll-auto w-32 ml-4 pl-2 h-screen">
          @foreach ($categorias as $categoria)
            <li>
              <a href="{{ route('posts.categoria', $categoria) }}">{{$categoria->name}}</a>
            </li>
          @endforeach
        </div>
      </div>
      <div x-data="{open:false}" class="ml-32 flex">
        <div class="text-white ml-2">
          {{__('Etiquetas ')}}
          <i class="fas fa-caret-down cursor-pointer" x-on:click="open=!open" @click.outside="open = false"></i>
        </div>
        <div x-show="open" class="bg-blue-100 shadow-lg rounded-b-lg text-sm overscroll-auto w-32 ml-4 pl-2 h-screen">
          @foreach ($etiquetas as $etiqueta)
            <li>
              <a href="{{ route('posts.tag', $etiqueta) }}">{{$etiqueta->name}}</a>
            </li>
          @endforeach
        </div>
      </div>
    </div>



    <div class="grid grid-cols-3">
      <div class="col-span-2 text-right">
        <h1 class="uppercase text-right text-base md:text-3xl font-bold py-2">Ultimos post</h1>
      </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 z-0">
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