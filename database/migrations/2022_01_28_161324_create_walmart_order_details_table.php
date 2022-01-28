<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWalmartOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        Schema::create('walmart_order_details', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->nullable();
            $table->string('purchaseOrderId')->nullable();
            $table->string('customerOrderId')->nullable();
            $table->string('order_date')->nullable();
            $table->string('estimatedDeliveryDate')->nullable();
            $table->string('estimatedShipDate')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->nullable();
            $table->string('status')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('cancellationReason')->nullable();
            $table->string('shippingProgramType')->nullable();
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
        Schema::dropIfExists('walmart_order_details');
    }
}
