<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\admin\SupplierController;
use App\Http\Controllers\admin\CustomerController;
use App\Http\Controllers\admin\BillingController;
use App\Http\Controllers\admin\PurchaseController;
use App\Http\Controllers\admin\PayableController;
use App\Http\Controllers\admin\EmiController;
use App\Http\Controllers\admin\ExpensesController;
use App\Http\Controllers\admin\EmployeeController;
use Carbon\Carbon;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard',[CustomerController::class,'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth','verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('categories', CategoryController::class);
    Route::get('category/export/{type?}', [CategoryController::class, 'export'])->name('categories.export');

    Route::resource('/products', ProductController::class);
    Route::get('product/export/{type?}', [ProductController::class, 'export'])->name('products.export');

    Route::resource('/suppliers', SupplierController::class);
    Route::get('supplier/export/{type?}', [SupplierController::class, 'export'])->name('suppliers.export');

    Route::resource('/customers', CustomerController::class);
    Route::get('customer/export/{type?}', [CustomerController::class, 'export'])->name('customers.export');

    Route::resource('/billings', BillingController::class);
    Route::get('billing/export/{type?}', [BillingController::class, 'export'])->name('billings.export');
     Route::get('/billings/{invoice}/download', [BillingController::class, 'download'])->name('billings.download');

    Route::resource('/expenses', ExpensesController::class);
    Route::get('expense/export/{type?}', [ExpensesController::class, 'export'])->name('expenses.export');

    Route::resource('/purchases', PurchaseController::class);
    Route::get('/purchases/{invoice}/download', [PurchaseController::class, 'download'])->name('purchases.download');
    Route::get('purchase/export/{type?}', [PurchaseController::class, 'export'])->name('purchases.export');


    Route::resource('/paybles', PayableController::class);
    Route::get('payble/export/{type?}', [PayableController::class, 'export'])->name('paybles.export');


    Route::get('check/log/{id}', [PayableController::class,'log'])->name('paybles.check.log');
    Route::resource('/emis', EmiController::class);
    Route::get('emis/create/{id}', [EmiController::class,'create'])->name('emi.create');
    Route::get('emi/export/{type?}', [EmiController::class, 'export'])->name('emis.export');

    Route::resource('employees', EmployeeController::class);
    Route::get('employees/export/{type?}', [EmployeeController::class, 'export'])->name('employees.export');
     Route::post('employees/show/store', [EmployeeController::class, 'showStore'])->name('employees.show.store');
      Route::delete('employees/show/delete/{id}', [EmployeeController::class, 'showDelete'])->name('employees.show.destroy');

});



require __DIR__.'/auth.php';
