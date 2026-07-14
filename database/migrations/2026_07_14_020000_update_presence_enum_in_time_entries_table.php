<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE time_entries MODIFY presence ENUM('Presente','Ausente','Justificado') NOT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE time_entries MODIFY presence ENUM('Presente','Nao Presente') NOT NULL");
    }
};