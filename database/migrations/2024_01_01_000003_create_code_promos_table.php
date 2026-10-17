<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('code_promos', function (Blueprint $table) {
            $table->id('id_code');
            $table->string('code', 50)->unique();
            $table->enum('type', ['percent', 'fixed']);
            $table->decimal('valeur', 10, 2);
            $table->decimal('valeur_min_commande', 10, 2)->default(0);
            $table->date('date_expiration')->nullable();
            $table->integer('usage_max')->nullable();
            $table->integer('usage_count')->default(0);
            $table->boolean('actif')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('code_promos');
    }
};
