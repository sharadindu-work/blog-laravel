<?php

use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserCommentController;
use App\Http\Controllers\UserPostController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

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

Route::get('/clear-all', function() {
    Artisan::call('config:cache');
    Artisan::call('cache:clear');
    Artisan::call('view:clear');
    return 'All cache cleared';
});

//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('/',[HomeController::class,'index'])->name('home');
Route::get('article/{post}',[HomeController::class,'details'])->name('post.details');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::resource('users', UserController::class);
    Route::resource('posts', PostController::class);
});

Route::middleware('auth')->group(function () {
    Route::get('my-post', [UserPostController::class, 'index'])->name('user.my-post');
    Route::get('my-post-create', [UserPostController::class, 'create'])->name('user.my-post.create');
    Route::post('my-post-store', [UserPostController::class, 'store'])->name('user.my-post.store');
    Route::get('my-post/{post}/edit', [UserPostController::class, 'edit'])->name('user.my-post.edit');
    Route::post('my-post/{post}/update', [UserPostController::class, 'update'])->name('user.my-post.update');
    Route::post('my-post/{post}/delete', [UserPostController::class, 'destroy'])->name('user.my-post.destroy');
    Route::post('comment-store/{post}', [UserCommentController::class, 'store'])->name('user.comment.store');

});

require __DIR__.'/auth.php';
