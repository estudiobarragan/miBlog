<div>
    @if(Maize\Markable\Models\Bookmark::has($post,Auth::user()))
      <a wire:click="unbookmark" class="rounded-full text-center pt-1 bg-blue-400 hover:bg-blue-800">
        <img class="w-5 h-5" src="{{asset('img-default/bookmark.png')}}">
      </a>
    @else
      <a wire:click="bookmark"   class="rounded-full text-center pt-1 text-blue-600 hover:bg-blue-200">        
        <img class="w-5 h-5" src="{{asset('img-default/bookmarkB.png')}}">
        
      </a>
    @endif
</div>
