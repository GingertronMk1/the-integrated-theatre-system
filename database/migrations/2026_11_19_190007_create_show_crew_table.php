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
        Schema::create('show_crew', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('show_id')->constrained();
            $table->foreignUuid('role_id')->constrained();
            $table->foreignUuid('person_id')->constrained();
            $table->string('notes')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('show_crew');
    }
};
