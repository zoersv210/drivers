<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropCreateNewFieldDriversTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('drivers', function(Blueprint $table){
            $table->dropColumn('firstName');
            $table->dropColumn('lastName');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('drivers', function(Blueprint $table){
            $table->dropColumn('first_name');
            $table->dropColumn('last_name');
            $table->string('firstName')->nullable();
            $table->string('lastName')->nullable();
        });
    }
}
