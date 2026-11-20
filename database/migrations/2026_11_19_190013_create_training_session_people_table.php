<?php

use App\Models\Person;
use App\Models\TrainingSession;
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
        Schema::create('training_session_people', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignIdFor(TrainingSession::class)->constrained('training_session');
            $table->foreignIdFor(Person::class)->constrained();
            $table->enum('type', ['trainer', 'trainee']);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('training_session_people');
    }
};
