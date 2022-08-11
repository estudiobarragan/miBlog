<?php

namespace App\Http\Livewire\Admin;

use App\Models\Post;
use App\Services\PostService;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Livewire\WithPagination;

class PublicationPostIndex extends Component
{
  use WithPagination;

  protected $paginationTheme = "bootstrap";
  public $showModal = false;
  public $search, $lAdmin, $lPublicador, $order_id, $post, $fechaPublicar;
  private $postService;

  protected $rules = [
    'start' => 'required',
  ];

  public function updatingSearch()
  {
    $this->resetPage();
  }
  public function boot(PostService $postService)
  {
    $this->postService = $postService;
  }
  public function mount()
  {
    $this->lAdmin = auth()->user()->hasRole('Admin');
    $this->lPublicador = auth()->user()->hasRole('Publicador');
    $this->order_id = Session::get('order_id', "desc");
  }

  public function render()
  {
    $posts = Post::where([
      ['state_id', 3],
    ])
      ->orWhere([
        ['state_id', 4],
      ])
      ->where('name', 'LIKE', '%' . $this->search . '%')
      ->orderBy('id', $this->order_id)
      ->paginate(10);

    return view('livewire.admin.publication-post-index', compact('posts'));
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
  public function edit($post)
  {
    $this->showModal = true;

    if ($post['publicar'] == null) {
      $this->fechaPublicar = date('d-M-Y');
    } else {
      $this->fechaPublicar = $post['publicar'];
    }
    $this->post = Post::findOrFail($post['id']);
  }
  public function close()
  {
    $this->showModal = false;
  }
  public function save()
  {
    $this->showModal = false;

    $this->postService->programar($this->post, date('Y-m-d', strtotime($this->fechaPublicar)));
    $this->postService->publicar();
  }

  public function publicar()
  {
    $this->postService->publicar();
  }
}
