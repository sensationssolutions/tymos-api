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
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
          
            $table->text('address')->nullable(); // address
            $table->string('email')->nullable(); // email
            $table->string('phone')->nullable(); // phone number
            $table->text('location')->nullable(); //location
            $table->text('facebook')->nullable(); // facebaooklink
            $table->text('twitter')->nullable(); // twitterlink
            $table->text('linkedin')->nullable(); // linkedinlink
            $table->text('pinterest')->nullable(); // facebaooklink
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
