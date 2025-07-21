<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('prediction_records', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('anak_id');
            $table->unsignedBigInteger('antropometry_record_id');
            $table->string('status_stunting');
            $table->string('status_underweight');
            $table->string('status_wasting');
            $table->text('recommendation')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('anak_id')->references('id')->on('anaks')->onDelete('cascade');
            $table->foreign('antropometry_record_id')->references('id')->on('antropometry_records')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prediction_records');
    }
};
