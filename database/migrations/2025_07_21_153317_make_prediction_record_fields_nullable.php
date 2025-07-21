<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('prediction_records', function (Blueprint $table) {
            $table->string('status_stunting', 50)->nullable()->change();
            $table->string('status_underweight', 50)->nullable()->change();
            $table->string('status_wasting', 50)->nullable()->change();
            $table->text('recommendation')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('prediction_records', function (Blueprint $table) {
            $table->string('status_stunting', 50)->nullable(false)->change();
            $table->string('status_underweight', 50)->nullable(false)->change();
            $table->string('status_wasting', 50)->nullable(false)->change();
            $table->text('recommendation')->nullable(false)->change();
        });
    }
};
