<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\CouponController as AdminCouponController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\InvestmentPartnerController as AdminInvestmentPartnerController;
use App\Http\Controllers\Admin\LeadController as AdminLeadController;
use App\Http\Controllers\Admin\MessageController as AdminMessageController;
use App\Http\Controllers\Admin\PaymentController as AdminPaymentController;
use App\Http\Controllers\Admin\QuoteController as AdminQuoteController;
use App\Http\Controllers\Admin\ReferralController as AdminReferralController;
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

Route::middleware(['auth','user.active'])->post('api/auth/verify/resend', [EmailVerificationController::class, 'resend'])
    ->middleware('throttle:6,1');

Route::middleware(['auth','user.active'])->prefix('api/plan')->group(function () {
    Route::get('/', [PlanController::class, 'show']);
    Route::post('net-worth', [PlanController::class, 'netWorth']);
    Route::post('income-expense', [PlanController::class, 'incomeExpense']);
    Route::post('retirement-plan', [PlanController::class, 'retirementPlan']);
    Route::post('sync-local', [PlanController::class, 'syncLocal']);
    Route::get('withdrawal', [WithdrawalController::class, 'show']);
    Route::post('withdrawal-plan', [WithdrawalController::class, 'store']);
});

Route::middleware(['auth','user.active'])->prefix('api/checklist')->group(function () {
    Route::get('/', [ChecklistController::class, 'index']);
    Route::post('toggle', [ChecklistController::class, 'toggle']);
});

Route::middleware(['auth','user.active'])->prefix('api/family')->group(function () {
    Route::get('/', [FamilyController::class, 'index']);
    Route::post('/', [FamilyController::class, 'store']);
    Route::put('{id}', [FamilyController::class, 'update']);
    Route::delete('{id}', [FamilyController::class, 'destroy']);
});

Route::middleware(['auth','user.active'])->prefix('api/points')->group(function () {
    Route::get('balance', [PointsController::class, 'balance']);
    Route::post('streak-check', [PointsController::class, 'streakCheck']);
});

Route::middleware(['auth','user.active'])->prefix('api/wallet')->group(function () {
    Route::get('status', [WalletController::class, 'status']);
    Route::post('unlock', [WalletController::class, 'unlock']);
});

