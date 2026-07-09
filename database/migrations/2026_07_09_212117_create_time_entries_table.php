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
        Schema::create('time_entries', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->foreignId('collaborator_id')->constrained()->cascadeOnDelete();
            $table->string('establishment');
            $table->decimal('workload_hours', 8, 2);
            $table->time('entry_time')->nullable();
            $table->time('exit_time')->nullable();
            $table->enum('presence', ['Presente', 'Nao Presente']);
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('time_entries');
    }
};