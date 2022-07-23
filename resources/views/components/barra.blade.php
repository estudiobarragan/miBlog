@props(['categorias','etiquetas','autores'])

<div class="bg-gray-400 h-10 w-full mb-2 flex">
  {{-- Categorias --}}
  <div x-data="{open:false}" class="flex">
    <div class="z-10">
      <div class="text-white ml-2">
        {{__('Categorias ')}}
        <i class="fas fa-caret-down cursor-pointer" x-on:click="open=!open" @click.outside="open = false"></i>
      </div>
      <div x-show="open" class="bg-gray-100 shadow-lg rounded-lg text-sm w-32 ml-4 pl-2 h-30 overflow-y-auto overflow-hidden">
        @foreach ($categorias as $categoria)
          <li>
            <a href="{{ route('posts.categoria', $categoria) }}">{{$categoria->name}}</a>
          </li>
        @endforeach
      </div>
    </div>
  </div>

  {{-- Etiquetas --}}
  <div x-data="{open:false}" class="ml-2 md:ml-12 flex">
    <div class="z-10">
      <div class="text-white ml-2">
        {{__('Etiquetas ')}}
        <i class="fas fa-caret-down cursor-pointer" x-on:click="open=!open" @click.outside="open = false"></i>
      </div>
      <div x-show="open" class="bg-gray-100 shadow-lg rounded-lg text-sm w-32 ml-4 pl-2 h-36 overflow-y-auto overflow-hidden">
        @foreach ($etiquetas as $etiqueta)
          <li>
            <a href="{{ route('posts.tag', $etiqueta) }}">{{$etiqueta->name}}</a>
          </li>
        @endforeach
      </div>
    </div>
  </div>

  {{-- Autores --}}
  <div x-data="{open:false}" class="ml-2 md:ml-12 flex">
    <div class="z-10">
      <div class="text-white ml-2">
        {{__('Autores ')}}
        <i class="fas fa-caret-down cursor-pointer" x-on:click="open=!open" @click.outside="open = false"></i>
      </div>
      <div x-show="open" class="bg-gray-100 shadow-lg rounded-lg text-sm w-52 ml-4 pl-2 h-36 overflow-y-auto overflow-hidden">
        @foreach ($autores as $autor)
          <li>
            <a href="{{ route('posts.user', $autor) }}">{{$autor->name}}</a>
          </li>
        @endforeach
      </div>
    </div>
  </div>
</div>