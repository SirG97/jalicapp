<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('customer_id');
            $table->string('title');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->string('marital_status')->nullable();
            $table->string('sex')->nullable();
            $table->string('dob')->nullable();
            $table->string('occupation')->nullable();
            $table->string('address')->nullable();
            $table->string('image')->nullable();
            $table->string('saving_period')->nullable();
            $table->string('amount');
            $table->text('purpose')->nullable();
            $table->string('account_number')->nullable();
            $table->string('account_name')->nullable();
            $table->string('bank')->nullable();
            $table->string('kin_name')->nullable();
            $table->text('kin_address')->nullable();
            $table->string('kin_relationship')->nullable();
            $table->string('kin_image')->nullable();
            $table->string('branch')->nullable();
            $table->string('unit_manager')->nullable();
            $table->string('unit_manager_phone')->nullable();
            $table->string('office')->nullable();
            $table->string('user_id');
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
        Schema::dropIfExists('customers');
    }
}
