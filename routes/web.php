<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormController;
use App\Http\Controllers\DesignationController;

Route::get('/', [FormController::class, 'showForm'])->name('form.show');

Route::post('/form', [FormController::class, 'handleForm'])->name('form.handle');

Route::delete('/form/{id}', [FormController::class, 'delete'])->name('form.delete');

Route::get('/forms', [FormController::class, 'showForm'])->name('forms.index');

Route::get('/forms/search', [FormController::class, 'search'])->name('forms.search');

// Show add designation form + list designations
Route::get('/admin/designations', [DesignationController::class, 'index'])->name('designations.index');

// Store new designation
Route::post('/admin/designations', [DesignationController::class, 'store'])->name('designations.store');

// Delete designation
Route::delete('/admin/designations/{id}', [DesignationController::class, 'destroy'])->name('designations.destroy');

