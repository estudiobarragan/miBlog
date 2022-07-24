<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Maize\Markable\Models\Reaction;

class ShowReactionPost extends Component
{
  public $post;
  public $thumbup = 0;
  public $thumbdown = 0;
  public $heart = 0;
  public $star = 0;
  public $unhappy = 0;
  public $brokenheart = 0;

  public function render()
  {
    $this->thumbup = Reaction::count($this->post, 'thumbup');
    $this->thumbdown = Reaction::count($this->post, 'thumbdown');
    $this->heart = Reaction::count($this->post, 'heart');
    $this->star = Reaction::count($this->post, 'star');
    $this->unhappy = Reaction::count($this->post, 'unhappy');
    $this->brokenheart = Reaction::count($this->post, 'brokenheart');

    return view('livewire.show-reaction-post');
  }
}
