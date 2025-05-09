<?php

use App\Livewire\Orders\OrderList;
use App\Livewire\Product\CreateProduct;
use App\Livewire\Product\EditProduct;
use App\Livewire\Product\ShowProducts;
use App\Livewire\Users\ShowUsers;
use App\Livewire\Users\CreateUser;
use App\Livewire\Users\EditUser;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Livewire\Auth\TenantRegister;

// Route::get('/', function () {
//     return view('welcome');
// })->name('home');

Route::get('tenant/register', TenantRegister::class)
    ->name('tenant.register');


foreach (config('tenancy.central_domains') as $domain) {

    Route::domain($domain)->group(function () {
        Route::get('/', function () {
            return view('welcome');
        })->name('home');

        // Route::view('dashboard', 'dashboard')
        //     ->middleware(['auth', 'verified'])
        //     ->name('dashboard');

        // Route::middleware(['auth'])->group(function () {
        //     Route::redirect('settings', 'settings/profile');

        //     Route::get('settings/profile', Profile::class)->name('settings.profile');
        //     Route::get('settings/password', Password::class)->name('settings.password');
        //     Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
        // });
    });
}

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');
    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
    Route::get('/users', ShowUsers::class)->name('users.index');
    Route::get('/users/create', CreateUser::class)->name('users.create');
    Route::get('/users/{user}/edit', EditUser::class)->name('users.edit');

    // Role routes
    Route::get('/roles', \App\Livewire\Roles\ShowRoles::class)->name('roles.index');
    Route::get('/roles/create', \App\Livewire\Roles\CreateRole::class)->name('roles.create');
    Route::get('/roles/{role}/edit', \App\Livewire\Roles\EditRole::class)->name('roles.edit');
    
    // Category routes
    Route::get('/categories', \App\Livewire\Categories\ShowCategory::class)->name('categories.index');
    Route::get('/categories/create', \App\Livewire\Categories\CreateCategory::class)->name('categories.create');
    Route::get('/categories/{category}/edit', \App\Livewire\Categories\EditCategory::class)->name('categories.edit');

    Route::get('/products', ShowProducts::class)->name('products.index');
    Route::get('/products/create', CreateProduct::class)->name('products.create');
    Route::get('/products/{product}/edit', EditProduct::class)->name('products.edit');

    Route::get('/order-list', OrderList::class)->name('orders.index');

});

require __DIR__.'/auth.php';
