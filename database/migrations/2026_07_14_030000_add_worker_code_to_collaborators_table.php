<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('collaborators', function (Blueprint $table) {
            $table->string('worker_code', 50)->nullable()->after('name');
        });

        $collaborators = \Illuminate\Support\Facades\DB::table('collaborators')
            ->select('id')
            ->orderBy('id')
            ->get();

        foreach ($collaborators as $collaborator) {
            \Illuminate\Support\Facades\DB::table('collaborators')
                ->where('id', $collaborator->id)
                ->update(['worker_code' => 'TRAB-' . str_pad((string) $collaborator->id, 5, '0', STR_PAD_LEFT)]);
        }

        Schema::table('collaborators', function (Blueprint $table) {
            $table->string('worker_code', 50)->nullable(false)->change();
            $table->unique('worker_code');
        });
    }

    public function down(): void
    {
        Schema::table('collaborators', function (Blueprint $table) {
            $table->dropUnique('collaborators_worker_code_unique');
            $table->dropColumn('worker_code');
        });
    }
};