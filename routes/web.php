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
| Routes Without Auth
|--------------------------------------------------------------------------
*/
Route::controller(BaseController::class)->group(function () {
    Route::get('/find-institute', 'findInstitute')->name('findInstitute');
    Route::get('/search-institutes', 'searchInstitutes')->name('searchInstitutes');
    Route::get('/get-cities', 'getCities')->name('getCities');
    Route::get('/search-bandar', 'getBandar')->name('search.bandar');
    Route::get('/get-institutes', 'getInstitutesByCity')->name('getInstitutes');
    Route::post('/institute-check', 'instituteCheck')->name('instituteCheck');
    Route::match(['get', 'post'], '/institute-details/{id}', 'instituteDetails')->name('instituteDetails');
});

Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'showLoginForm')->name('subscriptionLogin');
    Route::match(['get', 'post'], '/login-email', 'showLoginByEmail')->name('subscriptionLoginEmail');
    Route::get('/login-phone', 'showLoginByMobile')->name('subscriptionLoginPhone');
    Route::match(['get', 'post'], '/login-otp/{email}', 'fillOtpLogin')->name('subscriptionLoginOtp');
    Route::match(['get', 'post'], '/fill-otp/{email}', 'fillOtp')->name('fillOtp');
    Route::post('/logout', 'logout')->name('subscriptionLogout');
});

Route::match(['get', 'post'], '/institute-registration/{id}', [InstituteController::class, 'instituteRegistration'])->name('instituteRegistration');

Route::get('/payment-link/{id}/{c_id}/{in_id}', [BaseController::class, 'makePayment'])->name('makePayment');


// Route::get('/download/attachment/{year}/{filename}', function ($year, $filename) {
//     $path = "/var/www/static_files/fin_statement_attachments/$year/$filename";

//     if (file_exists($path)) {
//         return response()->file($path);
//     }

//     abort(404);
// })->name('download.attachment');


Route::get('/health', function () {
    return response('OK', 200);
});




/*
|--------------------------------------------------------------------------
| Routes with Auth
|--------------------------------------------------------------------------
*/

Route::middleware(['customAuth'])->group(function () {

    Route::controller(BaseController::class)->group(function () {
        Route::get('/', 'home')->name('home');
        Route::get('/request-subscription/{id}', 'requestSubscription')->name('requestSubscription');
        Route::match(['get', 'post'], '/institute/edit', [InstituteController::class, 'edit'])->name('instituteEdit');


        // Invoice PDF routes
        Route::get('/invoice/pdf/{tid}/{flag}', [BaseController::class, 'generateInvoicePdf'])
        ->name('invoice.generate.pdf');

    });

    Route::controller(FinancialStatementController::class)->group(function () {
        Route::get('/statement/list', 'list')->name('statementList');
        Route::match(['get', 'post'], '/statement/create/{id}', 'create')->name('createStatement');
        Route::match(['get', 'post'], '/statement/edit/{id}', 'edit')->name('editStatement');
        Route::match(['get', 'post'], '/statement/view/{id}', 'view')->name('viewStatement');
        Route::post('/statement/edit-request/{id}', 'editRequest')->name('editRequestStatement');
    });


    Route::get('/download/s3/attachment/{filepath}', [App\Http\Controllers\S3FileController::class, 'downloadAttachment'])
        ->name('download.s3.attachment');


    Route::get('/test-s3', [FinancialStatementController::class, 'testS3Connection']);

});
