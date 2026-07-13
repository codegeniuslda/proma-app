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
        Schema::table('time_entries', function (Blueprint $table) {
            if (Schema::hasColumn('time_entries', 'workload_hours')) {
                $table->dropColumn('workload_hours');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('time_entries', function (Blueprint $table) {
            if (!Schema::hasColumn('time_entries', 'workload_hours')) {
                $table->decimal('workload_hours', 8, 2)->default(0)->after('establishment');
            }
        });
    }
};