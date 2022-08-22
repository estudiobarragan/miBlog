<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Maize\Markable\Models\Reaction;

class ReactionComment extends Component
{
  public $comment, $heart;

  public function react()
  {
    Reaction::add($this->comment, auth()->user(), 'heart');
  }
  public function unreact()
  {
    Reaction::remove($this->comment, auth()->user(), 'heart');
  }

  public function render()
  {
    $this->heart = Reaction::count($this->comment, 'heart');

    return view('livewire.reaction-comment');
  }
}
