<?php

namespace App\Http\Livewire\Posts;

use Livewire\Component;
use Maize\Markable\Models\Favorite;

class ShowCardCarruselPost extends Component
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
      if (Favorite::has($this->post->categoria, auth()->user()) == 1) {
        $this->fabCategory = '#';
      } else {
        $this->fabCategory = '+';
      }
    } else {
      $this->fabCategory = '';
    }

    foreach ($this->post->tags as $tag) {
      if (Auth()->user()) {
        if (Favorite::has($tag, auth()->user())) {
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
    return view('livewire.posts.show-card-carrusel-post');
  }
}
