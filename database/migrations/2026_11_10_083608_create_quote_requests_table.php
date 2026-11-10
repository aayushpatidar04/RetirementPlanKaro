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
        Schema::create('quote_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('product_type'); // Term Insurance, Health Insurance, Car / Bike Insurance, Credit Card
            $table->string('customer_name');
            $table->string('customer_mobile');
            $table->string('customer_email')->nullable();
            $table->string('customer_city')->nullable();
            $table->json('details')->nullable(); // array of [label, value] pairs
            $table->text('note')->nullable();
            $table->string('status')->default('New'); // New, Quote shared, Follow-up, Converted, Lost
            $table->boolean('consent')->default(true);
            $table->timestamps();
            
            $table->index(['product_type', 'status']);
            $table->index('customer_mobile');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quote_requests');
    }
};