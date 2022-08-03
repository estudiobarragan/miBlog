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
    $usuarios = User::with('roles')->get();
    $autores = $usuarios->where(function ($user, $key) {
      return $user->hasRole('Autor');
    });
    return view('livewire.barra-consulta', compact('categorias', 'etiquetas', 'autores'));
  }
  public function autor(User $user)
  {
    $this->emit('askAutor', $user);
    return;
  }
  public function categoria($categoria)
  {
    $categoria = Categoria::find($categoria['id']);
    $this->emit('askCategoria', $categoria);
    return;
  }
  public function etiqueta($etiqueta)
  {
    $etiqueta = Tag::find($etiqueta['id']);
    $this->emit('askEtiqueta', $etiqueta);
    return;
  }
  public function buscar()
  {
    $this->emit('search', $this->filter);
  }
}
