<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;


Route::get('/', [PostController::class, 'index'])->name('posts.index');
Route::get('posts/misposts/{id}', [PostController::class, 'misposts'])->name('posts.misposts');
Route::get('posts/{post}', [PostController::class, 'show'])->name('posts.show');

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
  return view('dashboard');
})->name('dashboard');


// TODO Agregar Crud comentarios
// TODO Backup
// TODO Agregar estadisticas de reacciones, de entrada a leerlo (por autor, etq y cat)
// TODO duallist box boostrap
