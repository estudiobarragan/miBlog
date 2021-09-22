<?php

namespace App\Http\Livewire\Admin;

use App\Models\Post;
use App\Models\State;
use Livewire\Component;
use Livewire\WithPagination;

class PostIndex extends Component
{
  use WithPagination;

  protected $paginationTheme = "bootstrap";

  public $search, $lAdmin, $lAutor, $order_id, $state, $compare, $estados;

  public function updatingSearch()
  {
    $this->resetPage();
  }

  public function mount()
  {
    $this->lAdmin = auth()->user()->hasRole('Admin');
    $this->lAutor = auth()->user()->hasRole('Autor');
    $this->estados = State::all();
    $this->order_id = "desc";
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


    return view('livewire.admin.post-index', compact('posts', $this->estados));
  }
  public function order_id()
  {

    if ($this->order_id == "desc") {
      $this->order_id = "asc";
    } else {
      $this->order_id = "desc";
    }

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
}
