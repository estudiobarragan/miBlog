<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Maize\Markable\Models\Like;

class ShowLikePost extends Component
{
  public $post, $like;

  public function render()
  {
    $this->like = Like::count($this->post);

    return view('livewire.show-like-post');
  }
}
