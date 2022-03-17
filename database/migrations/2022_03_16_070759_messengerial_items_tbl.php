<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MessengerialItemsTbl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messengerial_items', function (Blueprint $table) {
            $table->id();
            $table->integer('messengerial_id');
            $table->string('agency');
            $table->string('recipient');
            $table->string('contact');
            $table->string('destination',1000);
            $table->string('delivery_item',1000);
            $table->string('instruction',1000)->nullable();

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
        Schema::dropIfExists('messengerial_items');
    }
}
