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
        Schema::create('house_hold_heads', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('middle_name');
            $table->string('slug')->nullable();
            $table->string('purok')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('mobile_no')->nullable();
            $table->string('house_no')->nullable();
            $table->string('street')->nullable();
            $table->string('suffix')->nullable();
            $table->string('gender')->nullable();
            $table->string('birth_place')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->smallInteger(column: 'notification')->default(1)->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->softDeletes();
            $table->boolean('isActive')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('house_hold_heads');
    }
};
