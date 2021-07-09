<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContributionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contributions', function (Blueprint $table) {
            $table->id();
            $table->string('contribution_id');
            $table->string('customer_id');
            $table->float('amount');
            $table->string('savings_type');
            $table->string('collected_by');
            $table->string('posted_by');
            $table->string('approved_by');
            $table->decimal('balance');
            $table->decimal('gain');
            $table->decimal('loan')->nullable();
            $table->string('request_type');
            $table->timestamp('collected_on', $precision = 0)->useCurrent();
            $table->string('status');
            $table->text('description');
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
        Schema::dropIfExists('contributions');
    }
}
