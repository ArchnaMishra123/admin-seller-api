<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
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
    $table->string('mobile');
    $table->string('country');
    $table->string('state');
     $table->string('profile_image')->nullable();
    $table->json('skills')->nullable();
    $table->string('password');
    $table->enum('role', ['ADMIN', 'SELLER']);
            $table->timestamps();
        });
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
}
