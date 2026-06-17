<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Публичные страницы
Route::get('/', fn() => Inertia::render('Home'));
Route::get('/directions', fn() => Inertia::render('DirectionsView'));
Route::get('/events', fn() => Inertia::render('EventsView'));
Route::get('/about', fn() => Inertia::render('AboutView'));
Route::get('/contacts', fn() => Inertia::render('ContactsView'));

// Редирект для стандартного маршрута логина (нужен для middleware 'auth')
Route::get('/login', function () {
    return redirect('/admin');
})->name('login');

// Админка
Route::get('/admin', [AdminController::class, 'login'])->name('admin.login');
Route::post('/admin', [AdminController::class, 'authenticate']);
Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->middleware('auth');
Route::post('/admin/logout', [AdminController::class, 'logout']);
