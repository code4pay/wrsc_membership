<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuthoritiesUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('authorities_users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('authority_id');
            $table->date('date_authorised')->nullable();
            $table->text('comment')->nullable ();
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
        Schema::dropIfExists('authorities_users');
    }
}
