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
        Schema::create('product_prices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('provider_id');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('product_id');
            $table->foreign('provider_id')->references('id')->on('providers');
            $table->foreign('category_id')->references('id')->on('categories');
            $table->foreign('product_id')->references('id')->on('products');

            $table->double('consumer_price_in_sp')->default(0);
            $table->double('consumer_price_in_dollar')->default(0);
            
            $table->double('cost_price_in_sp_piece')->default(0);
            $table->double('cost_price_in_dollar_piece')->default(0);

            $table->double('sale_price_in_sp')->default(0);
            $table->double('sale_price_in_dollar')->default(0);

            $table->double('special_price_in_sp')->default(0);
            $table->double('special_price_in_dollar')->default(0);
            
            $table->double('quantity_price_in_sp')->default(0);
            $table->double('quantity_price_in_dollar')->default(0);
            
            $table->double('half_quantity_price_in_sp')->default(0);
            $table->double('half_quantity_price_in_dollar')->default(0);

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
        Schema::dropIfExists('product_prices');
    }
};
