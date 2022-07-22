<?php

namespace App\Http\Livewire\Admin;

use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Livewire\WithPagination;

class PublicationPostIndex extends Component
{
  use WithPagination;

  protected $paginationTheme = "bootstrap";
  public $showModal = false;
  public $search, $lAdmin, $lPublicador, $order_id, $post, $fechaPublicar;

  protected $rules = [
    'start' => 'required',
  ];

  public function updatingSearch()
  {
    $this->resetPage();
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

    if (array_key_exists('publication', $post)) {
      $this->fechaPublicar = $post['publication']['start'];
    } else {
      $this->fechaPublicar = date('d-M-Y');
    }
    $this->post = $post;
  }
  public function close()
  {
    $this->showModal = false;
  }
  public function save()
  {
    $this->showModal = false;
    $fecha = Carbon::createFromFormat('d-M-Y', $this->fechaPublicar)->format('Y-m-d');
    if (array_key_exists('publication', $this->post)) {
      $post = Post::findOrFail($this->post['id']);
      $post->publication->update([
        'start' => $fecha,
      ]);
    } else {
      $post = Post::findOrFail($this->post['id']);
      $post->publication()->create([
        'title' => $post->name,
        'start' => $fecha,
        'post_id' => $post->id,
      ]);
    }
    // Actualiza estado del post y datos del publicador
    $post->update([
      'state_id' => 4,
      'publicador_id' => Auth()->user()->id,
    ]);
    /*   Cache::flush(); */
  }
}
