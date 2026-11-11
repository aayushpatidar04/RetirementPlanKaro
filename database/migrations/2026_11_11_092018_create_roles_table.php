<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $t) {
            $t->string('id', 40)->primary();      // e.g., "owner", "manager", "support"
            $t->string('name', 60);
            $t->text('description')->nullable();
            $t->boolean('is_system')->default(false); // Cannot be deleted/modified
            $t->json('permissions');              // {"Home": "v", "Customers": "ve", "@export": "y"}
            $t->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};