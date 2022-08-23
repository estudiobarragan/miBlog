<?php

namespace App\Http\Livewire\Comments;

use App\Models\Comment;
use Exception;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class ModalInputComment extends Component
{
  public $comentario, $comentario_id, $post_id;
  public $verModal = 'visible';

  protected $validationAttributes = [
    'comentario' => 'required',
  ];

  public function cerrarModal()
  {
    $this->verModal = 'invisible';
  }

  public function store()
  {
    $this->verModal = 'invisible';
    try {
      if ($this->post_id == 0) {
        Comment::create([
          'user_id' => auth()->user()->id,
          'mensaje' => $this->comentario,
          'commentable_id' => $this->comentario_id,
          'commentable_type' => 'App\Models\Comment',
        ]);
      } else {
        Comment::create([
          'user_id' => auth()->user()->id,
          'mensaje' => $this->comentario,
          'commentable_id' => $this->post_id,
          'commentable_type' => 'App\Models\Post',
        ]);
      }
    } catch (Exception $e) {
      Log::debug("inexplicable");
      Log::debug($e);
      Log::debug($this->comentario);
      Log::debug($this->comentario_id);
    }
    $this->comentario = "";
    $this->emit('refresh');
  }
  public function mount($comentario_id = 0, $post_id = 0)
  {
    $this->comentario_id = $comentario_id;
    $this->post_id = $post_id;
  }
  public function render()
  {
    return view('livewire.comments.modal-input-comment');
  }
}
