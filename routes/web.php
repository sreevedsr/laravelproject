<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormController;

Route::get('/', [FormController::class, 'showForm'])->name('form.show');

Route::post('/form', [FormController::class, 'handleForm'])->name('form.handle');

Route::delete('/form/{id}', [FormController::class, 'delete'])->name('form.delete');

Route::get('/forms', [FormController::class, 'showForm'])->name('forms.index');
Route::get('/forms/search', [FormController::class, 'search'])->name('forms.search');

