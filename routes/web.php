<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;


Route::get('/', [PostController::class, 'index'])->name('posts.index');
Route::get('posts/{post}', [PostController::class, 'show'])->name('posts.show');
Route::get('categoria/{categoria}', [PostController::class, 'categoria'])->name('posts.categoria');
Route::get('tag/{tag}', [PostController::class, 'tag'])->name('posts.tag');
Route::get('author/{user}', [PostController::class, 'user'])->name('posts.user');

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
  return view('dashboard');
})->name('dashboard');

// TODO trabajar query para tags y users que queden ordenados
// TODO agregar with a todo where
// TODO activar opcion en el menu mis post
// TODO Trabajar las notificaciones
// TODO agregar bilbiografia al profile del usuario y consulta
// TODO No deberia recargaase la pagina al cambiar de pagina (paginator) cambiar a livewire