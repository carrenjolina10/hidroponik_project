<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ai_predictions', function (Blueprint $table) {
            $table->id();
            $table->string('filename');
            $table->string('prediction');
            $table->decimal('confidence', 5, 4);
            $table->string('model')->default('EfficientNet-B0');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ai_predictions');
    }
};