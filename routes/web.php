<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;


Route::get('/', [PostController::class, 'index'])->name('posts.index');
Route::get('posts/{post}', [PostController::class, 'show'])->name('posts.show');


Route::middleware(['auth:sanctum', 'verified'])->group(function () {
  Route::get('/dashboard', function () {
    return view('dashboard');
  })->name('dashboard');

  Route::get('posts/misposts/{id}', [PostController::class, 'misposts'])->name('posts.misposts');
});

// FEACTURE
// TODO Agregar Crud comentarios
// TODO Backup
// TODO Agregar estadisticas de reacciones, de entrada a leerlo (por autor, etq y cat)
// TODO duallist box boostrap
// TODO Insert chunk para seedear post
// TODO Notificaciones de like, guardados, etc.
// TODO Testing

// ERRORS
// TODO ver si el faill de queue es porque quiere avisar de un post programado que ya vario a publicado.
// TODO Ver si es posible programar tareas a realizar (como ejemplo publicar calendario)
// TODO Corregir que no me permita reaccionar a mis propios post
// TODO Ver porque coloca dos veces una misma notificacion 