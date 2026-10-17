<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('avis')) {
            Schema::create('avis', function (Blueprint $table) {
                $table->id('id_avis');
                $table->unsignedBigInteger('id_user');
                $table->unsignedBigInteger('id_espace');
                $table->unsignedBigInteger('id_reservation');
                $table->tinyInteger('note')->unsigned(); // 1–5 stars
                $table->text('commentaire')->nullable();
                $table->timestamps();

                $table->foreign('id_user')->references('id_user')->on('utilisateurs')->onDelete('cascade');
                $table->foreign('id_espace')->references('id_espace')->on('espace_coworking')->onDelete('cascade');
                $table->foreign('id_reservation')->references('id_reservation')->on('reservations')->onDelete('cascade');
                $table->unique(['id_user', 'id_espace']); // one review per user per space
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('avis');
    }
};
