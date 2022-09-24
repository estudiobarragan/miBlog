<div>
  {{-- modal para input del comentario --}}
  @if($verModal=='visible')
  
      <form wire:submit.prevent="store">
        <div class="bg-white px-1 sm:p-6 sm:pb-1">
          <div class="">
            <div class="mb-4 flex">
              <input autofocus wire:keydown.escape="cerrarModal" 
                      wire:model="comentario" type="text" wire:model.defer="comentario"
                      class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                      placeholder="Su comentario">
              <button type="submit" class="text-white bg-green-500 px-2 mx-1 text-sm rounded">Comentar</button>
            </div>
          </div>
        </div>
      </form>

  @endif
  
</div>
