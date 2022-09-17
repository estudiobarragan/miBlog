<?php

namespace App\Http\Livewire;

use App\Models\Categoria;
use App\Models\Tag;
use App\Models\User;
use Livewire\Component;

class BarraConsulta extends Component
{
  public $filter = '';
  public $search;
  public $soloFilter = '';
  public function render()
  {
    if ($this->search) {
      $this->soloFilter = 'hidden';
    }

    $categorias = Categoria::all();
    $etiquetas = Tag::all();
    $autores = User::role('Autor')->with('roles')->get();

    return view('livewire.barra-consulta', compact('categorias', 'etiquetas', 'autores'));
  }
  public function autor(User $user)
  {
    $this->search='';
    $this->emit('askAutor', $user);
    return;
  }
  public function categoria($categoria_id)
  {
    $this->search='';
    $this->emit('askCategoria', $categoria_id);
    return;
  }
  public function etiqueta($etiqueta_id)
  {
    $this->search='';
    $this->emit('askEtiqueta', $etiqueta_id);
    return;
  }
  public function buscar()
  {
    $this->emit('search', $this->filter);
  }
}
