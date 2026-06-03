<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->string('source', 20)->default('contact');
            $table->string('name', 100);
            $table->string('email', 150);
            $table->string('phone', 30)->nullable();
            $table->string('specialty', 100)->nullable();
            $table->string('subject', 100)->nullable();
            $table->text('message');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
