<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameOutfordelPickupdate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('messengerial', function (Blueprint $table) {
            $table->renameColumn('outfordel_pickupdate','outfordel_date');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('messengerial', function (Blueprint $table) {
            //
        });
    }
}
