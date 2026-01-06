<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JobApplicationController;
use App\Http\Controllers\JobCategoryController;
use App\Http\Controllers\JobVacancyController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/companies', [CompanyController::class, 'index'])->middleware(['auth', 'verified'])->name('companies');
Route::get('/job-categories', [JobCategoryController::class, 'index'])->middleware(['auth', 'verified'])->name('job-categories');
Route::get('/job-vacancies', [JobVacancyController::class, 'index'])->middleware(['auth', 'verified'])->name('job-vacancies');  
Route::get('/job-applications', [JobApplicationController::class, 'index'])->middleware(['auth', 'verified'])->name('job-applications');
Route::get('/users', [UserController::class, 'index'])->middleware(['auth', 'verified'])->name('users');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
