<?php

namespace App\Services;

use App\Mail\CancelPost;
use App\Mail\FollowItems;
use App\Mail\ProgramPost;
use App\Mail\PublishPost;
use App\Mail\SuspendPost;
use App\Models\Post;
use App\Models\User;
use App\Notifications\PostNotification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;



class PostService
{
  public function __construct()
  {
    //
  }

  public function programar(Post $post, $fechaPublicar)
  {
    $fecha = Carbon::parse($fechaPublicar)->format('Y-m-d');

    // Actualiza estado del post y datos del publicador
    $post->update([
      'state_id' => 4,
      'publicar' => $fecha,
      'publicador_id' => Auth()->user()->id,
    ]);

    /* Notificacion de programacion del post */
    $mail = new ProgramPost($post);
    Mail::to($post->user->email)->queue($mail);

    $post->user->notify(new PostNotification($post, $post->approve));
  }

  public function publicar()
  {
    $posts = Post::where('state_id', 4)->where('publicar', '<=', date('Y-m-d') . ' 23:59:59')->get();

    foreach ($posts as $post) {
      $post->update([
        'state_id' => 5
      ]);
      /* Notificacion de publicacion del post */
      $catFav = $post->categoria->favoriters->map(function ($item) {
        return $item->email;
      });

      /* Log::info('autor: ' . $post->user->name); */
      $autFav = $post->user->favoriters->map(function ($item) {
        return $item->email;
      });

      /* Log::info('etiquetas'); */
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
  public function pausar($id)
  {
    $post = Post::findOrFail($id);
    if ($post->state_id == 6) {
      $post->update([
        'state_id' => 5,
      ]);
    } elseif ($post->state_id == 5) {
      $post->update([
        'state_id' => 6,
      ]);
      /* Notificacion de programacion del post */
      $mail = new SuspendPost($post);
      Mail::to($post->user->email)->queue($mail); // Notify author
      $post->user->notify(new PostNotification($post, $post->approve)); // Notify author
    }
  }

  public function cancelar($id)
  {
    $post = Post::findOrFail($id);
    if ($post->state_id == 7) {
      $post->update([
        'state_id' => 6,
      ]);
    } elseif ($post->state_id == 6) {
      $post->update([
        'state_id' => 7,
      ]);
      /* Notificacion de programacion del post */
      $mail = new CancelPost($post);
      Mail::to($post->user->email)->queue($mail); // Notify author
      $post->user->notify(new PostNotification($post, $post->approve)); // Notify author
    }
  }
}
