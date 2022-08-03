<x-app-layout>
  <div class="container py-4">

    {{-- @livewire('barra-consulta',['search'=>true]) --}}
    
    @livewire('posts.show-carrusel-post',['type'=>$type])
  </div>
</x-app-layout>