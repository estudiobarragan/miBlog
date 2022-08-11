<?php

namespace App\Http\Livewire\Admin;

use App\Models\Post;
use App\Models\State;
use App\Services\PostService;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Livewire\WithPagination;

class PostIndex extends Component
{
  use WithPagination;

  protected $paginationTheme = "bootstrap";

  public $search, $lAdmin, $lAutor, $order_id, $state, $compare, $estados;
  public $causasP = "invisible";
  public $causasC = "invisible";
  private $postService;

  public function boot(PostService $postService)
  {
    $this->postService = $postService;
  }

  public function updatingSearch()
  {
    $this->resetPage();
  }

  public function mount()
  {
    $this->lAdmin = auth()->user()->hasRole('Admin');
    $this->lAutor = auth()->user()->hasRole('Autor');
    $this->estados = State::all();
    $this->order_id = Session::get('order_id', "desc");
    $this->compare = ">=";
    $this->state = 0;
  }

  public function render()
  {
    if ($this->lAdmin) {
      $posts = Post::where('name', 'LIKE', '%' . $this->search . '%')
        ->orderBy('id', $this->order_id)
        ->where('state_id', $this->compare, $this->state)
        ->paginate(8);
    } elseif ($this->lAutor) {
      $posts = Post::where('user_id', auth()->user()->id)
        ->where('name', 'LIKE', '%' . $this->search . '%')
        ->where('state_id', $this->compare, $this->state)
        ->orderBy('id', $this->order_id)
        ->paginate(8);
    } else {
      $posts = Post::where('id', 0)->paginate(8);
    }
    $estados = $this->estados;

    return view('livewire.admin.post-index', compact('posts', 'estados'));
  }
  public function order_id()
  {

    if ($this->order_id == "desc") {
      $this->order_id = "asc";
    } else {
      $this->order_id = "desc";
    }
    Session::put('order_id', $this->order_id);

    return;
  }
  public function stateFilter($item)
  {
    if ($item == 0) {
      $this->compare = ">=";
      $this->state = 0;
    } else {
      $this->state = $item;
      $this->compare = "=";
    }
  }
  public function pausar($id)
  {
    $this->causasP = "hidden";
    $this->postService->pausar($id);
    /* $post = Post::findOrFail($id);
    if ($post->state_id == 6) {
      $post->update([
        'state_id' => 5,
      ]);
    } elseif ($post->state_id == 5) {
      $post->update([
        'state_id' => 6,
      ]);
      /* Notificacion de programacion del post */
    /* $mail = new SuspendPost($post);
      Mail::to($post->user->email)->queue($mail); // Notify author
      $post->user->notify(new PostNotification($post, $post->approve)); // Notify author
    } */
  }

  public function cancelar($id)
  {
    $this->postService->cancelar($id);
    /* $post = Post::findOrFail($id);
    if ($post->state_id == 7) {
      $post->update([
        'state_id' => 6,
      ]);
    } elseif ($post->state_id == 6) {
      $post->update([
        'state_id' => 7,
      ]); */
    /* Notificacion de programacion del post */
    /* $mail = new CancelPost($post);
      Mail::to($post->user->email)->queue($mail); // Notify author
      $post->user->notify(new PostNotification($post, $post->approve)); // Notify author 
    }*/
  }
}
