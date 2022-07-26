<div class="justify-items-start">
  @if(isset($tag))
    {{Maize\Markable\Models\Favorite::has($tag,Auth::user())}}-{{$tag->name}}
    @if(Maize\Markable\Models\Favorite::has($tag,Auth::user()))
      <a wire:click="tag_unlike" class="w-20 ml-5 bg-red-200 hover:bg-red-500 hover:text-white text-red-800 text-sm py-1 px-2 rounded-3xl ">
        <i class="fa fa-user-minus"></i>
      </a>
    @else
      <a wire:click="tag_like"  class="w-20 ml-5 bg-blue-200 hover:bg-blue-500 hover:text-white text-blue-800 text-sm py-1 px-2 rounded-3xl ">
        <i class="fa fa-user-plus"></i>
      </a>
    @endif
  @endif
  @if(isset($categoria))
    @if(Maize\Markable\Models\Favorite::has($categoria,Auth::user()))
      <a wire:click="categoria_unlike" class="w-20 ml-5 bg-red-200 hover:bg-red-500 hover:text-white text-red-800 text-sm py-1 px-2 rounded-3xl ">
        <i class="fa fa-user-minus"></i>
      </a>
    @else
      <a wire:click="categoria_like"  class="w-20 ml-5 bg-blue-200 hover:bg-blue-500 hover:text-white text-blue-800 text-sm py-1 px-2 rounded-3xl ">
        <i class="fa fa-user-plus"></i>
      </a>
    @endif
  @endif
  @if(isset($user))
    @if($user != Auth::user())
      @if(Maize\Markable\Models\Favorite::has($user,Auth::user()))
        <a wire:click="user_unlike" class="w-20 ml-5 bg-red-200 hover:bg-red-500 hover:text-white text-red-800 text-sm py-1 px-2 rounded-3xl ">
          <i class="fa fa-user-minus"></i>
        </a>
      @else
        <a wire:click="user_like" class="w-20 ml-5 bg-blue-200 hover:bg-blue-500 hover:text-white text-blue-800 text-sm py-1 px-2 rounded-3xl ">
          <i class="fa fa-user-plus"></i>
        </a>
      @endif
    @endif
  @endif
</div>
