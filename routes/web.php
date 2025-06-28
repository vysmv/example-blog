<?php

use App\Http\Controllers\Admin\MainController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\TagController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::prefix('/admin')->middleware('admin')->group(function(){
    Route::get('/', [MainController::class, 'index'])->name('dashboard');
    
    Route::resource('/categories', CategoryController::class)->names([
        'index'   => 'admin.categories.index',
        'store'   => 'admin.categories.store',
        'create'  => 'admin.categories.create',
        'show'    => 'admin.categories.show',
        'update'  => 'admin.categories.update',
        'destroy' => 'admin.categories.destroy',
        'edit'    => 'admin.categories.edit'
    ]);
    
    Route::get('/posts/trash', [PostController::class, 'trashIndex'])->name('admin.posts.trash');
    Route::get('/posts/trash/{post}/restore', [PostController::class, 'trashRestore'])->name('admin.posts.trash.restore');
    Route::delete('/posts/trash/{post}/remove', [PostController::class, 'trashRemove'])->name('admin.posts.trash.remove');

    Route::resource('/posts', PostController::class)->names([
        'index'   => 'admin.posts.index',
        'store'   => 'admin.posts.store',
        'create'  => 'admin.posts.create',
        'show'    => 'admin.posts.show',
        'update'  => 'admin.posts.update',
        'destroy' => 'admin.posts.destroy',
        'edit'    => 'admin.posts.edit'
    ]);

    
    Route::resource('/tags', TagController::class)->names([
        'index'   => 'admin.tags.index',
        'store'   => 'admin.tags.store',
        'create'  => 'admin.tags.create',
        'show'    => 'admin.tags.show',
        'update'  => 'admin.tags.update',
        'destroy' => 'admin.tags.destroy',
        'edit'    => 'admin.tags.edit'
    ]);
});

Route::middleware('guest')->group(function(){
    Route::get('/login', [UserController::class, 'login'])->name('login');
    Route::post('/login', [UserController::class, 'authenticate'])->name('login.authenticate');
});

Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});