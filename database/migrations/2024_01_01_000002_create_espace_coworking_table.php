<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('espace_coworking', function (Blueprint $table) {
            $table->id('id_espace');
            $table->string('nom', 200);
            $table->string('adresse', 200);
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->decimal('prix_heure', 10, 2)->default(0);
            $table->decimal('prix_jour', 10, 2);
            $table->integer('capacite')->default(1);
            $table->text('description')->nullable();
            $table->json('amenities')->nullable();
            $table->string('image')->nullable();
            $table->boolean('disponible')->default(true);
            $table->enum('type', ['bureau_prive', 'espace_ouvert', 'salle_reunion', 'studio'])->default('espace_ouvert');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('espace_coworking');
    }
};
