<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('careers', function (Blueprint $table) {
            $table->id(); // auto-increment 'id' field
            $table->string('title');
            $table->text('description');
            $table->boolean('status')->default(1); // 1 = active, 0 = inactive
            $table->timestamps(); // adds created_at and updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('careers');
    }
};
