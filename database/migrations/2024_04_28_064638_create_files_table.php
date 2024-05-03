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
            $table->string('title')->nullable();
            $table->string('time');
            $table->string('name');
            $table->string('content');
            $table->string('mime_type');
            $table->string('file')->nullable();
            $table->string('file_path');
            $table->bigInteger('MediaId')->nullable();
            $table->nullableMorphs('model');
            $table->uuid()->nullable()->unique();
            $table->string('size');
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
