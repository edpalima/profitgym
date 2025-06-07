<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\MembershipController;
use App\Http\Controllers\UserMembershipController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\TrainerController;
use App\Http\Controllers\WorkoutGuideController;
use App\Livewire\AttendanceComponent;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.home');
})->name('home');

Route::get('/workout-guide/{id}', action: [WorkoutGuideController::class, 'show'])->name('workout-guide.show');
Route::get('/trainers', [TrainerController::class, 'index'])->name('trainers.index');
Route::get('/memberships', [MembershipController::class, 'index'])->name('memberships.index');
Route::get('/gallery', [PageController::class, 'gallery'])->name('gallery');
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::get('logout', [LoginController::class, 'logout'])->name('logout');
Route::get('register', [RegisterController::class, 'showRegisterForm'])->name('register');
Route::get('terms-and-conditions', [PageController::class, 'termsAndConditions'])->name('terms-and-conditions');
Route::get('products', [PageController::class, 'products'])->name('products');
Route::get('/product/{id}', [PageController::class, 'product'])->name('product.show');

Route::post('/trainers/{trainer}/rate', [TrainerRatingController::class, 'store'])->name('trainers.rate');
Route::get('/trainers/{trainer}/rate/login-notice', [TrainerRatingController::class, 'showLoginNotice'])->name('trainers.rate.login-notice');

Route::middleware('auth')->group(function () {
    Route::get('memberships/{membership}/checkout', [MembershipController::class, 'checkout'])->name('membership.checkout');
    Route::get('feedback', [PageController::class, 'feedback'])->name('feedbacks');
    Route::get('orders', [PageController::class, 'orders'])->name('orders');
    Route::get('account', [App\Http\Controllers\PageController::class, 'account'])->name('account');
    Route::get('attendance', AttendanceComponent::class)->name('attendance');

    
});
Route::post('/trainers/{trainer}/rate', [TrainerController::class, 'rateTrainer'])->name('trainers.rate');
Route::get('/print-all-data.usermembership', [UserMembershipController::class, 'printAllDataUserMembership'])->name('print.all.data.usermembership');
Route::get('/print-all-data.orders', [OrderController::class, 'printAllDataOrders'])->name('print.all.data.orders');
Route::get('/print-all-data.payments', [PaymentController::class, 'printAllDataPayment'])->name('print.all.data.payments');
Route::get('/print-all-data.users', [UserController::class, 'printAllDataUser'])->name('print.all.data.users');
Route::get('/print-all-data.products', [ProductController::class, 'printAllDataProduct'])->name('print.all.data.products');
Route::get('/print-all-data.ratings', [RatingController::class, 'printAllDataRatings'])->name('print.all.data.ratings');
