<?php


use App\Http\Controllers\Admin\ApproveController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::get('', [HomeController::class, 'index'])->name('admin.home')->middleware('can:admin.home');

Route::resource('users', UserController::class)->names('admin.users')->only(['index', 'edit', 'update']);

Route::resource('roles', RoleController::class)->names('admin.roles')->except('show');

Route::resource('categories', CategoryController::class)->names('admin.categories')->except('show');

Route::resource('tags', TagController::class)->names('admin.tags')->except('show');

Route::resource('posts', PostController::class)->names('admin.posts')->except('show');

Route::resource('approves', ApproveController::class)->names('admin.approves');

Route::post('approves/reject', [ApproveController::class, 'reject'])->name('admin.approves.reject');
