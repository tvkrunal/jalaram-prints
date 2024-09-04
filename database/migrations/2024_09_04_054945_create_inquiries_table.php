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
        Schema::create('inquiries', function (Blueprint $table) {
            $table->id();
            $table->string('customer_first_name');
            $table->string('customer_last_name')->nullable();
            $table->integer('customer_contact_no');
            $table->string('email')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->integer('pin_code')->nullable();
            $table->string('type_of_job')->nullable();
            $table->date('delivery_date')->nullable();
            $table->string('designing_details')->nullable();
            $table->bigInteger('price_masters_id')->nullable()->unsigned()->index();
	        $table->foreign('price_masters_id')->references('id')->on('price_masters')->onDelete('cascade');
            $table->bigInteger('user_id')->nullable()->unsigned()->index();
	        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->longText('job_description')->nullable();
            $table->string('process')->nullable();
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
        Schema::dropIfExists('inquiries');
    }
};
