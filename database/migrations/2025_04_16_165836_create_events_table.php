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
            $table->foreignId('user_id')->constrained();
            $table->foreignId('venue_id')->constrained();
            $table->foreignId('event_type_id')->constrained();
            $table->string('name');
            $table->text('description');
            $table->string('image_url');
            $table->dateTime('date');
            $table->integer('capacity');
            $table->boolean('is_approved')->default(false);
            $table->string('host_type')->default('personal');
            $table->boolean('is_public')->default(false);
            $table->string('host_name')->nullable();
            $table->string('host_contact')->nullable();
            $table->text('host_description')->nullable();
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
