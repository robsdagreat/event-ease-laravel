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
    Schema::create('events', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->text('description');
        $table->dateTime('start_time');
        $table->dateTime('end_time');
        $table->string('event_type');
        $table->foreignId('venue_id')->constrained();
        $table->string('venue_name');
        $table->foreignId('user_id')->constrained();
        $table->string('organizer_name');
        $table->boolean('is_public')->default(false);
        $table->integer('expected_attendees')->default(0);
        $table->string('image_url')->nullable();
        $table->enum('status', ['draft', 'published', 'cancelled'])->default('draft');
        $table->decimal('ticket_price', 10, 2)->nullable();
        $table->json('tags')->nullable();
        $table->string('contact_email')->nullable();
        $table->string('contact_phone')->nullable();
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
        Schema::dropIfExists('events');
    }
};
