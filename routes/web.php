<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::livewire('/', 'pages::welcome')->name('/');
Route::livewire('/login', 'pages::auth.login')->name('auth.login');
Route::livewire('/register', 'pages::auth.register')->name('auth.register');
Route::livewire('/dashboard', 'pages::dashboard')->name('dashboard');

Route::livewire('/products', 'pages::products.index')->name('products.index');
Route::livewire('/products/create', 'pages::products.create')->name('products.create');
Route::livewire('/products/{product}/edit', 'pages::products.edit')->name('products.edit');
Route::livewire('/products/{product}', 'pages::products.show')->name('products.show');


Route::livewire('/cart', 'pages::cart')->name('cart');