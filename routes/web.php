<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ExpensesController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\MonthlyBudgetController;
use App\Http\Controllers\UserRegController;
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
Route::resource('userReg',UserRegController::class);
Route::resource('expenses',ExpensesController::class);
Route::resource('income',IncomeController::class);
Route::post('/validate-user', [UserRegController::class, 'validate'])->name('validate.user');
Route::post('/validate-cat', [CategoryController::class, 'validate'])->name('validate.cat');
Route::post('/store-cat', [CategoryController::class, 'storeFormSession'])->name('category.storeFormSession');
Route::post('/validate-income', [IncomeController::class, 'validate'])->name('validate.income');
Route::get('/form-cat', [CategoryController::class, 'showFormCat'])->name('category.showFormCat');
Route::get('/display-formcat', [CategoryController::class, 'newForm'])->name('category.newFormCat');
Route::post('/formcat', [CategoryController::class, 'getDataCat'])->name('category.getDataCat');



require __DIR__.'/auth.php';

