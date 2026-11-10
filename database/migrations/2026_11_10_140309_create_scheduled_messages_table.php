<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('scheduled_messages', function (Blueprint $table) {
            $table->id();
            $table->string('channel'); // wa = WhatsApp, em = Email
            $table->json('recipient'); // {mobile, email, name} or list for bulk
            $table->string('subject')->nullable();
            $table->text('body');
            $table->string('template_id')->nullable();
            $table->timestamp('scheduled_at');
            $table->boolean('done')->default(false);
            $table->timestamp('sent_at')->nullable();
            $table->string('status')->default('scheduled'); // scheduled, sent, cancelled, failed
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scheduled_messages');
    }
};