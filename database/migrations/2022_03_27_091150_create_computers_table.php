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
        Schema::create('computers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('brand_id')->index();
            $table->foreign('brand_id')->references('id')->on('brands')->cascadeOnDelete();
            $table->string('name');
            $table->string('slug')->index();
            $table->string('model_number');
            $table->string('serial_number')->unique();
            $table->text('description')->nullable();
            $table->unsignedFloat('price')->default(0);
            $table->unsignedInteger('stock')->default(0);
            $table->unsignedInteger('discount_percent')->default(0);
            $table->dateTime('discount_datetime_start')->useCurrent();
            $table->dateTime('discount_datetime_end')->useCurrent();
            $table->boolean('credit')->default(0);
            $table->boolean('recommend')->default(0);
            $table->unsignedInteger('sold')->default(0);
            $table->unsignedInteger('viewed')->default(0);
            $table->unsignedInteger('favorited')->default(0);
            $table->unsignedInteger('random')->default(0);
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
        Schema::dropIfExists('computers');
    }
};
