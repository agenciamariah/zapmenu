<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRestorantAd1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('restorants', function($table) {
            $table->string('ad1_image');
            $table->string('ad1_link');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('restorants', function($table) {
            $table->dropColumn('ad1_image');
            $table->dropColumn('ad1_link');
        });

    }
}
