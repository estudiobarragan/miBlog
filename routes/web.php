<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;


Route::get('/', [PostController::class, 'index'])->name('posts.index');
Route::get('posts/misposts/{id}', [PostController::class, 'misposts'])->name('posts.misposts');
Route::get('posts/{post}', [PostController::class, 'show'])->name('posts.show');

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
  return view('dashboard');
})->name('dashboard');


// TODO agregar with a todo where
// TODO activar opcion en el menu mis post
// TODO Trabajar las notificaciones
// TODO agregar bilbiografia al profile del usuario y consulta
// TODO No deberia recargaase la pagina al cambiar de pagina (paginator) cambiar a livewire