<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('admins', function (Blueprint $t) {
            $t->id();
            $t->string('name', 60);
            $t->string('email', 190)->unique();
            $t->string('password');
            $t->rememberToken();
            $t->timestamps();
        });

        Schema::create('settings', function (Blueprint $t) {
            $t->string('key', 60)->primary();
            $t->text('value')->nullable();
            $t->timestamps();
        });

        $now = now();
        DB::table('settings')->insert([
            ['key' => 'report_price', 'value' => '499', 'created_at' => $now, 'updated_at' => $now],
            ['key' => 'session_price', 'value' => '1000', 'created_at' => $now, 'updated_at' => $now],
            ['key' => 'ref_pts', 'value' => '100', 'created_at' => $now, 'updated_at' => $now],
            ['key' => 'wallet_unlock_cost', 'value' => '200', 'created_at' => $now, 'updated_at' => $now],
            ['key' => 'wallet_unlock_hours', 'value' => '24', 'created_at' => $now, 'updated_at' => $now],
            ['key' => 'welcome_bonus', 'value' => '600', 'created_at' => $now, 'updated_at' => $now],
            ['key' => 'referral_bonus', 'value' => '100', 'created_at' => $now, 'updated_at' => $now],
            ['key' => 'streak_points', 'value' => '50', 'created_at' => $now, 'updated_at' => $now],
            ['key' => 'streak_days', 'value' => '7', 'created_at' => $now, 'updated_at' => $now],
            ['key' => 'packs', 'value' => json_encode([[200, 200], [1000, 500], [5000, 1000]]), 'created_at' => $now, 'updated_at' => $now],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
        Schema::dropIfExists('admins');
    }
};