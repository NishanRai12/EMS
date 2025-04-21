<?php

use App\Http\Controllers\AdminPController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CategoryUserController;
use App\Http\Controllers\ExpensesController;
use App\Http\Controllers\ForecastController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\MonthlyBudgetController;
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
    Route::resource('expenses',ExpensesController::class);
    Route::resource('forecast',ForecastController::class);
    Route::resource('monthlyBudget',MonthlyBudgetController::class);
    Route::resource('role',RoleController::class);
    Route::get('/forecast-expenses/{id}', [ForecastController::class, 'showExpenses'])->name('forecast.shoeExpenses');
    Route::get('/sort-expenses',[ExpensesController::class, 'sortExpenses'])->name('expenses.sortExpenses');
    Route::get('/show-cat-expenses', [ExpensesController::class, 'show'])->name('expenses.showCatExpenses');
    Route::post('/search-result',[ExpensesController::class,'search'])->name('expenses.search');
    Route::get('/force-delete/{id}', [CategoryController::class, 'removeUse'])->name('category.removeUse');
    Route::resource('income',IncomeController::class);
    Route::get('/create-category-percentage', [CategoryController::class, 'createCategoryPercentage'])->name('category.createCategoryPercentage');
    Route::get('/edit-category-percentage/{id}', [CategoryController::class, 'editCategoryPercentage'])->name('category.editCategoryPercentage');
    Route::post('/store-category-percentage', [CategoryController::class, 'storeCategoryPercentage'])->name('category.storeCategoryPercentage');
    Route::put('/store-modified-percentage', [CategoryController::class, 'storeModifiedCategoryPercentage'])->name('category.storeModifiedCategoryPercentage');
    Route::get('/delete-percentage/{id}', [CategoryController::class, 'deleteCategoryPercentage'])->name('category.deleteCategoryPercentage');
});
Route::middleware(['access','auth'])->group(function () {
    Route::get('/admin-dashbord', [AdminPController::class, 'adminDashBoard'])->name('admin.dashbord');
    Route::get('/admin-display-users', [AdminPController::class, 'displayALLusers'])->name('admin.displayALLusers');
    Route::get('/admin-display-categories', [AdminPController::class, 'displayALLCategories'])->name('admin.displayALLCategories');
    Route::get('/admin-display-permission', [AdminPController::class, 'displaypermission'])->name('admin.displayaLLpermission');
    Route::post('/admin-create-permission/{id}', [AdminPController::class, 'createPermission'])->name('admin.createPermission');
    Route::delete('/admin-remove-permission/{id}', [AdminPController::class, 'destroyPermission'])->name('admin.destroyPermission');
    Route::post('/admin-category-restore/{id}', [AdminPController::class, 'restoreCategory'])->name('admin.categoryRestore');
    Route::delete('/admin-category-delete/{id}', [AdminPController::class, 'deleteCategory'])->name('admin.categoryDestroy');

});
Route::resource('registration',RegistrationController::class);
Route::get('/income-registration', [RegistrationController::class, 'showIncomeRegistration'])->name('registration.IncomeRegistration');
Route::post('/income-registration-store', [RegistrationController::class, 'storeIncomeRegistration'])->name('registration.storeIncomeRegistration');
Route::get('/category-registration', [RegistrationController::class, 'showCategoryRegistration'])->name('registration.categoryRegistration');
Route::post('/category-registration-store', [RegistrationController::class, 'storeCategoryRegistration'])->name('registration.storeCategoryRegistration');
Route::post('/percentage-registration-store', [RegistrationController::class, 'storePercentageRegistration'])->name('registration.storePercentageRegistration');
Route::post('/new-category-registration-store', [RegistrationController::class, 'storeNewCatRegistration'])->name('register.storeNewCategory');
Route::get('/percentage-registration', [RegistrationController::class, 'showPercentageRegistration'])->name('registration.percentageRegistration');

//Route::get('/form-cat', [CategoryController::class, 'showFormCat'])->name('category.showFormCat');
Route::get('/admin-create-category', [AdminPController::class, 'createCategory'])->name('admin.createCategory');
Route::post('/admin-store-category', [AdminPController::class, 'storeCategory'])->name('admin.storeCategory');


require __DIR__.'/auth.php';

