<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('guidance_sessions', function (Blueprint $t) {
            if (!Schema::hasColumn('guidance_sessions', 'question')) $t->string('question', 500)->nullable()->after('note');
            if (!Schema::hasColumn('guidance_sessions', 'advisor')) $t->string('advisor', 120)->nullable()->after('question');
            if (!Schema::hasColumn('guidance_sessions', 'cancel_reason')) $t->string('cancel_reason', 300)->nullable()->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('guidance_sessions', function (Blueprint $t) {
            foreach (['cancel_reason','advisor','question'] as $c) if (Schema::hasColumn('guidance_sessions', $c)) $t->dropColumn($c);
        });
    }
};
