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
        $table->string('name');
        $table->string('discount');
        $table->string('location');
        $table->string('image_url');
        $table->decimal('original_price', 10, 2);
        $table->decimal('discounted_price', 10, 2);
        $table->date('valid_until')->nullable();
        $table->boolean('is_active')->default(true);
        $table->text('description')->nullable();
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
