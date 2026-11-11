<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('version_snapshots', function (Blueprint $t) {
            $t->id();
            $t->unsignedInteger('version');           // Version number (1, 2, 3...)
            $t->string('area', 60);                   // Area name: "Pricing", "Points", "Referral", etc.
            $t->string('description', 200);           // Change description
            $t->json('data');                         // Full snapshot of the area settings
            $t->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('version_snapshots');
    }
};