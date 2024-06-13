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
        Schema::create(
            "prodi",
            function (Blueprint $table) {
                $table->id();
                $table->string('nama_prodi');
                $table->boolean('voting_open')->default(1);
            }
        );

        Schema::create(
            "mahasiswa",
            function (Blueprint $table) {
                $table->id();
                $table->string('nim')->unique();
                $table->foreignId("prodi_id")->references("id")->on("prodi");
                $table->boolean('status_vote')->default(0);
                $table->boolean('status_active')->default(1);
                $table->string("token")->unique()->nullable();
            }
        );

        Schema::create(
            "choice", 
            function (Blueprint $table){
                $table->id();
                $table->string("choice_cabinet");
        });

        Schema::create(
            "vote",
            function (Blueprint $table){
                $table->id();
                $table->foreignId("choice_id")->references("id")->on("choice");
                $table->foreignId("mahasiswa_id")->references("id")->on("mahasiswa");
            }
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vote');
        Schema::dropIfExists('choice');
        Schema::dropIfExists('mahasiswa');
        Schema::dropIfExists('prodi');
    }
};
