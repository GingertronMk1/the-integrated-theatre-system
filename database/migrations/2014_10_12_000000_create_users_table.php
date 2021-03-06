<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->boolean('can_train_all')->default(false);
            $table->boolean('superadmin')->default(false);
            $table->json('flags');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();

        });

        $user = new User();
        $user->name = "Admin";
        $user->email = "admin@tits.test";
        $user->email_verified_at = now();
        $user->password = bcrypt("admin");
        $user->can_train_all = true;
        $user->superadmin = true;
        $user->flags = [ User::FLAG_INITIAL_SUPERADMIN ];
        $user->save();

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
