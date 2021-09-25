<?php

namespace App\Http\Livewire\Admin;

use App\Models\Post;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Livewire\WithPagination;

class PublicationPostIndex extends Component
{
  use WithPagination;

  protected $paginationTheme = "bootstrap";

  public $search, $lAdmin, $lPublicador, $order_id;

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
      ['publicador_id', auth()->user()->id],
      ['user_id', '!=', auth()->user()->id],
    ])
      ->orWhere([
        ['state_id', 4],
        ['publicador_id', auth()->user()->id],
        ['user_id', '!=', auth()->user()->id],
      ])
      ->orWhere([
        ['state_id', 3],
        ['publicador_id', null],
        ['user_id', '!=', auth()->user()->id],
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
}
