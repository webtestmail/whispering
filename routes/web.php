<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\SiteController;
use Illuminate\Support\Facades\Route;


Route::get('/', [SiteController::class, 'index'])->name('home');
Route::get('/about', [SiteController::class, 'about'])->name('about');
Route::get('/the-retreat', [SiteController::class, 'theRetreat'])->name('the.retreat');
Route::get('/accommodation', [SiteController::class, 'accommodation'])->name('accommodation');
Route::get('/accommodation-detail', [SiteController::class, 'accommodationDetail'])->name('accommodation.detail');
Route::get('/location', [SiteController::class, 'location'])->name('location');
Route::get('/gallery', [SiteController::class, 'gallery'])->name('gallery');
Route::get('/experiences', [SiteController::class, 'experiences'])->name('experiences');
Route::get('/experience-detail', [SiteController::class, 'experienceDetail'])->name('experience.detail');
Route::get('/dining', [SiteController::class, 'dining'])->name('dining');
Route::get('/events', [SiteController::class, 'events'])->name('events');
Route::get('/event-detail', [SiteController::class, 'eventDetail'])->name('event.detail');
Route::get('/blog', [SiteController::class, 'blog'])->name('blog');
Route::get('/blog-detail', [SiteController::class, 'blogDetail'])->name('blog.detail');
Route::get('/contact', [SiteController::class, 'contact'])->name('contact');
Route::get('/privacy-policy', [SiteController::class, 'privacyPolicy'])->name('privacy.policy');

Route::post('/contact/submit', [ContactController::class, 'submit'])->name('contact.submit');

require __DIR__.'/admin_web.php';
