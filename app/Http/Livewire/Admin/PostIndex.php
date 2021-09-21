<?php

namespace App\Http\Livewire\Admin;

use App\Models\Post;
use Livewire\Component;
use Livewire\WithPagination;

class PostIndex extends Component
{
  use WithPagination;

  protected $paginationTheme = "bootstrap";

  public $search, $lAdmin, $lAutor;

  public function updatingSearch()
  {
    $this->resetPage();
  }

  public function mount()
  {
    $this->lAdmin = auth()->user()->hasRole('Admin');
    $this->lAutor = auth()->user()->hasRole('Autor');
  }

  public function render()
  {
    if ($this->lAdmin) {
      $posts = Post::where('name', 'LIKE', '%' . $this->search . '%')
        ->latest('id')
        ->paginate(8);
    } elseif ($this->lAutor) {
      $posts = Post::where('user_id', auth()->user()->id)
        ->where('name', 'LIKE', '%' . $this->search . '%')
        ->latest('id')
        ->paginate(8);
    } else {
      $posts = Post::where('id', 0)->paginate(8);
    }
    return view('livewire.admin.post-index', compact('posts'));
  }
}
