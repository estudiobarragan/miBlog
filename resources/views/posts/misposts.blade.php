<x-app-layout>
  <div class="container py-4">

    @livewire('barra-consulta')
    
    @livewire('posts.show-carrusel-post',['type'=>$type])
  </div>
</x-app-layout>