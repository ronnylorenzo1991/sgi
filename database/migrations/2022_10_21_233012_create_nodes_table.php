<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nodes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ip_id')->nullable();
            $table->unsignedBigInteger('entity_id')->nullable();
            $table->unsignedBigInteger('ministry_id')->nullable();
            $table->unsignedBigInteger('internet_link_id')->nullable();
            $table->unsignedBigInteger('country_id')->nullable();

            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
            $table->foreign('ip_id')->references('id')->on('ips')->onDelete('cascade');
            $table->foreign('entity_id')->references('id')->on('entities')->onDelete('cascade');
            $table->foreign('ministry_id')->references('id')->on('ministries')->onDelete('cascade');
            $table->foreign('internet_link_id')->references('id')->on('internet_links')->onDelete('cascade');
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
        Schema::dropIfExists('nodes');
    }
}
