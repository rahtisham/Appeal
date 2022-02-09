<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class WalmartRatingReview extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('walmart_rating_review', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->nullable();
            $table->string('offerScore')->nullable();
            $table->string('ratingReviewScore')->nullable();
            $table->string('contentScore')->nullable();
            $table->string('itemDefectCnt')->nullable();
            $table->string('defectRatio')->nullable();
            $table->string('listingQuality')->nullable();
            $table->string('status')->nullable();
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
        Schema::dropIfExists('walmart_rating_review');
    }
}
