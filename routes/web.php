<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\InstituteController;
use App\Http\Controllers\FinancialStatementController;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

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




Route::prefix('subscription')->group(function () {
    Route::get('/login', [BaseController::class, 'showLoginForm'])->name('subscriptionLogin');
    Route::match(['get', 'post'], '/login-email', [BaseController::class, 'showLoginByEmail'])->name('subscriptionLoginEmail');
    Route::get('/login-phone', [BaseController::class, 'showLoginByMobile'])->name('subscriptionLoginPhone');
    Route::match(['get', 'post'], '/login-otp/{email}', [BaseController::class, 'fillOtpLogin'])->name('subscriptionLoginOtp');
    Route::get('/search-bandar', [BaseController::class, 'getBandar'])->name('search.bandar');



    Route::middleware(['customAuth'])->group(function () {
        Route::get('/activate-subscription/{id}', [BaseController::class, 'activateSubscription'])
            ->name('activateSubscription');

        Route::get('/activated-subscription/{id}', [BaseController::class, 'activatedSubscription'])
            ->name('activatedSubscription');

        Route::match(['get', 'post'], '/pending-subscription/{id}', [BaseController::class, 'pendingSubscription'])
            ->name('pendingSubscription');

        Route::get('/home', [BaseController::class, 'home'])->name('home');

        Route::get('/statement/list', [FinancialStatementController::class, 'list'])->name('statementList');
        Route::match(['get', 'post'], '/statement/create/{id}', [FinancialStatementController::class, 'create'])->name('createStatement');
        Route::match(['get', 'post'], '/statement/edit/{id}', [FinancialStatementController::class, 'edit'])->name('editStatement');
        Route::match(['get', 'post'], '/statement/view/{id}', [FinancialStatementController::class, 'view'])->name('viewStatement');
        Route::post('/statement/edit-request/{id}', [FinancialStatementController::class, 'editRequest'])->name('editRequestStatement');

        Route::get('/request-subscription/{id}', [BaseController::class, 'requestSubscription'])->name('requestSubscription');
        Route::match(['get', 'post'], '/institute/edit', [InstituteController::class, 'edit'])->name('instituteEdit');
    });

    // Routes that don't require authentication
    Route::get('/payment-link/{id}/{c_id}', [BaseController::class, 'makePayment'])->name('makePayment');
    Route::post('/logout', [BaseController::class, 'logout'])->name('subscriptionLogout');








    Route::get('/find-institute', [BaseController::class, 'findInstitute'])->name('findInstitute');
    Route::match(['get', 'post'], '/institute-registration/{id}', [BaseController::class, 'instituteRegistration'])->name('instituteRegistration');




    Route::get('/search-institutes', [BaseController::class, 'searchInstitutes'])->name('searchInstitutes');
    Route::get('/get-cities', [BaseController::class, 'getCities'])->name('getCities');
    Route::get('/get-institutes', [BaseController::class, 'getInstitutesByCity'])->name('getInstitutes');
    Route::post('/institute-check', [BaseController::class, 'instituteCheck'])->name('instituteCheck');
    Route::match(['get', 'post'], '/institute-details/{id}', [BaseController::class, 'instituteDetails'])->name('instituteDetails');
    Route::match(['get', 'post'], '/fill-otp/{email}', [BaseController::class, 'fillOtp'])->name('fillOtp');




    Route::get('/download/attachment/{filename}', function ($filename) {
        $path = '/var/www/static_files/fin_statement_attachments/' . $filename;
        if (file_exists($path)) {
            return response()->file($path);
        }
        abort(404);
    })->name('download.attachment');

});
