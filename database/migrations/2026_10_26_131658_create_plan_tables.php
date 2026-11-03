<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Step 1: top-level fields
        Schema::create('net_worths', function (Blueprint $t) {
            $t->id();
            $t->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();
            $t->double('age')->nullable();
            $t->string('country', 2)->default('IN');
            $t->timestamps();
        });

        // Step 1: one row per asset (fixed rows have a slot, "+ Add another" rows have slot = null)
        Schema::create('assets', function (Blueprint $t) {
            $t->id();
            $t->foreignId('user_id')->constrained()->cascadeOnDelete();
            $t->string('type', 12); // liquid | non_liquid
            $t->string('slot', 10)->nullable(); // bank, fd, eq, epf, gold, re, home
            $t->string('label', 60);
            $t->double('amount')->default(0);
            $t->timestamps();
        });

        // Step 1: liabilities
        Schema::create('liabilities', function (Blueprint $t) {
            $t->id();
            $t->foreignId('user_id')->constrained()->cascadeOnDelete();
            $t->string('slot', 10)->nullable(); // hl, cl, pl, ol
            $t->string('label', 60);
            $t->double('amount')->default(0);
            $t->timestamps();
        });

        // Step 2: income
        Schema::create('income_expenses', function (Blueprint $t) {
            $t->id();
            $t->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();
            $t->double('monthly_income')->default(0);
            $t->timestamps();
        });

        // Step 2: one row per expense category incl. the Essential tick
        Schema::create('expenses', function (Blueprint $t) {
            $t->id();
            $t->foreignId('user_id')->constrained()->cascadeOnDelete();
            $t->string('slot', 10)->nullable(); // x0..x9
            $t->string('label', 60);
            $t->double('amount')->default(0);
            $t->boolean('is_essential')->default(false);
            $t->timestamps();
        });

        // Step 2: "Your protection" panel
        Schema::create('protections', function (Blueprint $t) {
            $t->id();
            $t->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();
            $t->string('life_insurance', 3)->default('No');
            $t->double('life_cover')->default(0);
            $t->double('term_premium')->default(0);
            $t->double('term_till_age')->default(0);
            $t->string('health_type', 40)->default('None');
            $t->double('health_cover')->default(0);
            $t->double('health_premium')->default(0);
            $t->string('health_topup', 3)->default('No');
            $t->double('emergency_fund')->default(0);
            $t->string('emergency_where', 40)->default('Savings account');
            $t->timestamps();
        });

        // Step 3
        Schema::create('retirement_plans', function (Blueprint $t) {
            $t->id();
            $t->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();
            $t->double('retirement_age')->default(60);
            $t->double('life_expectancy')->default(90);
            $t->double('monthly_spending')->default(0);
            $t->double('other_income')->default(0);
            $t->double('inflation_rate')->default(6);
            $t->double('return_pre')->default(10);
            $t->double('return_post')->default(7);
            $t->double('current_corpus')->default(0);
            $t->double('monthly_sip')->default(0);
            $t->double('step_up_percent')->default(5);
            // true = value was filled from earlier steps, false = user typed it
            $t->boolean('spending_auto')->default(true);
            $t->boolean('corpus_auto')->default(true);
            $t->boolean('sip_auto')->default(true);
            $t->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('retirement_plans');
        Schema::dropIfExists('protections');
        Schema::dropIfExists('expenses');
        Schema::dropIfExists('income_expenses');
        Schema::dropIfExists('liabilities');
        Schema::dropIfExists('assets');
        Schema::dropIfExists('net_worths');
    }
};