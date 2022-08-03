<?php

namespace App\Http\Livewire\Admin;

use App\Models\Categoria;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Livewire\Component;

class ShowStatistics extends Component
{
  public $posts, $users, $cant_aut, $cant_edt, $cant_pub, $cant_adm, $cant_lec;
  public $dataEtq, $dataCat;
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

    /* Etiquetas mas usadas */
    $data = [];
    $etiquetas = Tag::all();
    $etqs = $etiquetas->map(function ($etiqueta, $key) {
      $data['label'][] = $etiqueta->name;
      return $etiqueta->name;
    });

    $etqPost = $etiquetas->map(function ($etiqueta, $key) {
      $data['data'][] = $etiqueta->posts->count();
      return $etiqueta->posts->count();
    });
    foreach ($etqs as $etq) {
      $data['label'][] = $etq;
    }
    foreach ($etqPost as $etq) {
      $data['data'][] = (int) $etq;
    }
    $this->dataEtq = $data;

    /* Categorias mas usadas */
    $data = [];
    $categorias = Categoria::all();
    $this->cat = $categorias->map(function ($categoria, $key) {
      $data['label'][] = $categoria->name;
      return $categoria->name;
    });
    $this->catPost = $categorias->map(function ($categoria, $key) {
      $data['data'][] = $categoria->posts->count();
      return $categoria->posts->count();
    });
    foreach ($this->cat as $cat) {
      $data['label'][] = $cat;
    }
    foreach ($this->catPost as $cat) {
      $data['data'][] = (int) $cat;
    }
    $this->dataCat = $data;

    return view('livewire.admin.show-statistics');
  }
}
