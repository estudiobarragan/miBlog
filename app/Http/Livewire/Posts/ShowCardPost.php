<?php

namespace App\Http\Livewire\Posts;

use App\Models\Categoria;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Support\Carbon;
use Livewire\Component;
use Maize\Markable\Models\Favorite;

class ShowCardPost extends Component
{
  public $post, $indice;
  public $fabCategory = '';
  public $fabTag = [];
  public $fabAuthor = '';
  public $colspan = 'col-span-1';

  public function render()
  {
    if ($this->indice == 0) {
      $this->colspan = 'col-span-2';
    }
    if (Auth()->user()) {
      if (Favorite::has($this->post->categoria, Auth()->user()) == 1) {
        $this->fabCategory = '#';
      } else {
        $this->fabCategory = '+';
      }
    } else {
      $this->fabCategory = '';
    }

    foreach ($this->post->tags as $tag) {
      if (Auth()->user()) {
        if (Favorite::has($tag, Auth()->user())) {
          array_push($this->fabTag, '#');
        } else {
          array_push($this->fabTag, '+');
        }
      } else {
        array_push($this->fabTag, '');
      }
    }
    if (Auth()->user()) {
      if (Favorite::has($this->post->user, Auth()->user()) == 1) {
        $this->fabAuthor = '#';
      } else {
        $this->fabAuthor = '+';
      }
    } else {
      $this->fabAuthor = '';
    }
    return view('livewire.posts.show-card-post');
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
}
