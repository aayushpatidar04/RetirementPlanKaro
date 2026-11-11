<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('team_members', function (Blueprint $t) {
            $t->string('id', 40)->primary();      // e.g., "m1", "m2"
            $t->string('name', 80);
            $t->string('email', 120)->unique();
            $t->string('mobile', 20)->nullable();
            $t->string('role_id', 40);            // References roles.id
            $t->json('extra')->nullable();         // Extra permissions: {"Home": "e", "@export": "y"}
            $t->boolean('is_active')->default(true);
            $t->timestamp('added_at')->nullable();
            $t->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('team_members');
    }
};