<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Maize\Markable\Models\Bookmark;

class BookmarkCardPost extends Component
{
  public $post;

  public function render()
  {
    return view('livewire.bookmark-card-post');
  }
  public function bookmark()
  {
    Bookmark::add($this->post, auth()->user());
    return;
  }
  public function unbookmark()
  {
    Bookmark::remove($this->post, auth()->user());
    return;
  }
}
