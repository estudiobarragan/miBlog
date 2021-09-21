<x-app-layout>
  <div class="container py-8">
    <h1 class="uppercase text-center text-3xl font-bold">Etiqueta: {{$tag->name}}</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      @foreach($posts as $post)
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