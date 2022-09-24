<?php

namespace App\Http\Livewire\Comments;

use App\Models\Comment;
use Exception;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class ShowComment extends Component
{
  public $comment, $masSangria;
  public $sangria = 0;
  public $verModal = 'invisible';
  public $confirmingDeletion = "";
  public $verComponente=true;

  public function toogleModal()
  {
    if ($this->verModal == 'visible') {
      $this->verModal = 'invisible';
    } else {
      $this->verModal = 'visible';
    }
  }

  public function mount(Comment $comment)
  {
    $this->comment = $comment;
    $this->sangria = $this->sangria + $this->masSangria;
  }

  public function delete()
  {
    if($this->comment->replies->count()==0){
      $this->comment->delete();
    }
    $this->confirmingDeletion = false;
    $this->verComponente=false;
    $this->emitUp('recargar');
  }

  public function render()
  {
    return view('livewire.comments.show-comment');
  }
}
