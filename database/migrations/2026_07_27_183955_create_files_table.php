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

            /*
            |--------------------------------------------------------------------------
            | Owner
            |--------------------------------------------------------------------------
            */
            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            /*
            |--------------------------------------------------------------------------
            | File Information
            |--------------------------------------------------------------------------
            */

            // Original filename (Visible to user)
            $table->string('original_name');

            // Random filename used in storage
            $table->string('stored_name')->nullable();

            // Local storage path (Only used by Local Driver)
            $table->string('file_path')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Telegram Storage
            |--------------------------------------------------------------------------
            */

            $table->string('telegram_file_id')->nullable();

            $table->bigInteger('telegram_message_id')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Storage Driver
            |--------------------------------------------------------------------------
            */

            // local | telegram | s3 | gdrive | dropbox
            $table->string('storage_driver')->default('local');

            /*
            |--------------------------------------------------------------------------
            | Metadata
            |--------------------------------------------------------------------------
            */

            $table->string('mime_type');

            $table->unsignedBigInteger('file_size');

            // SHA-256 checksum
            $table->string('checksum', 64)->nullable();

            /*
            |--------------------------------------------------------------------------
            | User Options
            |--------------------------------------------------------------------------
            */

            $table->boolean('is_favorite')->default(false);

            /*
            |--------------------------------------------------------------------------
            | Soft Delete
            |--------------------------------------------------------------------------
            */

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