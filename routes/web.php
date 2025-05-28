<?php

use App\Http\Controllers\FormController;
use App\Http\Controllers\FormFieldController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\UserFormDataController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    // Form management routes
    Route::resource('forms', FormController::class);
    
    // Form field routes
    Route::prefix('forms/{form}')->group(function () {
        Route::resource('fields', FormFieldController::class)
            ->except(['index', 'show'])
            ->names([
                'create' => 'forms.fields.create',
                'store' => 'forms.fields.store',
                'edit' => 'forms.fields.edit',
                'update' => 'forms.fields.update',
                'destroy' => 'forms.fields.destroy',
            ]);
    });
    Route::get('/forms/{form}/display', [FormController::class, 'display'])->name('forms.display');
    Route::post('/forms/{form}/submit', [FormController::class, 'submit'])->name('forms.submit');
    // User form data editing routes
Route::get('/user-form-data/{userFormData}/edit', [UserFormDataController::class, 'edit'])->name('user-form-data.edit');
Route::put('/user-form-data/{userFormData}', [UserFormDataController::class, 'update'])->name('user-form-data.update');
});

// Registration routes
Route::get('/register/{countryCode}', [RegistrationController::class, 'showRegistrationForm'])
    ->name('registration.form');
Route::post('/register/{countryCode}', [RegistrationController::class, 'submitRegistrationForm'])
    ->name('registration.submit')
    ->middleware('auth');

// Authentication routes
Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/', function () {
    return view('welcome');
});
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
