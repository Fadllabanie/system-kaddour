<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('providers', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('mobile');
            $table->string('phone');
            $table->string('tel');
            $table->string('email');
            $table->string('password');
            $table->string('address');
            $table->string('website');
            $table->string('whatsapp');
            $table->string('logo');
            $table->unsignedBigInteger('country_id');
            $table->unsignedBigInteger('city_id');
            $table->unsignedBigInteger('location_id');
            $table->unsignedBigInteger('client_type_id');
            $table->char('currency');
            $table->double('lat');
            $table->double('lng');
            $table->string('dealing_way');
            $table->double('dealing_number');
            $table->foreign('country_id')->references('id')->on('countries');
            $table->foreign('city_id')->references('id')->on('cities');
            $table->foreign('location_id')->references('id')->on('locations');
            $table->foreign('client_type_id')->references('id')->on('client_types');
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
        Schema::dropIfExists('providers');
    }
};
