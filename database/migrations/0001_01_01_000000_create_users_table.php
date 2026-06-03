<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name', 100);
            $table->string('last_name', 100);
            $table->string('email', 150)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('phone', 30)->nullable();
            $table->string('specialty', 100)->nullable();
            $table->string('cabinet_name', 150)->nullable();
            $table->string('city', 100)->nullable();
            $table->text('bio')->nullable();
            $table->text('photo_url')->nullable();
            $table->string('linkedin', 300)->nullable();
            $table->string('instagram', 300)->nullable();
            $table->string('facebook', 300)->nullable();
            $table->string('languages', 200)->nullable();
            $table->string('plan', 20)->default('starter');
            $table->timestamp('trial_ends_at')->nullable();
            $table->string('role', 20)->default('doctor');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
