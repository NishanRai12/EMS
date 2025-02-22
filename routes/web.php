<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ExpensesController;
use App\Http\Controllers\MonthlyBudgetController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::resource('category',CategoryController::class);
Route::resource('monthlyBudget',MonthlyBudgetController::class);
Route::resource('expenses',ExpensesController::class);
require __DIR__.'/auth.php';
