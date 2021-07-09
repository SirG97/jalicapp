<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('firstname');
            $table->string('lastname');
            $table->string('phone');
            $table->string('admin_right');
            $table->string('address')->nullable();
            $table->string('branch')->nullable();
            $table->string('unit_manager')->nullable();
            $table->string('job_title');
            $table->string('job_description')->nullable();
            $table->string('image')->nullable();
            $table->boolean('loggedin')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
