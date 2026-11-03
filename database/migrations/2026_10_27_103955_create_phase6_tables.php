<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $t) {
            $t->id();
            $t->foreignId('user_id')->constrained()->cascadeOnDelete();
            $t->string('txnid', 40)->unique();
            $t->string('purpose', 10);                       // report | session | wallet
            $t->unsignedBigInteger('ref_id')->nullable();    // guidance_sessions.id for purpose=session
            $t->unsignedTinyInteger('pack')->nullable();     // wallet pack index for purpose=wallet
            $t->decimal('base_amount', 10, 2)->default(0);
            $t->string('coupon_code', 30)->nullable();
            $t->decimal('coupon_off', 10, 2)->default(0);
            $t->unsignedInteger('points_used')->default(0);  // report points redeemed (1 point = Rs 1)
            $t->decimal('amount', 10, 2)->default(0);        // what PayU is asked to charge
            $t->string('status', 10)->default('pending');    // pending | success | failed
            $t->string('payu_id', 40)->nullable();           // PayU mihpayid
            $t->string('mode', 20)->nullable();
            $t->timestamp('paid_at')->nullable();
            $t->timestamps();
            $t->index(['user_id', 'purpose', 'status']);
        });

        Schema::create('coupons', function (Blueprint $t) {
            $t->id();
            $t->string('code', 30)->unique();
            $t->string('type', 10);                          // flat | percent
            $t->decimal('value', 10, 2);
            $t->unsignedInteger('max_uses')->nullable();
            $t->unsignedInteger('used_count')->default(0);
            $t->boolean('active')->default(true);
            $t->timestamp('expires_at')->nullable();
            $t->timestamps();
        });

        Schema::create('coupon_redemptions', function (Blueprint $t) {
            $t->id();
            $t->foreignId('coupon_id')->constrained()->cascadeOnDelete();
            $t->foreignId('user_id')->constrained()->cascadeOnDelete();
            $t->unsignedBigInteger('payment_id')->nullable();
            $t->timestamps();
            $t->unique(['coupon_id', 'user_id']);
        });

        Schema::create('guidance_sessions', function (Blueprint $t) {
            $t->id();
            $t->foreignId('user_id')->constrained()->cascadeOnDelete();
            $t->unsignedBigInteger('payment_id')->nullable();
            $t->date('date');
            $t->string('slot', 40);
            $t->string('mode', 20);
            $t->string('mobile', 15);
            $t->string('note', 300)->nullable();
            $t->string('status', 20)->default('pending_payment'); // pending_payment | confirmed | cancelled | done
            $t->timestamps();
            $t->index(['user_id', 'status']);
        });

        Schema::create('leads', function (Blueprint $t) {
            $t->id();
            $t->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $t->string('event', 60);
            $t->string('mobile', 15)->nullable();
            $t->string('email', 190)->nullable();
            $t->longText('payload')->nullable();
            $t->string('ip', 45)->nullable();
            $t->timestamps();
            $t->index(['event', 'mobile']);
        });

        Schema::create('user_blobs', function (Blueprint $t) {
            $t->id();
            $t->foreignId('user_id')->constrained()->cascadeOnDelete();
            $t->string('kind', 20);                          // budget
            $t->longText('data');
            $t->timestamps();
            $t->unique(['user_id', 'kind']);
        });

        // Starting coupons (same three codes the page had). Edit later from the admin panel.
        $now = now();
        DB::table('coupons')->insert([
            ['code' => 'WELCOME100', 'type' => 'flat',    'value' => 100, 'max_uses' => null, 'used_count' => 0, 'active' => true, 'expires_at' => null, 'created_at' => $now, 'updated_at' => $now],
            ['code' => 'FRIEND50',   'type' => 'flat',    'value' => 50,  'max_uses' => null, 'used_count' => 0, 'active' => true, 'expires_at' => null, 'created_at' => $now, 'updated_at' => $now],
            ['code' => 'LAUNCH20',   'type' => 'percent', 'value' => 20,  'max_uses' => null, 'used_count' => 0, 'active' => true, 'expires_at' => null, 'created_at' => $now, 'updated_at' => $now],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('user_blobs');
        Schema::dropIfExists('leads');
        Schema::dropIfExists('guidance_sessions');
        Schema::dropIfExists('coupon_redemptions');
        Schema::dropIfExists('coupons');
        Schema::dropIfExists('payments');
    }
};