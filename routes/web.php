<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataFeedController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ArchiveController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



Route::middleware(['auth:sanctum'])->group(function () {

    Route::get('/', [PostController::class, 'index'])->name('dashboard');
    Route::get('/posts/archive', [PostController::class, 'archive'])->name('posts.archive');

    // Route::resource('archives', ArchiveController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('posts', PostController::class);
    Route::post('/posts/{id}/archive', [PostController::class, 'updateArchive'])->name('posts.updateArchive');

    Route::get('categories/{category}/posts', [CategoryController::class, 'showPostsByCategory'])->name('categories.posts');
});


// Auth::routes([
//     'reset' => true,
// ]);
