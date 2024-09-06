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
        Schema::create('inquiry_processes', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('inquiry_id')->nullable()->unsigned()->index();
	        $table->foreign('inquiry_id')->references('id')->on('inquiries')->onDelete('cascade');
            $table->string('title')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inquiry_processes');
    }
};
