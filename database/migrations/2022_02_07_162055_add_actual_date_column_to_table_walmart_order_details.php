<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddActualDateColumnToTableWalmartOrderDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('walmart_order_details', function (Blueprint $table) {
            $table->string('actualShipDate')->after('estimatedShipDate')->nullable();
            $table->string('actualDeliveryDate')->after('actualShipDate')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('walmart_order_details', function (Blueprint $table) {
            //
        });
    }
}
