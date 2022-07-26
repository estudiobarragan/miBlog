<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Maize\Markable\Models\Bookmark;
use Maize\Markable\Models\Favorite;

class FollowModel extends Component
{
  public $tag, $categoria, $user;

  /* public function mount($tag)
  {
    $this->tag = $tag;
  } */
  public function render()
  {
    return view('livewire.follow-model');
  }
  public function tag_like()
  {
    Favorite::add($this->tag, auth()->user());
    return;
  }
  public function tag_unlike()
  {
    Favorite::remove($this->tag, auth()->user());
    return;
  }
  public function categoria_like()
  {
    Favorite::add($this->categoria, auth()->user());
    return;
  }
  public function categoria_unlike()
  {
    Favorite::remove($this->categoria, auth()->user());
    return;
  }
  public function user_like()
  {
    Favorite::add($this->user, auth()->user());
    return;
  }
  public function user_unlike()
  {
    Favorite::remove($this->user, auth()->user());
    return;
  }
}
