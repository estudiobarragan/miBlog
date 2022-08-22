<?php

namespace App\Http\Livewire\Comments;

use Livewire\Component;

class ShowPostComment extends Component
{
  public $post;
  public $verModal = 'invisible';

  protected $listeners  = ['refresh'];

  public function refresh()
  {
    // dd('por aca');
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
