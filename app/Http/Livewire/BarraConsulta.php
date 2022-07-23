<?php

namespace App\Http\Livewire;

use App\Models\Categoria;
use App\Models\Tag;
use App\Models\User;
use Livewire\Component;

class BarraConsulta extends Component
{
  public function render()
  {
    $categorias = Categoria::all();
    $etiquetas = Tag::all();
    $usuarios = User::with('roles')->get();
    $autores = $usuarios->where(function ($user, $key) {
      return $user->hasRole('Autor');
    });
    return view('livewire.barra-consulta', compact('categorias', 'etiquetas', 'autores'));
  }
}
