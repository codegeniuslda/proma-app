<?php

use App\Models\Collaborator;
use App\Models\Establishment;
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
        Schema::table('collaborators', function (Blueprint $table) {
            $table->foreignId('establishment_id')->nullable()->after('id')->constrained('establishments')->nullOnDelete();
        });

        Collaborator::query()->select('id', 'establishment')->chunkById(100, function ($collaborators): void {
            foreach ($collaborators as $collaborator) {
                if (!$collaborator->establishment) {
                    continue;
                }

                $establishment = Establishment::firstOrCreate([
                    'name' => $collaborator->establishment,
                ]);

                $collaborator->establishment_id = $establishment->id;
                $collaborator->save();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('collaborators', function (Blueprint $table) {
            $table->dropConstrainedForeignId('establishment_id');
        });
    }
};