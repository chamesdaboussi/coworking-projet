<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id('id_reservation');
            $table->date('date_debut');
            $table->date('date_fin');
            $table->time('heure_debut')->default('08:00:00');
            $table->time('heure_fin')->default('18:00:00');
            $table->enum('type_reservation', ['hourly', 'daily'])->default('daily');
            $table->enum('statut', ['pending', 'confirmed', 'expired', 'cancelled'])->default('pending');
            $table->string('code_confirmation', 20)->unique()->nullable();
            $table->text('notes')->nullable();
            $table->decimal('prix_total', 10, 2)->default(0);
            $table->decimal('remise_montant', 10, 2)->default(0);
            $table->decimal('prix_final', 10, 2)->default(0);
            $table->timestamp('expires_at')->nullable();
            $table->string('payment_method', 20)->nullable();
            $table->unsignedTinyInteger('payment_switch_count')->default(0);
            $table->timestamp('cancelled_at')->nullable();
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_espace');
            $table->unsignedBigInteger('id_code')->nullable();
            $table->timestamps();

            $table->foreign('id_user')->references('id_user')->on('utilisateurs')->onDelete('cascade');
            $table->foreign('id_espace')->references('id_espace')->on('espace_coworking')->onDelete('cascade');
            $table->foreign('id_code')->references('id_code')->on('code_promos')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
