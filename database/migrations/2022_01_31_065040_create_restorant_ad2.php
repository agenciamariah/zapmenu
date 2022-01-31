<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRestorantAd2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('restorants', function($table) {
            $table->longText('ad2_image');
            $table->longText('ad2_link');
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
            $table->dropColumn('ad2_image');
            $table->dropColumn('ad2_link');
        });

    }
}
