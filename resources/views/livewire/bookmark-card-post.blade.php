<div class="cursor-pointer">
    @if(Maize\Markable\Models\Bookmark::has($post,Auth::user()))
      <a wire:click="unbookmark" class="rounded-full text-center pt-1 text-green-600">
        {{-- <img class="w-5 h-5" src="{{asset('img-default/bookmark.png')}}"> --}}
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
          <path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z" />
        </svg>
      </a>
    @else
      <a wire:click="bookmark"   class="rounded-full text-center pt-1 text-green-400">
        {{-- <img class="w-5 h-5" src="{{asset('img-default/bookmarkB.png')}}"> --}}
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
        </svg>
      </a>
    @endif
</div>
