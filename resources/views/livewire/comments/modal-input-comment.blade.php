<div>
  {{-- modal para input del comentario --}}
  @if($verModal=='visible')
    <div class="{{$verModal}}">
      <form>
        <div class="bg-white px-1 sm:p-6 sm:pb-1">
          <div class="">
            <div class="mb-4">
              <input autofocus wire:keydown.enter="store" wire:keydown.escape="cerrarModal" 
                      wire:model="comentario" type="text" wire:model.defer
                      class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                      placeholder="Su comentario">
            </div>
          </div>
        </div>
      </form>
    </div>
  @endif
  
</div>
