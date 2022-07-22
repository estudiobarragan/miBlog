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

Route::get('seguir/{model}/{obj}', [PostController::class, 'seguir'])
  ->name('posts.seguir')
  ->middleware(['auth:sanctum', 'verified']);
Route::get('noseguir/{model}/{obj}', [PostController::class, 'noseguir'])
  ->name('posts.noseguir')
  ->middleware(['auth:sanctum', 'verified']);
