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
    ->middleware(['auth'])
    ->name('profile');

Route::resource('category',CategoryController::class)->middleware('adminCheck');;
Route::resource('userReg',UserRegController::class);
Route::resource('expenses',ExpensesController::class);
Route::resource('income',IncomeController::class);
Route::post('/validate-user', [UserRegController::class, 'validate'])->name('validate.user');

Route::get('/submit-form',[FormController::class, 'finalSubmit'])->name('submit.finalSubmit');

Route::get('/form-cat', [CategoryController::class, 'showFormCat'])->name('category.showFormCat');
Route::post('/validate-cat', [CategoryController::class, 'validate'])->name('validate.cat');
Route::post('/store-cat', [CategoryController::class, 'storeFormSession'])->name('category.storeFormSession');
Route::post('/validate-income', [IncomeController::class, 'validate'])->name('validate.income');
Route::get('/display-formcat', [CategoryController::class, 'newForm'])->name('category.newFormCat');
Route::post('/formcat', [CategoryController::class, 'getDataCat'])->name('category.getDataCat');
Route::resource('forecast',ForecastController::class);
Route::resource('category_user',CategoryUserController::class);
Route::resource('admin',AdminController::class)->middleware('adminCheck');
Route::get('admin-permission', [AdminController::class, 'permission'])->name('admin.permission');

Route::get('/display-users', [AdminController::class, 'users'])->name('admin.users');
Route::resource('role',RoleController::class);
//Route::resource()

//dispaly the expenses of today
Route::get('/today-expenses', [ExpensesController::class, 'today'])->name('expenses.today');
Route::get('/yesterday-expenses', [ExpensesController::class, 'yesterday'])->name('expenses.yesterday');
Route::get('/today-show/{id}', [ExpensesController::class, 'todayShow'])->name('expenses.todayShow');
Route::get('/yesterday-show/{id}', [ExpensesController::class, 'yesterdayShow'])->name('expenses.yesterdayShow');
Route::get('/expenses-show/{id}', [ForecastController::class, 'showExpenses'])->name('forecast.shoeExpenses');
Route::middleware('catRegCheck','auth')->group(function(){
Route::resource('monthlyBudget',MonthlyBudgetController::class);
});

require __DIR__.'/auth.php';

