<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\UserController;
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

Route::get('/', [SiteController::class,'index']);
Route::get('/login', [UserController::class,'login']);
Route::get('/register', [UserController::class,'register'])->name('register');
Route::post('/createUser', [UserController::class, 'createUser'])->name('createUser');
Route::post('/loginAuthentication', [UserController::class,'loginAuthentication']);
Route::get('/posts', [SiteController::class,'posts'])->name('posts');
Route::get('/about', [SiteController::class,'about'])->name('about');
Route::get('/contact', [SiteController::class,'contact'])->name('contact');
Route::get('/postDetails/{slug}', [SiteController::class,'postDetails'])->name('postDetails');
Route::middleware('auth')->group(function () {
    Route::get('/home',[DashboardController::class,'index'])->name('home');
    Route::get('/myprofile',[UserController::class,'myprofile'])->name('myprofile');
    Route::get('/dashboard/createCategory',[DashboardController::class,'createCategory'])->name('createCategory');
    Route::get('/dashboard/createPost',[DashboardController::class,'createPost'])->name('createPost');
    Route::get('/dashboard/editCategory/{id}',[DashboardController::class,'editCategory'])->name('editCategory');
    Route::get('/dashboard/categoryList',[DashboardController::class,'categoryList'])->name('categoryList');
    Route::get('/dashboard/deleteCategory/{id}',[DashboardController::class,'deleteCategory'])->name('deleteCategory');
    Route::post('/dashboard/storeCategory',[DashboardController::class,'storeCategory'])->name('storeCategory');
    Route::post('/dashboard/storePostMedia',[DashboardController::class,'storePostMedia'])->name('storePostMedia');
    Route::post('/dashboard/storePost',[DashboardController::class,'storePost'])->name('storePost');
    Route::get('/dashboard/postList',[DashboardController::class,'listPost'])->name('listPost');
    Route::get('/dashboard/editPost/{id}',[DashboardController::class,'editPost'])->name('editPost');
    Route::get('/dashboard/deletePost/{id}',[DashboardController::class,'deletePost'])->name('deletePost');
    Route::get('/logout', [UserController::class, 'logout'])->name('logout');
});
require __DIR__.'/auth.php';
