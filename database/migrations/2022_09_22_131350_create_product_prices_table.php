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
            $table->double('sp_price');
            $table->double('dollar_price');

            $table->double('consumer_price_in_sp');
            $table->double('consumer_price_in_dollar'); 
            
            $table->double('cost_price_in_sp_piece');
            $table->double('cost_price_in_dollar_piece');

            $table->double('cost_price_in_sp_piece');
            $table->double('cost_price_in_dollar_piece');


            $table->double('sale_price_in_sp');
            $table->double('sale_price_in_dollar');

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
