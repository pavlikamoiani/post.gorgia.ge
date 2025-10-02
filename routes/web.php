<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FolderController;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ImageController;

Route::middleware(['guest'])->group(function () {
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register.form');
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::get('/', [AuthController::class, 'showLoginForm'])->name('login.form');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
});

Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/dashboard', [FolderController::class, 'index'])->name('dashboard');
    Route::middleware([RoleMiddleware::class . ':editor,admin'])->group(function () {
        Route::get('folders/create', [FolderController::class, 'create'])->name('folders.create');
        Route::get('folders/edit/{folder}', [FolderController::class, 'edit'])->name('folders.edit');
        Route::post('folders', [FolderController::class, 'store'])->name('folders.store');
        Route::put('folders/{folder}', [FolderController::class, 'update'])->name('folders.update');

        Route::get('/images/{folderId}/upload', [ImageController::class, 'create'])->name('images.upload');
        Route::get('/image/{folderId}/{id}', [ImageController::class, 'edit'])->name('images.edit');
        Route::post('/image', [ImageController::class, 'store'])->name('images.store');
        Route::put('images/{id}', [ImageController::class, 'update'])->name('images.update');
    });
    Route::patch('/images/update/{id}', [ImageController::class, 'updateBarcode'])->name('images.barcode');
    Route::patch('folders/{id}', [FolderController::class, 'publishFolder'])->name('folders.publish')->middleware(RoleMiddleware::class . ':admin');
    Route::delete('folders/{id}', [FolderController::class, 'destroy'])->name('folders.destroy')->middleware(RoleMiddleware::class . ':admin');
    Route::get('folders/{id}', [FolderController::class, 'show'])->name('folders.show');

    Route::get('/images/{id}', [ImageController::class, 'show'])->name('images.show');
    Route::delete('/images/{id}', [ImageController::class, 'destroy'])->name('images.destroy')->middleware(RoleMiddleware::class . ':admin');
    Route::post('/{type}/{id}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::get('/{type}/{id}/comments', [CommentController::class, 'index'])->name('comments.index');
});

Route::middleware(['auth', RoleMiddleware::class . ':admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    Route::post('/admin/users/{user}/role', [AdminController::class, 'updateRole'])->name('admin.users.updateRole');
    Route::delete('/admin/users/{user}/delete', [AdminController::class, 'deleteUser'])->name('admin.users.delete');
    Route::patch('/admin/users/{user}/password', [AdminController::class, 'updatePassword'])->name('admin.users.updatePassword');
});
