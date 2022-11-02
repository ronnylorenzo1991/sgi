<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('number');
            $table->string('observations')->nullable();
            $table->boolean('national_as_source')->default(false);
            $table->dateTime('date');

            $table->unsignedBigInteger('detected_by_id');
            $table->foreign('detected_by_id')->references('id')->on('sources')->onDelete('cascade');

            $table->unsignedBigInteger('contribute_id');
            $table->foreign('contribute_id')->references('id')->on('contributes')->onDelete('cascade');

            $table->integer('subcategory_id')->unsigned();
            $table->foreign('subcategory_id')->references('id')->on('subcategories')->onDelete('cascade');

            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');

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
        Schema::dropIfExists('events');
    }
}
