<?php

use App\Models\Person;
use App\Models\Role;
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
        Schema::create('show_crew', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignIdFor(Show::class)->constrained();
            $table->foreignIdFor(Role::class)->constrained();
            $table->foreignIdFor(Person::class)->constrained();
            $table->string('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
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
