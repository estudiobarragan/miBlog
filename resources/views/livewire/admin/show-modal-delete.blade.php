<div>
  <button onclick="confirm('¿Esta seguro de borrar?') || event.stopImmediatePropagation()" 
          wire:click="delete" 
          class="btn btn-danger btn-sm">
    <i class="far fa-trash-alt"></i>
  </button>
</div>
