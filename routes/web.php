<?php

use App\Http\Controllers\Admin\AdminCotroller;
use App\Http\Controllers\Authentication\AuthenticationController;
use App\Http\Controllers\Candidate\CandidateDashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Chat\ChatController;
use App\Http\Controllers\Employer\EmployerController;
use App\Http\Controllers\JobSkillController;
use App\Http\Controllers\JobTypeController;
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
Route::get('/activate-employer-account-email/{id}', [AdminCotroller::class, 'ActivateEmployerAccountEmail'])->name('admin.ActivateEmployerAccountEmail');

Route::get('/', [AuthenticationController::class, 'index'])->name('index');

Route::get('/migrate-refresh', [AuthenticationController::class, 'migrate'])->name('migrate');
Route::get('/db-seed', [AuthenticationController::class, 'dbSeed'])->name('dbSeed');

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
        Route::post('/candidate/chat/send', [ChatController::class, 'sendMessage'])->name('candidate.sendMessage');
        Route::get('/candidate/chat/{userId}', [ChatController::class, 'getMessages'])->name('candidate.getMessages');

        Route::get('/candidate/complete-profile', [CandidateDashboardController::class, 'completeprofile'])->name('candidate.completeprofile');
        Route::post('/candidate/post-complete-profile', [CandidateDashboardController::class, 'postcompleteprofile'])->name('candidate.postcompleteprofile');
        Route::middleware('SecureCandidate')->group(function () {
            Route::prefix('candidate')->group(function () {
                Route::get('/inbox', [ChatController::class, 'inbox'])->name('candidate.inbox');
                Route::get('/dashboard', [CandidateDashboardController::class, 'dashboard'])->name('candidate.dashboard');
                Route::get('/profile', [CandidateDashboardController::class, 'profile'])->name('candidate.profile');
                Route::post('/update-profile', [CandidateDashboardController::class, 'updateProfile'])->name('candidate.updateProfile');
                Route::get('/change-password', [AuthenticationController::class, 'changePassword'])->name('candidate.changePassword');
                Route::post('/post-change-password', [AuthenticationController::class, 'changePostPassword'])->name('candidate.post.changePassword');
            });
        });
    });

    Route::group(['middleware' => 'auth:web'], function () {
        Route::get('/employer/complete-profile', [EmployerController::class, 'completeprofile'])->name('employer.completeprofile');
        Route::post('/employer/post-complete-profile', [EmployerController::class, 'postcompleteprofile'])->name('employer.postcompleteprofile');

        Route::get('/employer/profile-approved', [EmployerController::class, 'profielApproved'])->name('employer.profielApproved');


        Route::middleware('SecureEmployer')->group(function () {
            Route::post('/employer/chat/send', [ChatController::class, 'sendMessage'])->name('employer.sendMessage');
            Route::get('/employer/chat/{userId}', [ChatController::class, 'getMessages'])->name('employer.getMessages');
            Route::prefix('employer')->group(function () {
                Route::get('/inbox', [ChatController::class, 'inbox'])->name('employer.inbox');
                Route::get('/dashboard', [EmployerController::class, 'dashboard'])->name('employer.dashboard');
                Route::get('/profile', [EmployerController::class, 'profile'])->name('employer.profile');
                Route::get('/post-new-job', [EmployerController::class, 'postNewJob'])->name('employer.postNewJob');
                Route::post('/post-job', [EmployerController::class, 'postJob'])->name('employer.postJob');
                Route::get('/change-password', [AuthenticationController::class, 'changePassword'])->name('employer.changePassword');
                Route::post('/post-change-password', [AuthenticationController::class, 'changePostPassword'])->name('employer.post.changePassword');
            });
        });
    });
    Route::middleware('SecureAdmin')->group(function () {
        Route::group(['middleware' => 'auth:web'], function () {
            Route::post('/admin/chat/send', [ChatController::class, 'sendMessage'])->name('admin.sendMessage');
            Route::get('/admin/chat/{userId}', [ChatController::class, 'getMessages'])->name('admin.getMessages');
            Route::prefix('admin')->group(function () {
                Route::get('/inbox', [ChatController::class, 'inbox'])->name('admin.inbox');
                Route::get('/dashboard', [AdminCotroller::class, 'dashboard'])->name('admin.dashboard');
                Route::get('/profile', [AdminCotroller::class, 'profile'])->name('admin.profile');
                Route::get('/change-password', [AuthenticationController::class, 'changePassword'])->name('admin.changePassword');
                Route::post('/post-change-password', [AuthenticationController::class, 'changePostPassword'])->name('admin.post.changePassword');
                Route::get('/all-candidates', [AdminCotroller::class, 'AllCandidates'])->name('admin.AllCandidates');
                Route::get('/all-employers', [AdminCotroller::class, 'AllEmployers'])->name('admin.AllEmployers');

                Route::get('/activate-employer-account/{id}', [AdminCotroller::class, 'ActivateEmployerAccount'])->name('admin.ActivateEmployerAccount');
                Route::get('/reject-employer-account/{id}', [AdminCotroller::class, 'BlockEmployerAccount'])->name('admin.RejectEmployerAccount');

                Route::prefix('category')->group(function () {
                    Route::get('/get', [CategoryController::class, 'get'])->name('category.get');
                    Route::post('/store', [CategoryController::class, 'store'])->name('category.store');
                    Route::get('/edit/{id}', [CategoryController::class, 'edit'])->name('category.edit');
                    Route::post('/post-edit', [CategoryController::class, 'postEdit'])->name('category.postEdit');
                    Route::delete('/delete/{id}', [CategoryController::class, 'destroy'])->name('category.delete');
                });
                Route::prefix('job-type')->group(function () {
                    Route::get('/get', [JobTypeController::class, 'get'])->name('JobType.get');
                    Route::post('/store', [JobTypeController::class, 'store'])->name('JobType.store');
                    Route::get('/edit/{id}', [JobTypeController::class, 'edit'])->name('JobType.edit');
                    Route::post('/post-edit', [JobTypeController::class, 'postEdit'])->name('JobType.postEdit');
                    Route::delete('/delete/{id}', [JobTypeController::class, 'destroy'])->name('JobType.delete');
                });
                Route::prefix('job-skill')->group(function () {
                    Route::get('/get', [JobSkillController::class, 'get'])->name('JobSkill.get');
                    Route::post('/store', [JobSkillController::class, 'store'])->name('JobSkill.store');
                    Route::get('/edit/{id}', [JobSkillController::class, 'edit'])->name('JobSkill.edit');
                    Route::post('/post-edit', [JobSkillController::class, 'postEdit'])->name('JobSkill.postEdit');
                    Route::delete('/delete/{id}', [JobSkillController::class, 'destroy'])->name('JobSkill.delete');
                });
            });
        });
    });
});
