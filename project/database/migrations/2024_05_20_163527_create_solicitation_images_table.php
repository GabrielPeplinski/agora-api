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
        Schema::create('solicitation_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('solicitation_id')
                ->constrained('solicitations');
            $table->string('file_name');
            $table->string('file_path');
            $table->boolean('is_cover_image')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('solicitation_images');
    }
};
