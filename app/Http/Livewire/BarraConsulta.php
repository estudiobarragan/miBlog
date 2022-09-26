<?php

namespace App\Http\Livewire;

use App\Models\Tag;
use App\Models\User;
use Livewire\Component;
/* use Laravel\Jetstream\Rules\Role; */
use App\Models\Categoria;
use Spatie\Permission\Models\Role;

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

    $categorias = Categoria::select('id','name')->get();
    $etiquetas = Tag::select('id','name')->get();
    $autores = [];
    if(Role::where('name','=','Autor')->count()>0){
      $autores = User::select('id','name')->role('Autor')->with('roles')->get();
    }

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
