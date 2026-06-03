<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('plan_configs', function (Blueprint $table) {
            $table->id();
            $table->integer('starter_price_monthly')->default(290);
            $table->integer('starter_price_annual')->default(232);
            $table->string('starter_desc')->default('Pour les médecins solo qui débutent');
            $table->text('starter_features_json')->nullable();
            $table->integer('pro_price_monthly')->default(490);
            $table->integer('pro_price_annual')->default(392);
            $table->string('pro_desc')->default('Le plus populaire pour les cabinets actifs');
            $table->text('pro_features_json')->nullable();
            $table->integer('licence_price')->default(4900);
            $table->string('licence_desc')->default('Paiement unique, hébergé chez vous');
            $table->string('licence_suffix', 100)->default('MAD · paiement unique');
            $table->text('licence_features_json')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('plan_configs');
    }
};
