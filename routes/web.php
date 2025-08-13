<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\TaskController;

// HOME PAGE ROUTE
// Route::get() is a static method on the Route class (no object needed, use ::)
// Takes 2 parameters: URL path and what to do when someone visits that URL
// return view('welcome') tells Laravel to look for resources/views/welcome.blade.php
Route::get('/', function () {
    return view('welcome');
});

// AUTHENTICATION ROUTES
// GET routes = show forms to users
// POST routes = process form submissions (when user clicks submit button)
// ->name() creates a nickname for the route so we can use route() helper
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register.form');
Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protect all task routes with auth middleware
Route::middleware('auth')->group(function () {
    // Regular task routes
    Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
    Route::get('/tasks/create', [TaskController::class, 'create'])->name('tasks.create');
    Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
    Route::get('/tasks/{task}/edit', [TaskController::class, 'edit'])->name('tasks.edit');
    Route::put('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');
    
    // Soft delete routes (put BEFORE the show route to avoid conflicts)
    Route::get('/tasks/trash', [TaskController::class, 'trash'])->name('tasks.trash');
    Route::patch('/tasks/{id}/restore', [TaskController::class, 'restore'])->name('tasks.restore');
    Route::delete('/tasks/{id}/force-delete', [TaskController::class, 'forceDelete'])->name('tasks.forceDelete');
    
    // Individual task view (optional - only if you want a detailed view)
    Route::get('/tasks/{task}', [TaskController::class, 'show'])->name('tasks.show');
});


// notes learned 
// routes/web.php - central place for all URLs
// resources/views/ - where all Blade templates go