<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('family_members', function (Blueprint $t) {
            $t->id();
            $t->foreignId('user_id')->constrained()->cascadeOnDelete();
            $t->string('name', 60);
            $t->string('rel', 20);
            $t->double('age')->default(0);
            $t->double('inc')->default(0);
            $t->double('exp')->default(0);
            $t->double('liq')->default(0);
            $t->double('ill')->default(0);
            $t->double('debt')->default(0);
            $t->double('sip')->default(0);
            $t->string('tm', 3)->default('No');
            $t->double('lc')->default(0);
            $t->double('tp')->default(0);
            $t->double('tt')->default(0);
            $t->string('hs', 40)->default('None');
            $t->double('hc')->default(0);
            $t->double('hp')->default(0);
            $t->string('ht', 3)->default('No');
            $t->double('ef')->default(0);
            $t->string('ew', 40)->default('Savings account');
            $t->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('family_members');
    }
};