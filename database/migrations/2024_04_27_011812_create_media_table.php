<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('MediaId');
            $table->morphs('model'); // Polymorphic relationship with other models
            $table->uuid()->nullable()->unique(); // Optional unique identifier
            $table->string('collection_name');
            $table->string('name'); // Override default name (optional)
            $table->text('content'); // Override default content (optional)
            $table->string('disk'); // Disk where the file is stored (optional)
            $table->string('size');
            $table->string('mime_type');
            $table->string('path'); // Path to the file on the disk
            $table->longText('conversions')->nullable(); // JSON storing conversion details
            $table->text('responsive_images')->nullable(); // JSON storing responsive image details (Spatie Media Library v6+)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('media');
    }
}
