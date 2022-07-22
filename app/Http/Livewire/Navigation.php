<?php

namespace App\Http\Livewire;

use App\Models\Categoria;
use App\Models\Post;
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
    $posts = Post::where('state_id', 4)->get();
    if ($posts->count() > 0) {
      foreach ($posts as $post) {
        if ($post->publication->start <= date('d-M-Y')) {
          $post->publication->update([
            'start' => date('Y-m-d'),
          ]);
          $post->update(['state_id' => 5]);
        }
      }
      Cache::flush();
    }
    return;
  }
}
