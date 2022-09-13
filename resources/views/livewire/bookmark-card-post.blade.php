<div class="cursor-pointer mt-1">
    @if(Maize\Markable\Models\Bookmark::has($post,Auth::user()))
      <a wire:click="unbookmark" class="rounded-full text-center pt-1 text-green-600" alt="bookmark_select">
        {{-- <img class="w-5 h-5" src="{{asset('img-default/bookmark.png')}}"> --}}
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" width="16" height="16" fill="currentColor" class="bi bi-bookmark-check-fill" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M2 15.5V2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.74.439L8 13.069l-5.26 2.87A.5.5 0 0 1 2 15.5zm8.854-9.646a.5.5 0 0 0-.708-.708L7.5 7.793 6.354 6.646a.5.5 0 1 0-.708.708l1.5 1.5a.5.5 0 0 0 .708 0l3-3z"/></svg>
      </a>
    @else
      <a wire:click="bookmark"   class="rounded-full text-center pt-1 text-green-400" alt="bookmark_unselect">
        {{-- <img class="w-5 h-5" src="{{asset('img-default/bookmarkB.png')}}"> --}}
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" width="16" height="16" fill="currentColor" class="bi bi-bookmark" viewBox="0 0 16 16"><path d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.777.416L8 13.101l-5.223 2.815A.5.5 0 0 1 2 15.5V2zm2-1a1 1 0 0 0-1 1v12.566l4.723-2.482a.5.5 0 0 1 .554 0L13 14.566V2a1 1 0 0 0-1-1H4z"/></svg>
      </a>
    @endif
</div>
