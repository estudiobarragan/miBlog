<div class="bg-gray-400 h-10 w-full mb-2 flex fixed z-30">
  {{-- Categorias --}}
  <div  x-cloak x-data="{open:false}" class="flex {{$soloFilter}}">
    <div class="z-10">
      <div class="text-white ml-2">
        {{__('Categorias ')}}
        <i class="fas fa-caret-down cursor-pointer" x-on:click="open=!open" @click.outside="open = false"></i>
      </div>
      <div x-show="open" class="bg-gray-100 shadow-lg rounded-lg text-sm w-32 ml-4 pl-2 h-30 overflow-y-auto overflow-hidden">
        @foreach ($categorias as $categoria)
          <li>
            {{-- <a href="{{ route('posts.categoria', $categoria) }}">{{$categoria->name}}</a> --}}
            <a wire:click="categoria({{$categoria}})" class="cursor-pointer">{{$categoria->name}}</a>
          </li>
        @endforeach
      </div>
    </div>
  </div>

  {{-- Etiquetas --}}
  <div x-cloak x-data="{open:false}" class="ml-2 md:ml-12 flex {{$soloFilter}}">
    <div class="z-10">
      <div class="text-white ml-2">
        {{__('Etiquetas ')}}
        <i class="fas fa-caret-down cursor-pointer" x-on:click="open=!open" @click.outside="open = false"></i>
      </div>
      <div x-show="open" class="bg-gray-100 shadow-lg rounded-lg text-sm w-32 ml-4 pl-2 h-36 overflow-y-auto overflow-hidden">
        @foreach ($etiquetas as $etiqueta)
          <li>
            {{-- <a href="{{ route('posts.tag', $etiqueta) }}">{{$etiqueta->name}}</a> --}}
            <a wire:click="etiqueta({{$etiqueta}})" class="cursor-pointer">{{$etiqueta->name}}</a>
      </a>
          </li>
        @endforeach
      </div>
    </div>
  </div>

  {{-- Autores --}}
  <div x-cloak x-data="{open:false}" class="ml-2 md:ml-12 flex {{$soloFilter}}">
    <div class="z-10">
      <div class="text-white ml-2">
        {{__('Autores ')}}
        <i class="fas fa-caret-down cursor-pointer" x-on:click="open=!open" @click.outside="open = false"></i>
      </div>
      <div x-show="open" class="bg-gray-100 shadow-lg rounded-lg text-sm w-52 ml-4 pl-2 h-36 overflow-y-auto overflow-hidden">
        @foreach ($autores as $autor)
          <li>
            <a wire:click="autor({{$autor}})" class="cursor-pointer">{{$autor->name}}</a>
          </li>
        @endforeach
      </div>
    </div>
  </div>

  {{-- Search --}}
  <div class="ml-2 align-top md:ml-12 flex-grow">
    <div class="z-10">
      <div class="text-white ml-2">
        {{__('Buscar: ')}}
        <input wire:keydown.enter="buscar" wire:model="filter" class="text-sm text-gray-600 h-8 py-2 w-4/6" type="text" name="buscar" placeholder="Que esta buscando?"/>
      </div>
   
    </div>
  </div>
</div>
