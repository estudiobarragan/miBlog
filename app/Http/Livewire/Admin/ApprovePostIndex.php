<?php

namespace App\Http\Livewire\Admin;

use App\Models\Post;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class ApprovePostIndex extends Component
{
  use WithPagination;

  protected $paginationTheme = "bootstrap";

  public $search, $lAdmin, $lEditor, $order_id;

  public function updatingSearch()
  {
    $this->resetPage();
  }
  public function mount()
  {
    $this->lAdmin = auth()->user()->hasRole('Admin');
    $this->lEditor = auth()->user()->hasRole('Editor');
    $this->order_id = "desc";
  }

  public function render()
  {
    $posts = Post::where([
      ['state_id', 2],
      ['editor_id', auth()->user()->id],
      ['user_id', '!=', auth()->user()->id],
    ])
      ->orWhere([
        ['state_id', 2],
        ['editor_id', null],
        ['user_id', '!=', auth()->user()->id],
      ])
      ->where('name', 'LIKE', '%' . $this->search . '%')
      ->orderBy('id', $this->order_id)
      ->paginate(10);

    return view('livewire.admin.approve-post-index', compact('posts'));
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
}
