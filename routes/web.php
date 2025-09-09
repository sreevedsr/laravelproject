<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormController;

Route::get('/', [FormController::class, 'showForm'])->name('form.show');

Route::post('/form', [FormController::class, 'handleForm'])->name('form.handle');
