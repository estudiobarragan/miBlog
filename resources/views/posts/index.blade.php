<x-app-layout>

  <div class="container py-4">

    @livewire('barra-consulta',['search'=>false])
    
    @livewire('posts.show-index-post')
  </div>
  
</x-app-layout>