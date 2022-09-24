<?php

namespace App\Http\Livewire\Comments;

use App\Models\Post;
use Livewire\Component;

class ShowPostComment extends Component
{
  public $post;
  public $verModal = 'invisible';

  protected $listeners  = ['recargar'];

  public function recargar()
  {
    $this->verModal = 'invisible';
    $this->render();
  }

  public function toogle()
  {

    if ($this->verModal == 'visible') {
      $this->verModal = 'invisible';
    } else {
      $this->verModal = 'visible';
    }
  }

  public function render()
  {
    
    return view('livewire.comments.show-post-comment');
  }
}
