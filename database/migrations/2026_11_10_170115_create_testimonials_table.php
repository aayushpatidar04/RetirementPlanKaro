<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('testimonials', function (Blueprint $t) {
            $t->id();
            $t->string('name', 40);                    // Name shown under the quote
            $t->text('text');                          // Testimonial text (max 300 chars)
            $t->boolean('permission_taken')->default(false); // Permission taken from person
            $t->boolean('is_active')->default(true);   // Show on website
            $t->unsignedInteger('sort_order')->default(0); // Display order
            $t->timestamps();
        });

        // Section text settings stored in settings table with key 'testimonials_section'
        // { on: boolean, kicker: string, title: string, sub: string, note: string }
    }

    public function down(): void
    {
        Schema::dropIfExists('testimonials');
    }
};