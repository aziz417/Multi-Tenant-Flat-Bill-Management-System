<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\HouseOwnerController;
use App\Http\Controllers\Admin\TenantController as AdminTenantController;
use App\Http\Controllers\HouseOwner\DashboardController as HouseOwnerDashboardController;
use App\Http\Controllers\HouseOwner\BuildingController;
use App\Http\Controllers\HouseOwner\FlatController;
use App\Http\Controllers\HouseOwner\BillCategoryController;
use App\Http\Controllers\HouseOwner\BillController;
use App\Http\Controllers\HouseOwner\TenantController as HouseOwnerTenantController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::resource('house-owners', HouseOwnerController::class);
    Route::resource('tenants', AdminTenantController::class);

    // AJAX route for getting flats by building
    Route::get('/buildings/{building}/flats', [AdminTenantController::class, 'getFlats'])
        ->name('buildings.flats');
});

// House Owner Routes
Route::middleware(['auth', 'house_owner', 'house_owner_context'])
    ->prefix('house-owner')
    ->name('house-owner.')
    ->group(function () {
        Route::get('/dashboard', [HouseOwnerDashboardController::class, 'index'])->name('dashboard');

        Route::resource('buildings', BuildingController::class);
        Route::resource('flats', FlatController::class);
        Route::resource('bill-categories', BillCategoryController::class)->except(['show']);
        Route::resource('bills', BillController::class);

        // Bill payment route
        Route::post('/bills/{bill}/mark-as-paid', [BillController::class, 'markAsPaid'])
            ->name('bills.mark-as-paid');
    });