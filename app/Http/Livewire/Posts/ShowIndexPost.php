<?php

namespace App\Http\Livewire\Posts;

use App\Models\Categoria;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;
use Livewire\WithPagination;

use function PHPUnit\Framework\isEmpty;

class ShowIndexPost extends Component
{
  use WithPagination;
  public $type = 'Ultimos Posts';
  public $search = '';
  public $value;

  protected $listeners = ['askAutor', 'askCategoria', 'askEtiqueta', 'search'];
  public function change()
  {
    $this->resetPage();
  }
  public function render()
  {
    if ($this->type == 'Ultimos Posts') {
      $posts = Post::where('state_id', 5)->with(['user', 'categoria', 'tags'])
        ->where('name', 'LIKE', '%' . $this->search . '%')
        ->orderBy('publicar', 'desc')
        ->paginate(5);
    }
    if ($this->type == 'Mis Posts') {
      $posts = Post::where('state_id', 5)->with(['user', 'categoria', 'tags'])
        ->orderBy('publicar', 'desc')
        ->paginate(5);
    }
    if ($this->type == 'Autor') {
      $posts = Post::where('state_id', 5)->with(['user', 'categoria', 'tags'])->where('user_id', '=', $this->value->id)
        ->orderBy('publicar', 'desc')
        ->paginate(5);
    }
    if ($this->type == 'Categoria') {
      $posts = Post::where('state_id', 5)->with(['user', 'categoria', 'tags'])->where('categoria_id', '=', $this->value->id)
        ->orderBy('publicar', 'desc')
        ->paginate(5);
    }
    if ($this->type == 'Etiqueta') {
      $posts = $this->value->posts()->where('state_id', 5)->with(['user', 'categoria', 'tags'])
        ->orderBy('publicar', 'desc')
        ->paginate(5);
    }


    return view('livewire.posts.show-index-post', ['posts' => $posts]);
  }
  public function askAutor(User $user)
  {
    $this->type = "Autor";
    $this->value = $user;
    $this->change();

    return;
  }
  public function askCategoria($categoria)
  {
    $categoria = Categoria::find($categoria['id']);
    $this->type = "Categoria";
    $this->value = $categoria;
    $this->change();

    return;
  }
  public function askEtiqueta($etiqueta)
  {
    $this->value = Tag::find($etiqueta['id']);
    $this->type = "Etiqueta";
    $this->change();

    return;
  }
  public function search($search)
  {
    $this->type = "Ultimos Posts";
    $this->search = $search;
    $this->change();

    return;
  }
}
