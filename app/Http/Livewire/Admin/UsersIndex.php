<?php

namespace App\Http\Livewire\Admin;

use App\Models\User;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

class UsersIndex extends Component
{
  use WithPagination;

  public $search, $order_id;

  protected $paginationTheme = "bootstrap";

  public function mount()
  {
    $this->order_id = Session::get('order_id', "desc");
  }

  public function render()
  {

    $users = User::where('name', 'LIKE', '%' . $this->search . '%')
      ->orWhere('email', 'LIKE', '%' . $this->search . '%')
      ->orderBy('id', $this->order_id)
      ->paginate();

    $roles = Role::all();

    return view('livewire.admin.users-index', compact('users', 'roles'));
  }

  public function updatingSearch()
  {
    $this->resetPage();
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
