<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldCustomersType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->string('firstName')->nullable()->change();
            $table->string('lastName')->nullable()->change();
            $table->string('email')->nullable()->change();
            $table->string('address')->nullable()->change();
            $table->string('lon')->nullable()->change();
            $table->string('lat')->nullable()->change();
            $table->integer('type_id')->unsigned()->nullable();
            $table->foreign('type_id')->references('id')->on('customers_type');
            $table->string('service_type')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customers', function(Blueprint $table){
            $table->string('firstName')->change();
            $table->string('lastName')->change();
            $table->string('email')->change();
            $table->string('address')->change();
            $table->string('lon')->change();
            $table->string('lat')->change();
            $table->dropForeign(['type_id']);
            $table->dropColumn('type_id');
            $table->dropColumn('service_type');
        });
    }
}
