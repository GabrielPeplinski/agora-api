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
        Schema::create('solicitations', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('report');
            $table->string('status');
            $table->string('latitude_coordinate');
            $table->string('longitude_coordinate');
            $table->foreignId('user_id')->constrained();
            $table->foreignId('solicitation_category_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('solicitations');
    }
};
