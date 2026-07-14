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
        Schema::create('establishment_managements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('collaborator_id')->constrained('collaborators')->cascadeOnDelete();
            $table->date('date');
            $table->time('opened_at')->nullable();
            $table->time('closed_at')->nullable();
            $table->enum('establishment_state', ['Aberto', 'Fechado', 'Parcialmente'])->nullable();
            $table->text('description')->nullable();
            $table->enum('description_status', ['critico', 'razoavel', 'bom'])->nullable();
            $table->timestamps();

            $table->index(['date']);
            $table->index(['collaborator_id', 'date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('establishment_managements');
    }
};