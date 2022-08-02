<?php

namespace App\Http\Livewire;

use App\Mail\FollowItems;
use App\Mail\PublishPost;
use App\Models\Categoria;
use App\Models\Post;
use App\Models\User;
use App\Notifications\PostNotification;
use DateTime;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Log\Logger;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
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
      /* Notificacion de publicacion del post */
      $catFav = $post->categoria->favoriters->map(function ($item) {
        return $item->email;
      });

      Log::info('autor: ' . $post->user->name);
      $autFav = $post->user->favoriters->map(function ($item) {
        return $item->email;
      });

      Log::info('etiquetas');
      $etqs = $post->tags;
      $etqFav = [];
      foreach ($etqs as $etq) {
        $etqFav = ($etq->favoriters->map(function ($item) {
          return $item->email;
        }));
        $mail = new FollowItems($post, "a una de las etiquetas del mismo, " . $etq->name . '.');
        Mail::cc($etqFav)->queue($mail);
      }

      $mail = new FollowItems($post, "al autor del mismo, " . $post->user->name . '.');
      Mail::cc($autFav)->queue($mail);

      $mail = new FollowItems($post, "a la categoria del mismo, " . $post->categoria->name . '.');
      Mail::cc($catFav)->queue($mail);

      $mail = new PublishPost($post);
      Mail::to([$post->user->email, User::first()->email])->queue($mail); // Notify author & Admin

      $post->user->notify(new PostNotification($post, $post->approve)); // Notify author
      User::first()->notify(new PostNotification($post, $post->approve)); // Notify admin

    }
    return;
  }
}
