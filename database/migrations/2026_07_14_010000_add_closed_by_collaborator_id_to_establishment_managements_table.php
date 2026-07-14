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
        Schema::table('establishment_managements', function (Blueprint $table) {
            $table->foreignId('closed_by_collaborator_id')
                ->nullable()
                ->after('collaborator_id')
                ->constrained('collaborators')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('establishment_managements', function (Blueprint $table) {
            $table->dropConstrainedForeignId('closed_by_collaborator_id');
        });
    }
};