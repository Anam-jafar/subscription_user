<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MetrixController;
use App\Http\Controllers\EntityController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\InstituteController;
use App\Http\Controllers\InstituteProfileController;
use App\Http\Controllers\FinancialStatementController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FinancialStatementReviewController;
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

Route::prefix('financial')->group(function () {
    // Authentication Routes
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::get('/register-institute', [AuthController::class, 'showInstituteProfileRegisterForm'])->name('registerInstitute');
    Route::get('/registration-details', [AuthController::class, 'showInstituteProfileRegistrationDetailsForm'])->name('showInstituteProfileRegistrationDetailsForm');
    Route::post('/register-institute-profile', [AuthController::class, 'instituteProfileRegister'])->name('instituteProfileRegister');

    Route::post('/login', [AuthController::class, 'login'])->name('submit.login');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::match(['get', 'post'],'/reset-password', [AuthController::class, 'resetPassword'])->name('resetPassword');
    Route::match(['get', 'post'], '/forget-password', [AuthController::class, 'forgetPassword'])->name('forgetPassword');

    Route::get('/get-institute-types/{instituteCode}', [InstituteController::class,'getInstituteTypes']);
    Route::get('/get-sub-districts/{districtCode}', [InstituteController::class, 'getSubDistricts']);
    //Route::get('/search-institutes', [InstituteController::class, 'searchInstitutes']);



        Route::get('/', [ClientController::class, 'index'])->name('index');



    Route::prefix('subscription')->group(function () {
        Route::get('/login', [BaseController::class, 'showLoginForm'])->name('subscriptionLogin');
        Route::match(['get', 'post'], '/login-email', [BaseController::class, 'showLoginByEmail'])->name('subscriptionLoginEmail');
        Route::get('/login-phone', [BaseController::class, 'showLoginByMobile'])->name('subscriptionLoginPhone');
        Route::match(['get', 'post'],'/login-otp', [BaseController::class, 'fillOtpLogin'])->name('subscriptionLoginOtp');
        Route::get('/activate-subscription/{id}', [BaseController::class, 'activateSubscription'])
            ->name('activateSubscription')
            ->middleware('customAuth'); // Apply the custom middleware
        Route::get('/activated-subscription/{id}', [BaseController::class, 'activatedSubscription'])
            ->name('activatedSubscription')
            ->middleware('customAuth'); // Apply the custom middleware
        Route::get('/payment-link/{id}/{c_id}', [BaseController::class, 'makePayment'])->name('makePayment');
        

        Route::post('/logout', [BaseController::class, 'logout'])->name('subscriptionLogout');



        Route::get('/find-institute', [BaseController::class, 'findInstitute'])->name('findInstitute');
        Route::get('/institute-not-found', [BaseController::class, 'instituteNotFound'])->name('instituteNotFound');
        Route::get('/institute-not-subscribed', [BaseController::class, 'instituteNotSubscribed'])->name('instituteNotSubscribed');
        Route::get('/institute-subscribed', [BaseController::class, 'instituteSubscribed'])->name('instituteSubscribed');

        Route::get('/search-institutes', [BaseController::class, 'searchInstitutes'])->name('searchInstitutes');
        Route::get('/get-cities', [BaseController::class, 'getCities'])->name('getCities');
        Route::get('/get-institutes', [BaseController::class, 'getInstitutesByCity'])->name('getInstitutes');
        Route::post('/institute-check', [BaseController::class, 'instituteCheck'])->name('instituteCheck');
        Route::match(['get', 'post'], '/institute-details/{id}', [BaseController::class, 'instituteDetails'])->name('instituteDetails');
        Route::match(['get', 'post'], '/fill-otp/{email}', [BaseController::class, 'fillOtp'])->name('fillOtp');



    });
    

    
    Route::prefix('admin')->group(function () {

        Route::get('/login', [AuthController::class, 'showLoginFormAdmin'])->name('loginAdmin');
        
        Route::middleware(['adminAccess'])->group(function () {
            
            Route::get('/', [ClientController::class, 'adminIndex'])->name('adminIndex');
            // Route::match(['get', 'post'], '/register-user', [AuthController::class, 'registerUser'])->name('registerUser');

            Route::get('/institute', [InstituteController::class, 'instituteList'])->name('instituteList');
            Route::match(['get', 'post'], '/institute/create', [InstituteController::class, 'instituteCreate'])->name('instituteCreate');
            Route::match(['get', 'post'], '/institute/{id}/edit', [InstituteController::class, 'instituteUpdate'])->name('instituteUpdate');
            
            Route::get('/institute-profile', [InstituteProfileController::class, 'instituteProfileList'])->name('instituteProfileList');
            Route::get('/institute-profile-request', [InstituteProfileController::class, 'instituteProfileRequestList'])->name('instituteProfileRequestList');
            Route::match(['get', 'post'], '/institute-profile/{id}/edit', [InstituteProfileController::class, 'update'])->name('instituteProfileUpdate');

            Route::get('/user', [UserController::class, 'list'])->name('userList');
            Route::match(['get', 'post'], '/user/create', [UserController::class, 'create'])->name('registerUser');
            Route::match(['get', 'post'], '/user/{id}/edit', [UserController::class, 'update'])->name('userUpdate');

            Route::get('/financial-statement-list', [FinancialStatementReviewController::class, 'list'])->name('financialStatementReviewlist');
            Route::get('/financial-statement-list/reviewed', [FinancialStatementReviewController::class, 'reviewedList'])->name('financialStatementReviewlistReviewed');

            Route::get('/financial-statement-cancelation-request-list', [FinancialStatementReviewController::class, 'cancelRequestList'])->name('cancelRequestList');
            Route::get('/financial-statement-review/{id}/view', [FinancialStatementReviewController::class, 'view'])->name('financialStatementReview');
            Route::get('/financial-statement-processed/{id}/view', [FinancialStatementReviewController::class, 'reviewedView'])->name('financialStatementReviewedView');
            Route::get('/financial-statement-cancel-request/{id}/view', [FinancialStatementReviewController::class, 'cancelRequestView'])->name('financialStatementCancelRequestView');
            Route::post('/financial-statement-cancelation/{id}/by-admin', [FinancialStatementReviewController::class, 'statementCancellation'])->name('financialStatementCancellation');



            
            Route::post('/financial-statement-review/{id}/approve', [FinancialStatementReviewController::class, 'adminReview'])->name('financialStatementApprove');

        });

    });


    Route::get('/download/{filename}', function ($filename) {
        $path = "fin_statement_attachments/" . $filename;

        if (Storage::disk('public')->exists($path)) {
            return response()->download(storage_path("app/public/" . $path));
        }

        return abort(404);
    })->name('download.attachment');




    //********************************************************Testing Routes**************************************************************************** */
    //=====================================================================================================================================================

    Route::get('/test', [InstituteProfileController::class, 'sendDummyEmail']);

    // Profile Management Routes
    Route::controller(AuthController::class)->group(function () {
        Route::get('/profile', 'profile')->name('profile');
        Route::put('/profile/update', 'updateProfile')->name('updateProfile');
        Route::put('/profile/password', 'updatePassword')->name('updatePassword');
        Route::get('/activity-logs', 'activityLogs')->name('activityLogs');

    });

    Route::get('/report/create', [ClientController::class, 'reportCreate'])->name('reportCreate');
    Route::get('/report/create_', [ClientController::class, 'reportCreate_'])->name('reportCreate_');
    Route::get('/report/view', [ClientController::class, 'reportView'])->name('reportView');
    Route::get('/report/view_', [ClientController::class, 'reportView_'])->name('reportView_');
    Route::get('/report/_view_', [ClientController::class, '_reportView_'])->name('_reportView_');
});



