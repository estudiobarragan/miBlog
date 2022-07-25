<x-app-layout>
  <div class="container py-4">

    @livewire('barra-consulta')
    
    <div class="mt-14 text-center">
      <h1 class="md:uppercase md:text-3xl sm:text-xs font-bold inline-flex">
        Etiqueta: {{$tag->name}}
        @auth()
          @livewire('follow-model',['tag' => $tag])
        @endauth()
      </h1>
    </div>

    <div class="mb-2">
      {{$posts->links()}}
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      @foreach($posts as $post)
        <article class="@if($loop->first) md:col-span-2 @endif">
          <x-card-post :post="$post"></x-card-post>
        </article>
      @endforeach
    </div>
  
    

  </div>
</x-app-layout>