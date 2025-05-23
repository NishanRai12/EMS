<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CategoryUserController;
use App\Http\Controllers\ExpensesController;
use App\Http\Controllers\ForecastController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\MonthlyBudgetController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserRegController;
use Illuminate\Support\Facades\Route;

//Route::view('/', 'profile');
Route::get('/', function () {
    return view('welcome');
});
Route::view('profile', 'profile')
    ->middleware(['auth','access'])
    ->name('profile');
Route::middleware(['access'])->group(function () {
    Route::resource('category',CategoryController::class);
    Route::resource('expenses',ExpensesController::class);
    Route::resource('income',IncomeController::class);
    Route::resource('forecast',ForecastController::class);
    Route::resource('category_user',CategoryUserController::class);

    Route::resource('admin',AdminController::class);
    Route::get('admin-permission', [AdminController::class, 'permission'])->name('admin.permission');
    Route::get('/admin/{month}/{user_id}', [AdminController::class, 'show'])->name('admin.show');
    Route::post('/category/restore/{id}', [CategoryController::class, 'restore'])->name('category.restore');


    Route::get('/display-users', [AdminController::class, 'users'])->name('admin.users');
    Route::resource('role',RoleController::class);
    Route::get('/expenses-show/{id}', [ForecastController::class, 'showExpenses'])->name('forecast.shoeExpenses');
});

Route::middleware(['catRegCheck','auth','access'])->group(function(){
    Route::resource('monthlyBudget',MonthlyBudgetController::class);
});

Route::post('/validate-user', [UserRegController::class, 'validate'])->name('validate.user');
Route::get('/submit-form',[FormController::class, 'finalSubmit'])->name('submit.finalSubmit');
Route::post('/validate-income', [IncomeController::class, 'validate'])->name('validate.income');
Route::post('/validate-cat', [CategoryController::class, 'validate'])->name('validate.cat');
Route::get('/form-cat', [CategoryController::class, 'showFormCat'])->name('category.showFormCat');
Route::post('/store-cat', [CategoryController::class, 'storeFormSession'])->name('category.storeFormSession');
Route::get('/display-formcat', [CategoryController::class, 'newForm'])->name('category.newFormCat');
Route::post('/formcat', [CategoryController::class, 'getDataCat'])->name('category.getDataCat');
Route::post('/sort-expenses',[ExpensesController::class, 'sortExpenses'])->name('expenses.sortExpenses');
Route::get('/show-expenses', [ExpensesController::class, 'show'])->name('expenses.showCatExpenses');
Route::get('/show-search',[ExpensesController::class, 'search'])->name('expenses.search');
Route::post('/search-result',[ExpensesController::class,'search'])->name('expenses.search');







Route::resource('userReg',UserRegController::class);

require __DIR__.'/auth.php';

