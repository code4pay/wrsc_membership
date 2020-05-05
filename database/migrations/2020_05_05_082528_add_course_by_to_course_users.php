<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCourseByToCourseUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('course_users', function (Blueprint $table) {
            $table->text('course_by')->nullable();
            $table->longText('comment')->nullable();
            $table->date('date_completed')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('course_users', function (Blueprint $table) {
            $table->dropColumn('course_by');
            $table->dropColumn('comment');
            $table->dropColumn('date_completed');
        });
    }
}
