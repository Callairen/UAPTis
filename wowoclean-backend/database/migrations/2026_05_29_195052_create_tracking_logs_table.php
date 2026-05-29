<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tracking_logs', function (Blueprint $table) {
            $table->id();
            $table->string('container_id');
            $table->string('location');
            $table->timestamp('timestamp');
            $table->text('description');
            $table->timestamps();

            $table->foreign('container_id')
                  ->references('container_id')
                  ->on('containers')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tracking_logs');
    }
};