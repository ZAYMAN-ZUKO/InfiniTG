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
        Schema::create('files', function (Blueprint $table) {

            $table->id();

            // Owner
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // File Information
            $table->string('file_name');
            $table->string('original_name');
            $table->string('file_path');

            // Metadata
            $table->string('mime_type');
            $table->unsignedBigInteger('file_size');

            // Favorite
            $table->boolean('is_favorite')->default(false);

            // Trash (Soft Delete)
            $table->softDeletes();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('files');
    }
};