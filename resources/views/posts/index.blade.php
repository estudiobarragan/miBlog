<x-app-layout>
  <div class="container py-4">

    @livewire('barra-consulta')

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