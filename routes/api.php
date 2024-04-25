<?php

use App\Http\Controllers\AttendanceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowController;
use App\Http\Controllers\DashboardUserController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\WorkorderController;
use App\Models\Attendance;
use App\Models\Material;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/auth/register', [AuthController::class, 'createUser']);
Route::post('/auth/login', [AuthController::class, 'loginUser']);
Route::post('/send-message', [NotificationController::class, 'sendMessage']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/user',  [AuthController::class, 'show']);
    Route::post('/update-data', [AuthController::class, 'update']);
    Route::post('/update-photo', [DashboardUserController::class, 'updateProfilePhoto']);
    Route::get('/books', [BorrowController::class, 'getBorrowedBooksByUser']);
    Route::get('/books/{kode_buku}', [BookController::class, 'findByKodeBuku']);
    Route::post('/attendance', [AttendanceController::class, 'store']);
    Route::post('/borrow-book', [BorrowController::class, 'store']);
});

