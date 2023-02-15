<?php

use App\Http\Controllers\Admin\AdminCotroller;
use App\Http\Controllers\Authentication\AuthenticationController;
use App\Http\Controllers\Candidate\CandidateDashboardController;
use App\Http\Controllers\Chat\ChatController;
use App\Http\Controllers\Employer\EmployerController;
use App\Http\Controllers\VerifyUser\VerifyUserController;
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

Route::get('/forget-password', [AuthenticationController::class, 'forget_password'])->name('forget_password');
Route::post('/post-forget-password', [AuthenticationController::class, 'post_forget_password'])->name('post_forget_password');
Route::get('/verify-forget-password', [AuthenticationController::class, 'verify_forget_password'])->name('verify_forget_password');
Route::post('/post-verify-forget-password', [AuthenticationController::class, 'post_verify_forget_password'])->name('post_verify_forget_password');

Route::group(['middleware' => 'auth:web'], function () {
    Route::get('/verify', [VerifyUserController::class, 'verify'])->name('verify.email');
    Route::get('/resend-code', [VerifyUserController::class, 'resend_code'])->name('resend.code');
    Route::post('/post-verify-email', [VerifyUserController::class, 'postverify'])->name('verify.postverify');
});

Route::middleware('VerifyUser')->group(function () {
    Route::group(['middleware' => 'auth:web'], function () {
        // Chat

        Route::post('/chat/send', [ChatController::class, 'sendMessage'])->name('sendMessage');
        Route::get('/chat/{userId}', [ChatController::class, 'getMessages'])->name('getMessages');

        Route::get('/candidate/complete-profile', [CandidateDashboardController::class, 'completeprofile'])->name('candidate.completeprofile');
        Route::post('/candidate/post-complete-profile', [CandidateDashboardController::class, 'postcompleteprofile'])->name('candidate.postcompleteprofile');
        Route::middleware('SecureCandidate')->group(function () {
            Route::prefix('candidate')->group(function () {
                Route::get('/inbox', [ChatController::class, 'inbox'])->name('inbox');
                Route::get('/dashboard', [CandidateDashboardController::class, 'dashboard'])->name('candidate.dashboard');
                Route::get('/profile', [CandidateDashboardController::class, 'profile'])->name('candidate.profile');
            });
        });
    });
    Route::middleware('SecureEmployer')->group(function () {
        Route::group(['middleware' => 'auth:web'], function () {
            Route::prefix('employer')->group(function () {
                Route::get('/dashboard', [EmployerController::class, 'dashboard'])->name('employer.dashboard');
                Route::get('/profile', [EmployerController::class, 'profile'])->name('employer.profile');
                Route::get('/profile', [EmployerController::class, 'profile'])->name('employer.profile');
            });
        });
    });
    Route::middleware('SecureAdmin')->group(function () {
        Route::group(['middleware' => 'auth:web'], function () {
            Route::prefix('admin')->group(function () {
                Route::get('/dashboard', [AdminCotroller::class, 'dashboard'])->name('admin.dashboard');
                Route::get('/profile', [AdminCotroller::class, 'profile'])->name('admin.profile');
            });
        });
    });
});
