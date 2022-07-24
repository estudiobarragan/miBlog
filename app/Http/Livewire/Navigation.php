<?php

namespace App\Http\Livewire;

use App\Models\Categoria;
use App\Models\Post;
use DateTime;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class Navigation extends Component
{
  public function mount()
  {
    $this->publicar();
  }
  public function render()
  {
    $categorias = Categoria::all();
    return view('livewire.navigation', compact('categorias'));
  }
  public function publicar()
  {
    $posts = Post::where('state_id', 4)->where('publicar', '<=', date('Y/m/d'))->get();

    foreach ($posts as $post) {
      $post->update([
        'publicar' => Date('Y-m-d h:i'),
        'state_id' => 5
      ]);
    }
    Cache::flush();
    return;
  }
}
