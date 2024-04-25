<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DashboardMaterialController;
use App\Http\Controllers\DashboardUserController;
use App\Http\Controllers\DashboardWorkorderController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\WorkorderController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('home',[
        "title" => "Home",
    ]);
});

Route::get('/about', function () {
    return view('about',[
        "title" => "About",
    ]);
});


// Route::get('/login',[AuthController::class,'index'])->name('login')->middleware('guest');

Route::get('/login',[AuthController::class,'index'])->name('login')->middleware('guest');
Route::post('/login',[AuthController::class,'authenticate']);
Route::post('/logout',[AuthController::class,'logout']);

Route::get('/dashboard',[DashboardController::class,'index'])->middleware('auth');

Route::resource('/dashboard/book',BookController::class)->middleware('auth');
Route::get('/dashboard/book', [BookController::class,'index'])->name('dashboard.book.index')->middleware('auth');
Route::post('/dashboard/book/store', [BookController::class,'store'])->middleware('auth');
Route::put('/dashboard/book/update', [BookController::class, 'update'])->name('dashboard.book.update')->middleware('auth');;

Route::resource('/dashboard/user',DashboardUserController::class)->middleware('auth');
Route::put('/dashboard/user/{user}/confirm', [DashboardUserController::class, 'confirmUser'])->middleware('auth');

Route::get('/dashboard/borrow', [BorrowController::class,'index'])->name('dashboard.borrow.index')->middleware('auth');
Route::post('/dashboard/borrow/return/{borrow}', [BorrowController::class,'returnBook'])->middleware('auth');

Route::get('/dashboard/attendance', [AttendanceController::class,'index'])->name('dashboard.attendance.index')->middleware('auth');

Route::post('/dashboard/borrow/send-notification/{id}', [NotificationController::class, 'sendNotification']);