Route::middleware(['auth','user.active'])->prefix('api')->group(function () {
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
        Route::post('users/{id}/adjust-points', [AdminUserController::class, 'adjustPoints'])->name('users.adjustPoints');
        Route::post('users/{id}/notes', [AdminUserController::class, 'storeNote'])->name('users.notes.store');
        Route::put('users/{id}/tags', [AdminUserController::class, 'updateTags'])->name('users.tags.update');
        Route::put('users/{id}/planner', [AdminUserController::class, 'updatePlanner'])->name('users.planner.update');
        Route::post('users/{id}/payments/{paymentId}/status', [AdminUserController::class, 'updatePaymentStatus'])->name('users.payments.status');
        Route::post('users/{id}/sessions/{sessionId}', [AdminUserController::class, 'updateSession'])->name('users.sessions.update');
        Route::post('users/{id}/suspend', [AdminUserController::class, 'toggleSuspend'])->name('users.suspend');




        Route::get('leads', [AdminLeadController::class, 'index'])->name('leads');
        Route::get('payments', [AdminPaymentController::class, 'index'])->name('payments');
        Route::get('sessions', [AdminSessionController::class, 'index'])->name('sessions');
        Route::post('sessions/availability', [AdminSessionController::class, 'saveAvailability'])->name('sessions.availability');
        Route::post('sessions/{id}', [AdminSessionController::class, 'update'])->name('sessions.update');
        Route::post('sessions/{id}/status', [AdminSessionController::class, 'status'])->name('sessions.status');
Route::get('coupons', [AdminCouponController::class, 'index'])->name('coupons');
        Route::post('coupons', [AdminCouponController::class, 'store'])->name('coupons.store');
        Route::post('coupons/{id}/toggle', [AdminCouponController::class, 'toggle'])->name('coupons.toggle');
        Route::post('coupons/{id}/delete', [AdminCouponController::class, 'destroy'])->name('coupons.delete');

        // Investment Partners
        Route::get('investment-partners', [AdminInvestmentPartnerController::class, 'index'])->name('investment-partners');
        Route::post('investment-partners', [AdminInvestmentPartnerController::class, 'store'])->name('investment-partners.store');
        Route::put('investment-partners/{id}', [AdminInvestmentPartnerController::class, 'update'])->name('investment-partners.update');
        Route::delete('investment-partners', [AdminInvestmentPartnerController::class, 'destroy'])->name('investment-partners.delete');
        Route::post('investment-partners/duplicate', [AdminInvestmentPartnerController::class, 'duplicate'])->name('investment-partners.duplicate');
        Route::post('investment-partners/move-up', [AdminInvestmentPartnerController::class, 'moveUp'])->name('investment-partners.move-up');
        Route::post('investment-partners/move-down', [AdminInvestmentPartnerController::class, 'moveDown'])->name('investment-partners.move-down');
        Route::get('investment-partners/export', [AdminInvestmentPartnerController::class, 'export'])->name('investment-partners.export');

        Route::get('quotes', [AdminQuoteController::class, 'index'])->name('quotes');
        Route::post('quotes', [AdminQuoteController::class, 'store'])->name('quotes.store');
        Route::put('quotes/{id}', [AdminQuoteController::class, 'update'])->name('quotes.update');
        Route::post('quotes/{id}/status', [AdminQuoteController::class, 'status'])->name('quotes.status');
        Route::get('settings', [AdminSettingController::class, 'index'])->name('settings');
        Route::post('settings', [AdminSettingController::class, 'update'])->name('settings.update');
        Route::get('referrals', [AdminReferralController::class, 'index'])->name('referrals');
        Route::post('referrals/settings', [AdminReferralController::class, 'saveSettings'])->name('referrals.settings');
        Route::post('referrals/code', [AdminReferralController::class, 'updateReferralCode'])->name('referrals.code');
        Route::post('referrals/toggle', [AdminReferralController::class, 'toggleReferral'])->name('referrals.toggle');
        Route::post('referrals/campaign-link', [AdminReferralController::class, 'addCampaignLink'])->name('referrals.campaign-link.add');
        Route::put('referrals/campaign-link', [AdminReferralController::class, 'editCampaignLink'])->name('referrals.campaign-link.edit');
        Route::delete('referrals/campaign-link', [AdminReferralController::class, 'deleteCampaignLink'])->name('referrals.campaign-link.delete');

        // Messages & Email (Client Communications)
        Route::get('messages', [AdminMessageController::class, 'index'])->name('messages');
        Route::get('messages/templates/create', [AdminMessageController::class, 'createTemplate'])->name('messages.templates.create');
        Route::post('messages/templates', [AdminMessageController::class, 'storeTemplate'])->name('messages.templates.store');
        Route::put('messages/templates/{id}', [AdminMessageController::class, 'updateTemplate'])->name('messages.templates.update');
        Route::delete('messages/templates', [AdminMessageController::class, 'deleteTemplate'])->name('messages.templates.delete');
        Route::post('messages/templates/duplicate', [AdminMessageController::class, 'duplicateTemplate'])->name('messages.templates.duplicate');
        Route::post('messages/stage-mapping', [AdminMessageController::class, 'saveStageMapping'])->name('messages.stage-mapping');
        Route::post('messages/send', [AdminMessageController::class, 'send'])->name('messages.send');
        Route::post('messages/schedule', [AdminMessageController::class, 'schedule'])->name('messages.schedule');
        Route::post('messages/scheduled/send', [AdminMessageController::class, 'sendScheduled'])->name('messages.scheduled.send');
        Route::post('messages/scheduled/cancel', [AdminMessageController::class, 'cancelScheduled'])->name('messages.scheduled.cancel');
        Route::get('messages/export/logs', [AdminMessageController::class, 'exportLogs'])->name('messages.export.logs');
        Route::get('messages/export/templates', [AdminMessageController::class, 'exportTemplates'])->name('messages.export.templates');
    });
});