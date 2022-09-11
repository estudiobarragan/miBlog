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
  public $openAll;
  public $confirmingDeletion = "";


  protected $listeners = ['abrirReply', 'cerrarReply'];
  public function abrirReply()
  {
    if ($this->comment->replies->count() > 0) {
      $this->showReplies(true);
    }
  }
  public function cerrarReply()
  {
    $this->showReplies(false);
    $this->openAll = false;
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

  public function mount(Comment $comment)
  {
    $this->comment = $comment;
    $this->sangria = $this->sangria + $this->masSangria;
  }

  public function delete()
  {
    /*
    $this->confirmingDeletion = false;
    $this->comment->repl
     $this->model->delete();
    return redirect()->to($this->ruta); */
  }

  public function render()
  {
    if ($this->openAll) {
      $this->showReplies(true);
    }
    return view('livewire.comments.show-comment');
  }
}
