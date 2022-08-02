<?php

namespace App\Http\Livewire\Admin;

use App\Models\Post;
use App\Models\User;
use Livewire\Component;

class ShowStatistics extends Component
{
  public $posts, $users, $cant_aut, $cant_edt, $cant_pub, $cant_adm, $cant_lec;

  public function render()
  {
    $this->posts = Post::all();
    $this->users = User::all();
    $this->cant_aut = User::whereHas("roles", function ($q) {
      $q->where("name", "Autor");
    })->get()->count();
    $this->cant_edt = User::whereHas("roles", function ($q) {
      $q->where("name", "Editor");
    })->get()->count();
    $this->cant_pub = User::whereHas("roles", function ($q) {
      $q->where("name", "Publicador");
    })->get()->count();
    $this->cant_adm = User::whereHas("roles", function ($q) {
      $q->where("name", "Admin");
    })->get()->count();
    $this->cant_lec = User::whereHas("roles", function ($q) {
      $q->where("name", "Lector");
    })->get()->count();
    return view('livewire.admin.show-statistics');
  }
}
