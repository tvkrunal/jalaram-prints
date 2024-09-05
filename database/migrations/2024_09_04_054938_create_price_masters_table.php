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
        Schema::create('price_masters', function (Blueprint $table) {
            $table->id();
            $table->string('item_type');
            $table->string('media')->nullable();
            $table->string('gsm')->nullable();
            $table->integer('qty')->nullable();
            $table->integer('min_cost')->nullable();
            $table->integer('max_cost')->nullable();
            $table->bigInteger('user_id')->nullable()->unsigned()->index();
	        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('price_masters');
    }
};
