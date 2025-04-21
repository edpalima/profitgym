<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\MembershipCheckoutController;
use App\Http\Controllers\MembershipController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\TrainerController;
use App\Http\Controllers\WorkoutGuideController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.home');
})->name('home');

// Route::get('/workout-guide/{id}', WorkoutGuideDetails::class)->name('workout-guide.details');
Route::get('/workout-guide/{id}', action: [WorkoutGuideController::class, 'show'])->name('workout-guide.show');
Route::get('/trainers', [TrainerController::class, 'index'])->name('trainers.index');
Route::get('/memberships', [MembershipController::class, 'index'])->name('memberships.index');

Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::get('logout', [LoginController::class, 'logout'])->name('logout');
Route::get('register', [RegisterController::class, 'showRegisterForm'])->name('register');
Route::get('terms-and-conditions', [PageController::class, 'termsAndConditions'])->name('terms-and-conditions');


Route::middleware('auth')->group(function () {
    Route::get('memberships/{membership}/checkout', [MembershipController::class, 'checkout'])->name('membership.checkout');
    Route::get('account', [App\Http\Controllers\PageController::class, 'account'])->name('account');
});
