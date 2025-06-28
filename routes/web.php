<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');

    //products routes
    Route::get('/products', App\Livewire\Products\Index::class)->name('products.index');
    Route::get('/products/create', App\Livewire\Products\Create::class)->name('products.create');
    Route::get('/products/{product}/edit', App\Livewire\Products\Edit::class)->name('products.edit');

    // Sales routes
    Route::get('/sales', App\Livewire\Sales\Index::class)->name('sales.index');
    Route::get('/sales/create', App\Livewire\Sales\Create::class)->name('sales.create');
    Route::get('/sales/{sale}', App\Livewire\Sales\Show::class)->name('sales.show');
    Route::get('/sales/{sale}/edit', App\Livewire\Sales\Edit::class)->name('sales.edit');
    
    // PDF route
    Route::get('/sales/{sale}/pdf', [App\Http\Controllers\SalePdfController::class, 'generatePdf'])->name('sales.pdf');
});

require __DIR__.'/auth.php';
