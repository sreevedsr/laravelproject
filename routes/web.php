<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormController;
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\AuthController;

Route::middleware(['auth'])->group(function () {
    // Form management
    Route::delete('/form/{id}', [FormController::class, 'delete'])->name('form.delete');
    Route::get('/forms', [FormController::class, 'showForm'])->name('forms.index');
    Route::get('/forms/search', [FormController::class, 'search'])->name('forms.search');

    // Designation management
    Route::get('/admin/designations', [DesignationController::class, 'index'])->name('designations.index');
    Route::post('/admin/designations', [DesignationController::class, 'store'])->name('designations.store');
    Route::delete('/admin/designations/{id}', [DesignationController::class, 'destroy'])->name('designations.destroy');
    Route::get('/designations/create', [DesignationController::class, 'create'])->name('designations.create');

    // Logout
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
});
Route::get('/form', [FormController::class, 'showForm'])->name('form.show');

Route::post('/form', [FormController::class, 'handleForm'])->name('form.handle');

Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register.form');
Route::post('register', [AuthController::class, 'register'])->name('register');

Route::get('/', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::get('login', [AuthController::class, 'showLoginForm']);

Route::post('login', [AuthController::class, 'login'])->name('login');
