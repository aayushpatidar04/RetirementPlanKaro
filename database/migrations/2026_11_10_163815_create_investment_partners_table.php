<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('investment_partners', function (Blueprint $t) {
            $t->id();
            $t->string('label', 120);                    // "Investment type text (customer sees this)"
            $t->string('category', 60)->default('Other'); // Category
            $t->string('partner', 100)->nullable();       // Partner name
            $t->text('url');                              // Referral link (must start with https://)
            $t->boolean('is_active')->default(true);      // Show on website
            $t->unsignedInteger('clicks')->default(0);    // Click count
            $t->unsignedInteger('sort_order')->default(0); // Display order
            $t->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('investment_partners');
    }
};