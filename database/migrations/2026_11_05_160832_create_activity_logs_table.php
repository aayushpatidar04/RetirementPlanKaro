<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activity_logs', function (Blueprint $t) {
            $t->id();
            $t->unsignedBigInteger('user_id')->nullable()->index();
            $t->string('actor_type', 30)->nullable();   // admin | user | system
            $t->unsignedBigInteger('actor_id')->nullable();
            $t->string('actor_name', 120)->nullable();
            $t->string('event', 80)->index();           // e.g. payment.refunded, session.updated
            $t->string('description', 500)->nullable();
            $t->string('subject_type', 60)->nullable();
            $t->string('subject_id', 60)->nullable();
            $t->json('properties')->nullable();
            $t->string('ip', 45)->nullable();
            $t->timestamps();
            $t->index(['subject_type', 'subject_id']);
            $t->index(['user_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
