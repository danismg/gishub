<?php

use App\Http\Controllers\FrontController;
use Illuminate\Support\Facades\Route;

// home
Route::get('/', [FrontController::class, 'index'])->name('front.index');
// front galery
Route::get('/gallery', [FrontController::class, 'gallery'])->name('front.gallery');
// contact, ouer team, about us, photo
Route::get('/ourTeam', [FrontController::class, 'ourTeam'])->name('front.ourTeam');
Route::get('/services', [FrontController::class, 'services'])->name('front.services');
Route::get('/aboutUs', [FrontController::class, 'aboutUs'])->name('front.aboutUs');
Route::get('/contact', [FrontController::class, 'contact'])->name('front.contact');
// Route::get('/photo', [FrontController::class, 'photo'])->name('photo');

Route::get('/galeri/{galeri:slug}', [FrontController::class, 'photo'])->name('front.photo');

// inbox
Route::post('/inbox', [FrontController::class, 'inbox'])->name('front.inbox');

// client
Route::get('/client', [FrontController::class, 'client'])->name('front.client');


// logout
Route::post('/logout', [FrontController::class, 'logout'])->name('front.logout');
