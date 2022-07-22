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
          <a href="{{route('posts.seguir',['category',$categoria->id])}}" class="w-20 ml-5 bg-blue-200 hover:bg-blue-500 hover:text-white text-blue-700 text-center py-2 px-4 rounded">Seguir</a>
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