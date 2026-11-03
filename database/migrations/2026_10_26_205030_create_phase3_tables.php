<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('swp_settings', function (Blueprint $t) {
            $t->id();
            $t->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();
            $t->string('mode', 10)->default('mine');
            $t->string('show_filter', 10)->default('all');
            $t->timestamps();
        });

        Schema::create('life_goals', function (Blueprint $t) {
            $t->id();
            $t->foreignId('user_id')->constrained()->cascadeOnDelete();
            $t->string('name', 60);
            $t->double('target_age')->default(0);
            $t->double('cost_today')->default(0);
            $t->timestamps();
        });

        Schema::create('checklist_items', function (Blueprint $t) {
            $t->id();
            $t->foreignId('user_id')->constrained()->cascadeOnDelete();
            $t->string('age_group', 4);
            $t->string('item_key', 10);
            $t->boolean('is_checked')->default(false);
            $t->timestamp('checked_at')->nullable();
            $t->timestamps();
            $t->unique(['user_id', 'item_key']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('checklist_items');
        Schema::dropIfExists('life_goals');
        Schema::dropIfExists('swp_settings');
    }
};