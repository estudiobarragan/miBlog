<?php

namespace App\Http\Livewire;

use App\Mail\PublishPost;
use App\Models\Categoria;
use App\Models\Post;
use App\Models\User;
use App\Notifications\PostNotification;
use DateTime;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Spatie\Permission\Models\Role;

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
      /* Notificacion de programacion del post */
      $mail = new PublishPost($post);
      Mail::to($post->user->email)->queue($mail); // Notify author
      Mail::to(User::first()->email)->queue($mail); // Notify admin

      $post->user->notify(new PostNotification($post, $post->approve)); // Notify author
      User::first()->notify(new PostNotification($post, $post->approve)); // Notify admin
    }

    Cache::flush();
    return;
  }
}
