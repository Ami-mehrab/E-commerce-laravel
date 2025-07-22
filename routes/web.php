<?php

use App\Http\Controllers\Admin\AdminmainController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductAttributeController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductDiscountController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified', 'rolemanager:customer'])->name('dashboard');


//route for admin 

Route::middleware(['auth', 'verified', 'rolemanager:admin'])->group(function () {

    Route::prefix('admin')->group(function () {
        

        Route::controller(AdminmainController::class)->group(function () {


            Route::get('/dashboard', 'index')->name('admin');
            Route::get('/settings', 'settings')->name('admin.settings');
            Route::get('/manage/users', 'manage_users')->name('admin.manage.user');
            Route::get('/manage/store', 'manage_store')->name('admin.manage.store');
            Route::get('/cart/history', 'cart_history')->name('admin.cart.history');
            Route::get('/order/history', 'order_history')->name('admin.order.history');
        });



        Route::controller(CategoryController::class)->group(function () {


            Route::get('/category/create', 'index')->name('category.create');
            Route::get('/category/manage', 'manage')->name('category.manage');
        });

        Route::controller(SubCategoryController::class)->group(function () {


            Route::get('/sub_category/create', 'index')->name('subcategory.create');
            Route::get('/sub_category/manage', 'manage')->name('subcategory.manage');
        });

        Route::controller(ProductController::class)->group(function () {


            Route::get('/product/review/manage', 'review_manage')->name('product.review.manage');
            Route::get('/product/manage', 'manage')->name('product.manage');
        });

        Route::controller(ProductAttributeController::class)->group(function () {


            Route::get('/productattribute/create', 'index')->name('productattribute.create');
            Route::get('/productattribute/manage', 'manage')->name('productattribute.manage');
        });

        Route::controller(ProductDiscountController::class)->group(function () {


            Route::get('/discount/create', 'index')->name('productdiscount.create');
            Route::get('/discount/manage', 'manage')->name('productdiscount.manage');
        });
    });
});




Route::get('vendor/dashboard', function () {
    return view('vendor');
})->middleware(['auth', 'verified', 'rolemanager:vendor'])->name('vendor');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
