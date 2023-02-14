<?php

use App\Http\Controllers\Authentication\AuthenticationController;
use App\Http\Controllers\Candidate\CandidateDashboardController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [AuthenticationController::class, 'index'])->name('index');
Route::get('/login', [AuthenticationController::class, 'login'])->name('login');
Route::get('/signup', [AuthenticationController::class, 'signup'])->name('signup');
Route::post('/post-signup', [AuthenticationController::class, 'post_signup'])->name('post_signup');
Route::post('/post-login', [AuthenticationController::class, 'authenticate'])->name('post_login');
Route::get('/logout', [AuthenticationController::class, 'Logout'])->name('Logout');

Route::middleware('VerifyUser')->group(function () {
    Route::group(['middleware' => 'auth:web'], function () {
        Route::prefix('candidate')->group(function () {
            Route::get('/dashboard', [CandidateDashboardController::class, 'dashboard'])->name('candidate.dashboard');
            Route::get('/profile', [CandidateDashboardController::class, 'profile'])->name('candidate.profile');
        });
    });
});
