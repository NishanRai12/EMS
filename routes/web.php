<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminPController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CategoryUserController;
use App\Http\Controllers\ExpensesController;
use App\Http\Controllers\ForecastController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\MonthlyBudgetController;
use App\Http\Controllers\PercentageController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RegistrationController;
use Illuminate\Support\Facades\Route;

//Route::view('/', 'profile');
Route::get('/', function () {
    return view('welcome');
});
Route::view('profile', 'profile')
    ->middleware(['auth','access'])
    ->name('profile');
Route::middleware(['access','catRegCheck','auth'])->group(function () {
    Route::resource('category',CategoryController::class);
    Route::resource('percentage',PercentageController::class);
    Route::resource('expenses',ExpensesController::class);
    Route::resource('forecast',ForecastController::class);
    Route::resource('monthlyBudget',MonthlyBudgetController::class);
    Route::post('/category/restore/{id}', [CategoryController::class, 'restore'])->name('category.restore');
    Route::resource('role',RoleController::class);
    Route::get('/expenses-show/{id}', [ForecastController::class, 'showExpenses'])->name('forecast.shoeExpenses');
    Route::get('/sort-expenses',[ExpensesController::class, 'sortExpenses'])->name('expenses.sortExpenses');
    Route::get('/show-expenses', [ExpensesController::class, 'show'])->name('expenses.showCatExpenses');
    Route::post('/search-result',[ExpensesController::class,'search'])->name('expenses.search');
    Route::get('/force-delete/{id}', [CategoryController::class, 'removeUse'])->name('category.removeUse');
});

Route::resource('category_user',CategoryUserController::class);
Route::get('/submit-form',[FormController::class, 'finalSubmit'])->name('submit.finalSubmit');
Route::post('/validate-cat', [CategoryController::class, 'validate'])->name('validate.cat');
Route::post('/store-cat', [CategoryController::class, 'storeFormSession'])->name('category.storeFormSession');
Route::get('/display-formcat', [CategoryController::class, 'newForm'])->name('category.newFormCat');
Route::post('/formcat', [CategoryController::class, 'getDataCat'])->name('category.getDataCat');
Route::resource('income',IncomeController::class);

Route::resource('registration',RegistrationController::class);
Route::get('/income-registration', [RegistrationController::class, 'showIncomeRegistration'])->name('registration.IncomeRegistration');
Route::post('/income-registration-store', [RegistrationController::class, 'storeIncomeRegistration'])->name('registration.storeIncomeRegistration');
Route::get('/category-registration', [RegistrationController::class, 'showCategoryRegistration'])->name('registration.categoryRegistration');
Route::post('/category-registration-store', [RegistrationController::class, 'storeCategoryRegistration'])->name('registration.storeCategoryRegistration');
Route::post('/percentage-registration-store', [RegistrationController::class, 'storePercentageRegistration'])->name('registration.storePercentageRegistration');
Route::post('/new-category-registration-store', [RegistrationController::class, 'storeNewCatRegistration'])->name('register.storeNewCategory');
Route::get('/percentage-registration', [RegistrationController::class, 'showPercentageRegistration'])->name('registration.percentageRegistration');

Route::get('/form-cat', [CategoryController::class, 'showFormCat'])->name('category.showFormCat');
Route::resource('registration',RegistrationController::class);


Route::get('/admin-dashbord', [AdminPController::class, 'adminDashBoard'])->name('admin.dashbord');
Route::get('/admin-display-users', [AdminPController::class, 'displayALLusers'])->name('admin.displayALLusers');
Route::get('/admin-display-categories', [AdminPController::class, 'displayALLCategories'])->name('admin.displayALLCategories');
Route::get('/admin-display-permission', [AdminPController::class, 'displaypermission'])->name('admin.displayaLLpermission');
Route::post('/admin-create-permission/{id}', [AdminPController::class, 'createPermission'])->name('admin.createPermission');
Route::delete('/admin-remove-permission/{id}', [AdminPController::class, 'destroyPermission'])->name('admin.destroyPermission');



require __DIR__.'/auth.php';

