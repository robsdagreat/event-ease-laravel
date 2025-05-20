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
        Schema::create('specials', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('establishment_name'); // Name of the restaurant/hotel
            $table->string('establishment_type'); // restaurant, hotel, cafe, etc.
            $table->string('location'); // Where the establishment is located
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->string('type'); // couple, weekend, valentine, holiday, other
            $table->decimal('discount_percentage', 5, 2);
            $table->string('image_url')->nullable();
            $table->boolean('is_active')->default(true);
            $table->json('terms')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('contact_phone')->nullable();
            $table->string('website')->nullable();
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
        Schema::dropIfExists('specials');
    }
};
