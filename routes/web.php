<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\CouponController as AdminCouponController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LeadController as AdminLeadController;
use App\Http\Controllers\Admin\PaymentController as AdminPaymentController;
use App\Http\Controllers\Admin\SessionController as AdminSessionController;
use App\Http\Controllers\Admin\SettingController as AdminSettingController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlobController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ChecklistController;
use App\Http\Controllers\EmailVerificationController;
use App\Http\Controllers\FamilyController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\PayController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\PointsController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\WithdrawalController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('index');

Route::get('/my-investment-returns',      [HomeController::class, 'explore'])->defaults('slug', 'returns')->name('explore.returns');
Route::get('/stock-portfolio-analysis',   [HomeController::class, 'explore'])->defaults('slug', 'portfolio')->name('explore.portfolio');
Route::get('/income-tax-calculator',      [HomeController::class, 'explore'])->defaults('slug', 'tax')->name('explore.tax');
Route::get('/sip-calculator',             [HomeController::class, 'explore'])->defaults('slug', 'sip')->name('explore.sip');
Route::get('/home-loan-emi-calculator',   [HomeController::class, 'explore'])->defaults('slug', 'emi')->name('explore.emi');
Route::get('/budget-planner',             [HomeController::class, 'explore'])->defaults('slug', 'budget')->name('explore.budget');
Route::get('/sample-portfolio',           [HomeController::class, 'explore'])->defaults('slug', 'sample')->name('explore.sample');
Route::get('/one-window-investing',       [HomeController::class, 'explore'])->defaults('slug', 'invest')->name('explore.invest');
Route::get('/get-quotes',                 [HomeController::class, 'explore'])->defaults('slug', 'gq')->name('explore.gq');
Route::get('/explore', [HomeController::class, 'index'])->name('explore.all');
foreach (['checklist', 'family', 'report', 'learn'] as $p) {
    Route::get('/' . $p, [HomeController::class, 'index']);
}
Route::get('/learn/{tab}', [HomeController::class, 'index'])->where('tab', 'guides|myths|words|faq');
Route::get('/explore/wallet', [HomeController::class, 'index']);
Route::post('/payu/callback', [PayController::class, 'callback']); // existing — browser redirect (surl/furl)
Route::post('/payu/webhook',  [PayController::class, 'webhook']);  // new — server-to-server confirmation
Route::post('/api/lead', [LeadController::class, 'store'])->middleware('throttle:60,1');
Route::post('/api/chat', [ChatController::class, 'reply'])->middleware('throttle:30,1');

Route::get('/email/verify/{id}/{hash}', [EmailVerificationController::class, 'verify'])
    ->middleware('signed')->name('verification.verify');

Route::prefix('api/auth')->group(function () {
    Route::get('me', [AuthController::class, 'me']);
    Route::post('register', [AuthController::class, 'register'])->middleware('throttle:10,1');
    Route::post('login', [AuthController::class, 'login'])->middleware('throttle:10,1');
    Route::post('logout', [AuthController::class, 'logout']);
});

Route::middleware('auth')->post('api/auth/verify/resend', [EmailVerificationController::class, 'resend'])
    ->middleware('throttle:6,1');

Route::middleware('auth')->prefix('api/plan')->group(function () {
    Route::get('/', [PlanController::class, 'show']);
    Route::post('net-worth', [PlanController::class, 'netWorth']);
    Route::post('income-expense', [PlanController::class, 'incomeExpense']);
    Route::post('retirement-plan', [PlanController::class, 'retirementPlan']);
    Route::post('sync-local', [PlanController::class, 'syncLocal']);
    Route::get('withdrawal', [WithdrawalController::class, 'show']);
    Route::post('withdrawal-plan', [WithdrawalController::class, 'store']);
});

Route::middleware('auth')->prefix('api/checklist')->group(function () {
    Route::get('/', [ChecklistController::class, 'index']);
    Route::post('toggle', [ChecklistController::class, 'toggle']);
});

Route::middleware('auth')->prefix('api/family')->group(function () {
    Route::get('/', [FamilyController::class, 'index']);
    Route::post('/', [FamilyController::class, 'store']);
    Route::put('{id}', [FamilyController::class, 'update']);
    Route::delete('{id}', [FamilyController::class, 'destroy']);
});

Route::middleware('auth')->prefix('api/points')->group(function () {
    Route::get('balance', [PointsController::class, 'balance']);
    Route::post('streak-check', [PointsController::class, 'streakCheck']);
});

Route::middleware('auth')->prefix('api/wallet')->group(function () {
    Route::get('status', [WalletController::class, 'status']);
    Route::post('unlock', [WalletController::class, 'unlock']);
});

Route::middleware('auth')->prefix('api')->group(function () {
    Route::get('report/state', [PayController::class, 'state']);
    Route::post('coupon/check', [PayController::class, 'couponCheck']);
    Route::post('pay/initiate', [PayController::class, 'initiate'])->middleware('throttle:20,1');
    Route::get('pay/status', [PayController::class, 'status']);
    Route::get('blobs', [BlobController::class, 'index']);
    Route::put('blobs/{kind}', [BlobController::class, 'put']);
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('login', [AdminAuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AdminAuthController::class, 'login'])->middleware('throttle:10,1');
    Route::post('logout', [AdminAuthController::class, 'logout'])->name('logout');

    Route::middleware('admin.auth')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('clients', [App\Http\Controllers\Admin\ClientController::class, 'index'])->name('clients');
        Route::get('users', [AdminUserController::class, 'index'])->name('users');
        Route::get('users/{id}', [AdminUserController::class, 'show'])->name('users.show');
        Route::put('users/{id}', [AdminUserController::class, 'update'])->name('users.update');

        Route::get('leads', [AdminLeadController::class, 'index'])->name('leads');
        Route::get('payments', [AdminPaymentController::class, 'index'])->name('payments');
        Route::get('sessions', [AdminSessionController::class, 'index'])->name('sessions');
        Route::post('sessions/{id}/status', [AdminSessionController::class, 'status'])->name('sessions.status');
        Route::get('coupons', [AdminCouponController::class, 'index'])->name('coupons');
        Route::post('coupons', [AdminCouponController::class, 'store'])->name('coupons.store');
        Route::post('coupons/{id}/toggle', [AdminCouponController::class, 'toggle'])->name('coupons.toggle');
        Route::post('coupons/{id}/delete', [AdminCouponController::class, 'destroy'])->name('coupons.delete');
        Route::get('settings', [AdminSettingController::class, 'index'])->name('settings');
        Route::post('settings', [AdminSettingController::class, 'update'])->name('settings.update');
    });
});