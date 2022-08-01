<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ShowProfile extends Component
{
  public $author;
  public $posts, $url;

  public function render()
  {
    $this->posts = $this->author->posts->where('state_id', 5);
    $this->url = env('APP_URL') . '/posts/';

    return view('livewire.show-profile');
  }
}
