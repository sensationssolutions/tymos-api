<?php

use App\Models\Service;
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
        Schema::create('services', function (Blueprint $table) {
            $table->id();

            $table->string('image_url', 500)->nullable();
            $table->string('image_title', 500)->nullable();
            $table->integer('image_size')->nullable();
            $table->string('image_ext', 45)->nullable();
            $table->string('image_token', 500)->nullable();
            $table->string('title')->nullable(); 
            $table->text('content')->nullable(); 

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
