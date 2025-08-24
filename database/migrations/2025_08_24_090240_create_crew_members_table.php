<?php

use App\Models\CrewRole;
use App\Models\Person;
use App\Models\Show;
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
        Schema::create('crew_members', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignIdFor(CrewRole::class)->constrained();
            $table->foreignIdFor(Person::class)->constrained();
            $table->foreignIdFor(Show::class)->constrained();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('crew_members');
    }
};
