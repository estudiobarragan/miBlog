<?php

namespace App\Http\Livewire\Comments;

use App\Models\Comment;
use Exception;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Maize\Markable\Models\Reaction;

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
    /* Solo puede borrar el propio autor del comentario sino tiene replicas ni reacciones en el mismo */
    if($this->comment->user->id == auth()->user()->id && $this->comment->replies->count()==0 && Reaction::count( $this->comment, 'heart')==0){
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
