<?php

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
        Schema::create('cast_members', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Show::class);
            $table->foreignIdFor(Person::class);
            $table->string('role_name');
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
        Schema::dropIfExists('cast_members');
    }
};
