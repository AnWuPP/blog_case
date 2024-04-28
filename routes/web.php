<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\WelcomeController;

Route::get('/', [WelcomeController::class, 'index'])->name('welcome');
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('post/{id}', [PostController::class, 'show'])->name('post.show');
    Route::post('post/{id}/comment', [PostController::class, 'comment'])->name('post.comment.create');

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
});

Auth::routes(['verify' => true]);
