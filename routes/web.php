<?php

use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\InventoryAdjustmentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\UserController;
use App\Utils\Customer;
use App\Utils\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes();

//logged in users
Route::middleware(['auth'])->group(function () {
    Route::get('/', function () {
        return redirect()->route('home');
    });
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    //customers
    Route::get('/customer/create',[CustomerController::class,'create'])->name('customer.create');
    Route::post('/customer/create',[CustomerController::class,'store'])->name('customer.store');
    Route::get('/customer/index',[CustomerController::class,'index'])->name('customer.index');
    Route::get('/customer/{id}/delete',[CustomerController::class,'destroy'])->name('customer.delete');
    Route::get('/customer/{id}/edit',[CustomerController::class,'edit'])->name('customer.edit');
    Route::put('/customer/{id}/update',[CustomerController::class,'update'])->name('customer.update');
    Route::get('/customer/{id}/view',[CustomerController::class,'show'])->name('customer.view');
    Route::get('/customer/{identificacion}/get',[Customer::class,'getCustomerByID']);

    //product
    Route::get('/product/index',[ProductController::class,'index'])->name('product.index');
    Route::get('/product/{id}/view',[ProductController::class,'show'])->name('product.view');
    Route::get('/product/{code}/get',[Product::class,'getProductByCode']);

    //provider
    Route::get('/provider/index',[ProviderController::class,'index'])->name('provider.index');
    Route::get('/provider/{id}/view',[ProviderController::class,'show'])->name('provider.view');

    //sales
    Route::get('/sale/create',[SaleController::class,'create'])->name('sale.create');
    Route::post('/sale/create',[SaleController::class,'store'])->name('sale.store');
    Route::get('/sale/index',[SaleController::class,'index'])->name('sale.index');
    Route::get('/sale/{id}/view',[SaleController::class,'show'])->name('sale.view');
});

//users logged in with administrator role
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/', function () {
        return redirect()->route('admin');
    });
    Route::get('/admin', [App\Http\Controllers\AdminController::class, 'index'])->name('admin');
    //users
    Route::get('/user/create',[UserController::class,'create'])->name('user.create');
    Route::post('/user/create',[UserController::class,'store'])->name('user.store');
    Route::get('/user/index',[UserController::class,'index'])->name('user.index');
    Route::get('/user/{id}/delete',[UserController::class,'destroy'])->name('user.delete');
    Route::get('/user/{id}/edit',[UserController::class,'edit'])->name('user.edit');
    Route::put('/user/{id}/update',[UserController::class,'update'])->name('user.update');
    Route::put('/user/{id}/status',[UserController::class,'updateStatus'])->name('user.status');
    Route::get('/user/{id}/view',[UserController::class,'show'])->name('user.view');

    //categories
    Route::get('/category/create',[CategoryController::class,'create'])->name('category.create');
    Route::post('/category/create',[CategoryController::class,'store'])->name('category.store');
    Route::get('/category/index',[CategoryController::class,'index'])->name('category.index');
    Route::get('/category/{id}/delete',[CategoryController::class,'destroy'])->name('category.delete');
    Route::get('/category/{id}/edit',[CategoryController::class,'edit'])->name('category.edit');
    Route::put('/category/{id}/update',[CategoryController::class,'update'])->name('category.update');

    //brands
    Route::get('/brand/create',[BrandController::class,'create'])->name('brand.create');
    Route::post('/brand/create',[BrandController::class,'store'])->name('brand.store');
    Route::get('/brand/index',[BrandController::class,'index'])->name('brand.index');
    Route::get('/brand/{id}/delete',[BrandController::class,'destroy'])->name('brand.delete');
    Route::get('/brand/{id}/edit',[BrandController::class,'edit'])->name('brand.edit');
    Route::put('/brand/{id}/update',[BrandController::class,'update'])->name('brand.update');

    //products
    Route::get('/product/create',[ProductController::class,'create'])->name('product.create');
    Route::post('/product/create',[ProductController::class,'store'])->name('product.store');
    Route::get('/product/{id}/delete',[ProductController::class,'destroy'])->name('product.delete');
    Route::get('/product/{id}/edit',[ProductController::class,'edit'])->name('product.edit');
    Route::put('/product/{id}/update',[ProductController::class,'update'])->name('product.update');
    Route::put('/product/modal',[ProductController::class,'startStock'])->name('product.stock');

    //providers
    Route::get('/provider/create',[ProviderController::class,'create'])->name('provider.create');
    Route::post('/provider/create',[ProviderController::class,'store'])->name('provider.store');
    Route::get('/provider/{id}/delete',[ProviderController::class,'destroy'])->name('provider.delete');
    Route::get('/provider/{id}/edit',[ProviderController::class,'edit'])->name('provider.edit');
    Route::put('/provider/{id}/update',[ProviderController::class,'update'])->name('provider.update');   
    
    //sales
    Route::get('/sale/{id}/cancel',[SaleController::class,'cancelSale'])->name('sale.cancel');

    //Inventory_adjustments
    Route::get('adjustment/index',[InventoryAdjustmentController::class,'index'])->name('adjustment.index');
    Route::get('adjustment/create',[InventoryAdjustmentController::class,'create'])->name('adjustment.create');
    Route::post('adjustment/create',[InventoryAdjustmentController::class,'store'])->name('adjustment.store');
    Route::get('adjustment/{id}/view',[InventoryAdjustmentController::class,'show'])->name('adjustment.show');
});


