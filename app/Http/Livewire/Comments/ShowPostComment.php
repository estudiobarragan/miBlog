<?php

namespace App\Http\Livewire\Comments;

use App\Models\Post;
use Livewire\Component;

class ShowPostComment extends Component
{
  public $post;
  public $verModal = 'invisible';

  protected $listeners  = ['refresh'];

  public function refresh()
  {
    if ($this->verModal == 'invisible') {
      $this->verModal = 'visible';
    }
  }
  public function toogle()
  {

    if ($this->verModal == 'visible') {
      $this->verModal = 'invisible';
    } else {
      $this->verModal = 'visible';
    }
  }
  public function mount(Post $post)
  {
    $this->post = $post;
  }

  public function render()
  {
    return view('livewire.comments.show-post-comment');
  }
}
