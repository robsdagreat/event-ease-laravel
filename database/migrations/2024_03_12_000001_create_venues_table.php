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
    Schema::create('venues', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->text('description');
        $table->string('location');
        $table->string('address');
        $table->string('city');
        $table->string('state');
        $table->string('country');
        $table->string('postal_code');
        $table->decimal('latitude', 10, 8);
        $table->decimal('longitude', 11, 8);
        $table->string('venue_type');
        $table->integer('capacity');
        $table->decimal('rating', 3, 2)->default(0);
        $table->json('amenities');
        $table->json('images');
        $table->string('contact_email')->nullable();
        $table->string('contact_phone')->nullable();
        $table->string('website')->nullable();
        $table->json('pricing')->nullable();
        $table->json('special_offers')->nullable();
        $table->boolean('is_available')->default(true);
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
        Schema::dropIfExists('venues');
    }
};
