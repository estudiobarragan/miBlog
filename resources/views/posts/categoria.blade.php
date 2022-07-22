<x-app-layout>
  <div class="container py-8">
    <div class="grid grid-cols-3 py-2">
      <div class="col-span-2">
        <h1 class="md:uppercase text-right md:text-3xl sm:text-xs font-bold w-full">
          Categoría: {{$categoria->name}}
        </h1>
      </div>
      <div>
        @auth()
          @livewire('follow-model',['categoria' => $categoria])
        @endauth()
      </div>
    </div>
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