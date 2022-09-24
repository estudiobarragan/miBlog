<div>
  @auth()
    @if(auth()->user()->id != $comment->user->id)
      @if(Maize\Markable\Models\Reaction::has($comment,Auth::user(),'heart'))
        <p wire:click.prevent="unreact" class="text-sm rounded-full text-center pt-1 text-red-400" alt="btn_heart_unreact">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd" /></svg>
          <p>{{$heart}}</p>
        </p>
      @else
        <p wire:click.prevent="react"   class="text-sm rounded-full text-center pt-1 text-red-400" alt="btn_heart_react">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" /></svg>
          <p>{{$heart}}</p>
        </p>
      @endif
    @else
      <div class="text-sm text-center pt-1 text-blue-600 pr-1 cursor-default" alt="btn_heart_react_autor">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd" /></svg>
        <p>{{$heart}}</p>
      </div>
    @endif
  @else
    <div class="text-sm text-center pt-1 text-blue-600 pr-1 cursor-default" alt="btn_heart_react_guess">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd" /></svg>
      <p>{{$heart}}</p>
    </div>
  @endauth
</div>
