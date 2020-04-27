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
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();

            $table->string("address")->nullable();
            $table->string("city")->nullable();
            $table->enum('state',['NSW','VIC','ACT','QLD','SA','WA','NT','TAS'])->default('NSW');
            $table->string('country')->default('Australia')->nullable();
            $table->string('post_code')->nullable();
            
            $table->string("address_residential")->nullable();
            $table->string("city_residential")->nullable();
            $table->enum('state_residential',['NSW','VIC','ACT','QLD','SA','WA','NT','TAS'])->default('NSW');
            $table->string('country_residential')->default('Australia');
            $table->string('post_code_residential')->nullable();

            $table->string('member_number')->nullable();
            $table->string('wildman_number')->nullable();
            $table->integer('region_id')->nullable();
            $table->string('mobile')->nullable();
            $table->string('home_phone')->nullable();
            $table->date('joined')->nullable();
            $table->date('application')->nullable();
            $table->date('paid_to')->nullable();
            $table->date('lyssa_serology_date')->nullable();
            $table->date('lyssa_serology_value')->nullable();
            $table->integer('member_type_id')->default(1);
            $table->integer('primary_member_id')->nullable()->comment('if this is a related member this is the primary member.');
            $table->date('tac_date')->nullable()->comment('Terms And Conditions acceptance date');

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
