<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Author\AuthorDashboardController;
use App\Http\Controllers\Author\PostController as AuthorPostController;
use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\Admin\UserController;


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/post/{slug}', [HomeController::class, 'show'])->name('post.show');

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin', [AdminDashboardController::class, 'index'])
        ->name('admin.dashboard');
    Route::get('/admin/posts/index', [AdminPostController::class, 'index'])->name('admin.posts.index');
    Route::patch('/admin/posts/{id}/status', [AdminPostController::class, 'updateStatus'])->name('admin.posts.update-status');
    Route::delete('/admin/posts/{id}', [AdminPostController::class, 'destroy'])->name('admin.posts.destroy');
    Route::get('/posts/{post}', [AdminPostController::class, 'show'])->name('admin.posts.show');
    Route::get('/posts/{post}/edit', [AdminPostController::class, 'edit'])->name('admin.posts.edit');
    Route::patch('/admin/posts/{id}/update', [AdminPostController::class, 'update'])->name('admin.posts.update');


    Route::get('/admin/users/index', [UserController::class, 'index'])->name('admin.users.index');
    Route::patch('/admin/users/{id}/role', [UserController::class, 'updateRole'])->name('admin.users.update-role');
    Route::delete('/admin/users/{id}', [UserController::class, 'destroy'])->name('admin.users.destroy');
});

Route::middleware(['auth', 'role:author'])->group(function () {
    Route::get('/author', [AuthorDashboardController::class, 'index'])->name('author.dashboard');
    // Route::resource('author',AuthorPostController::class);
    Route::get('/author/posts/index', [AuthorPostController::class, 'index'])->name('author.posts.index');
    Route::get('/author/posts/create', [AuthorPostController::class, 'create'])->name('author.posts.create');
    Route::post('/author/posts', [AuthorPostController::class, 'store'])->name('author.posts.store');
    Route::get('/author/posts/{id}/edit', [AuthorPostController::class, 'edit'])->name('author.posts.edit');
    Route::put('/author/posts/{id}', [AuthorPostController::class, 'update'])->name('author.posts.update');
    Route::delete('/author/posts/{id}', [AuthorPostController::class, 'destroy'])->name('author.posts.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
