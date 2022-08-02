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
// TODO Agregar Crud comentarios
// TODO Adelanto (post programados para salir-solo extracto)
// TODO estadisticas
// TODO Barra de serche
// TODO Backup