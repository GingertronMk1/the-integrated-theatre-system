<?php

use App\Models\Show;
use App\Models\Venue;
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
        Schema::create('performances', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignIdFor(Show::class)->constrained();
            $table->dateTime('show_start')->nullable();
            $table->foreignIdFor(Venue::class)->constrained();
            $table->unsignedInteger('capacity');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('performances');
    }
};
