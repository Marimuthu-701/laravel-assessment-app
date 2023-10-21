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
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->string('author')->nullable()->comment('Author');
            $table->text('title')->nullable()->comment('Title');
            $table->text('description')->nullable()->comment('Description');
            $table->text('content')->nullable()->comment('Content');
            $table->text('url')->nullable()->comment('URL');
            $table->text('url_to_image')->nullable()->comment('url to image');
            $table->timestamp('published_at')->nullable()->comment('Published At');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};
