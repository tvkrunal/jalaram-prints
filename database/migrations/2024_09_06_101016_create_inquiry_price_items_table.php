<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('inquiry_price_items', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('inquiry_id')->nullable()->unsigned()->index();
	        $table->foreign('inquiry_id')->references('id')->on('inquiries')->onDelete('cascade');
            $table->bigInteger('price_master_id')->nullable()->unsigned()->index();
	        $table->foreign('price_master_id')->references('id')->on('price_masters')->onDelete('cascade');
            $table->string('media')->nullable();
            $table->string('gsm')->nullable();
            $table->integer('qty')->nullable();
            $table->integer('cost')->nullable();
            $table->string('total_hours')->nullable();
            $table->string('cost_calculation')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inquiry_price_items');
    }
};
