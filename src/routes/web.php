<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\RepresentativeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::view('/thanks', 'auth.thanks');
Route::view('/done', 'done');
Route::view('/reservation/confirm/scan', 'scan');

Route::controller(ShopController::class)->group(function () {
    Route::get('/', 'index');
    Route::get('/search', 'search')->name('search');
    Route::get('/detail/{shop_id}', 'detail');
});

Route::controller(ReviewController::class)->group(function () {
    Route::get('/review/shop/{shop_id}', 'list');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::controller(AuthController::class)->group(function () {
        Route::get('/logout', 'destroy');
        Route::get('/mypage', 'index');
    });
    Route::prefix('reservation')->controller(ReservationController::class)->group(function () {
    Route::post('/store/{shop}', 'store')->name('reservation');
    Route::delete('/destroy/{reservation}', 'destroy')->name('reservation.destroy');
    Route::get('/edit/{reservation}', 'edit')->name('reservation.edit');
    Route::post('/update/{reservation}', 'update')->name('reservation.update');
    });
    Route::prefix('review')->controller(ReviewController::class)->group(function () {
    Route::get('/{shop_id}', 'index')->name('review');
    Route::post('/store/{shop_id}', 'store')->name('review.store');
    Route::post('/delete/{review_id}', 'delete');
    });
    Route::controller(FavoriteController::class)->group(function () {
        Route::post('/favorite/store/{shop}', 'store')->name('favorite');
        Route::delete('/favorite/destroy/{shop}', 'destroy')->name('unfavorite');
    });
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::controller(AdminController::class)->group(function () {
        Route::post('/register/Representative', 'register');
        Route::get('/user/index', 'userShow');
        Route::get('/search-users/index', 'search');
    });
    Route::view('/register', 'admin.register_Representative')->name('admin.register');
    Route::view('/email-notification', 'admin.email_notification')->name('admin.notification');
});

Route::post('/admin/email-notification', [MailController::class, 'sendNotification'])->name('send.notification');

Route::middleware(['auth', 'role:admin|Representative'])->prefix('representative')->controller(RepresentativeController::class)->group(function () {
    Route::get('/shop-edit', 'editShow');
    Route::post('/shop-edit', 'create_and_edit');
    Route::get('/confirm/shop-reservation', 'reservationShow');
    Route::patch('/update/shop-reservation', 'update');
    Route::delete('/destroy/shop-reservation', 'destroy');
});