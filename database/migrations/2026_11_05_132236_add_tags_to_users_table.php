<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->json('tags')->nullable()->after('share_consent');
            $table->string('stage', 50)->nullable()->after('tags');
            $table->string('assigned_to', 100)->nullable()->after('stage');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['tags', 'stage', 'assigned_to']);
        });
    }
};

