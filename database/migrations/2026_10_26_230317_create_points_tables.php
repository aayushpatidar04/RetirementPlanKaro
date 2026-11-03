<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('points_ledger', function (Blueprint $t) {
            $t->id();
            $t->foreignId('user_id')->constrained()->cascadeOnDelete();
            $t->string('account', 10); // report | wallet
            $t->string('type', 30);    // signup_bonus, referral_bonus, streak_bonus, wallet_purchase, wallet_unlock_debit
            $t->integer('points');     // signed: positive = credit, negative = debit
            $t->string('note', 120)->nullable();
            $t->timestamps();
            $t->index(['user_id', 'account']);
        });

        Schema::create('referrals', function (Blueprint $t) {
            $t->id();
            $t->foreignId('referrer_user_id')->constrained('users')->cascadeOnDelete();
            $t->foreignId('referred_user_id')->unique()->constrained('users')->cascadeOnDelete();
            $t->boolean('credited')->default(true);
            $t->timestamps();
        });

        Schema::create('wallet_unlocks', function (Blueprint $t) {
            $t->id();
            $t->foreignId('user_id')->constrained()->cascadeOnDelete();
            $t->string('option_key', 20);
            $t->timestamp('unlocked_at')->nullable();
            $t->timestamp('expires_at');
            $t->timestamps();
            $t->unique(['user_id', 'option_key']);
        });

        Schema::create('user_streaks', function (Blueprint $t) {
            $t->id();
            $t->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();
            $t->date('last_date')->nullable();
            $t->unsignedTinyInteger('day')->default(0);
            $t->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_streaks');
        Schema::dropIfExists('wallet_unlocks');
        Schema::dropIfExists('referrals');
        Schema::dropIfExists('points_ledger');
    }
};