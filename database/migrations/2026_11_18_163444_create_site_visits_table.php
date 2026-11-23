<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('site_visits', function (Blueprint $t) {
            $t->id();
            $t->string('visitor', 32);          // random id from the rpk_vid cookie
            $t->date('visit_date');
            $t->string('path', 255)->nullable();
            $t->string('ref_code', 12)->nullable();
            $t->string('source', 60)->nullable(); // utm_source or referrer host
            $t->timestamp('created_at')->nullable();

            $t->unique(['visitor', 'visit_date']); // one row per visitor per day
            $t->index('visit_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('site_visits');
    }
};