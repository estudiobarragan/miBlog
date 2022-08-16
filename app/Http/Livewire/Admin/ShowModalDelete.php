<?php

namespace App\Http\Livewire\Admin;

use Illuminate\Queue\Listener;
use Livewire\Component;

class ShowModalDelete extends Component
{
  public $model, $ruta;

  public function mount($model, $ruta)
  {
    $this->model = $model;
    $this->ruta = $ruta;
  }

  public function delete()
  {
    $this->model->delete();

    return redirect()->to($this->ruta);
  }

  public function render()
  {
    return view('livewire.admin.show-modal-delete');
  }
}
