<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNullableToContributionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contributions', function (Blueprint $table) {
            $table->string('savings_type')->nullable()->change();
            $table->string('collected_by')->nullable()->change();
            $table->string('posted_by')->nullable()->change();
            $table->string('approved_by')->nullable()->change();
            $table->decimal('balance')->nullable()->change();
            $table->decimal('gain')->nullable()->change();
            $table->decimal('loan')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contributions', function (Blueprint $table) {
            //
        });
    }
}
