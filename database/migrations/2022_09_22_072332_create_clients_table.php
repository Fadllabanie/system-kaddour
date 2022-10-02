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
        Schema::create('clients', function (Blueprint $table) {
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
            $table->string('logo');
            $table->string('website');
            $table->string('whatsapp');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('country_id');
            $table->unsignedBigInteger('city_id');
            $table->unsignedBigInteger('location_id');
            $table->unsignedBigInteger('client_type_id');
            $table->char('currency');
            $table->decimal('lat', 12, 8);
            $table->decimal('lng', 12, 8);
            $table->string('dealing_way');
            $table->double('dealing_number');

            $table->foreign('category_id')->references('id')->on('categories');
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
        Schema::dropIfExists('clients');
    }
};
