<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/** Team members sign in to the admin portal with their email + this password; their role decides what they see. */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('team_members', function (Blueprint $t) {
            $t->string('password')->nullable();
            $t->rememberToken();
            $t->timestamp('last_login_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('team_members', function (Blueprint $t) {
            $t->dropColumn(['password', 'remember_token', 'last_login_at']);
        });
    }
};
