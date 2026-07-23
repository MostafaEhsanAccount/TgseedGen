<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\LeadActivityController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\LeadReminderController;
use App\Http\Controllers\MarketingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TagController;
use Illuminate\Support\Facades\Route;

Route::get('/', [MarketingController::class, 'home'])->name('marketing.home');
Route::get('/features', [MarketingController::class, 'features'])->name('marketing.features');
Route::get('/pricing', [MarketingController::class, 'pricing'])->name('marketing.pricing');
Route::get('/contact', [MarketingController::class, 'contact'])->name('marketing.contact');
Route::post('/contact', [MarketingController::class, 'submitContact'])->name('marketing.contact.submit');
Route::get('/terms', [MarketingController::class, 'terms'])->name('marketing.terms');
Route::get('/privacy', [MarketingController::class, 'privacy'])->name('marketing.privacy');
Route::get('/cookie-policy', [MarketingController::class, 'cookiePolicy'])->name('marketing.cookiePolicy');
Route::get('/blog', [BlogController::class, 'index'])->name('marketing.blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('marketing.blog.show');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/leads/board', [LeadController::class, 'board'])->name('leads.board');
    Route::post('/leads/{lead}/notes', [LeadActivityController::class, 'store'])->name('leads.notes.store');
    Route::post('/leads/{lead}/reminders', [LeadReminderController::class, 'store'])->name('leads.reminders.store');
    Route::patch('/reminders/{reminder}/done', [LeadReminderController::class, 'markDone'])->name('reminders.markDone');
    Route::resource('leads', LeadController::class);

    Route::get('/tags', [TagController::class, 'index'])->name('tags.index');
    Route::post('/tags', [TagController::class, 'store'])->name('tags.store');
});

Route::middleware(['auth', 'super-admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
});

require __DIR__.'/auth.php';
