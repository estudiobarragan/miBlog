<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Maize\Markable\Models\Like;
use Maize\Markable\Models\Reaction;

class ReactionPost extends Component
{
  protected $listeners = [
    'pos' => 'positive',
    'neg' => 'negative',
  ];

  public $type, $post, $group;

  public function render()
  {
    return view('livewire.reaction-post');
  }
  public function react()
  {

    Reaction::add($this->post, auth()->user(), $this->type);
    if ($this->group == '+') {
      $this->emit('pos');
      Like::add($this->post, auth()->user());
    } else {
      $this->emit('neg');
      Like::remove($this->post, auth()->user());
    }
  }
  public function unreact()
  {

    Reaction::remove($this->post, auth()->user(), $this->type);
  }
  public function positive()
  {
    if ($this->group == '-') {
      $this->unreact();
    }
  }
  public function negative()
  {
    if ($this->group == '+') {
      $this->unreact();
    }
  }
}
