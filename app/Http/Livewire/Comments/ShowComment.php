<?php

namespace App\Http\Livewire\Comments;

use App\Models\Comment;
use Exception;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class ShowComment extends Component
{
  public $comment, $masSangria;
  public $ver = 'visible';
  public $verRep = 'invisible';
  public $sangria = 0;
  public $open = false;
  public $verModal = 'invisible';
  public $evenReply = true;

  protected $listeners = ['abrirReply', 'cerrarReply'];
  public function abrirReply()
  {
    if ($this->evenReply) {
      $this->showReplies(true);
      $this->render();
      if ($this->comment->replies->count() > 0) {
        $this->emit('abrirReply');
        $this->evenReply = false;
      }
    }
  }
  public function cerrarReply()
  {
    $this->showReplies(false);
    $this->evenReply = true;
  }
  public function toogleModal()
  {
    if ($this->verModal == 'visible') {
      $this->verModal = 'invisible';
    } else {
      $this->verModal = 'visible';
    }
  }

  public function showReplies($open)
  {
    $this->open = $open;
    if ($open) {
      $this->ver = 'invisible';
      $this->verRep = 'visible';
    } else {
      $this->ver = 'visible';
      $this->verRep = 'invisible';
    }
  }
  public function toogle()
  {
    $this->showReplies(!$this->open);
  }

  /*   public function emitir($id)
  {
    $comment = Comment::find($id);

    $this->emit('inputComment', $comment->id);
  } */
  public function mount()
  {
    $this->sangria = $this->sangria + $this->masSangria;
  }

  public function render()
  {
    return view('livewire.comments.show-comment');
  }
}
