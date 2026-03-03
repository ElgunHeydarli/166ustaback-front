<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('home_why_us', function (Blueprint $table) {
            $table->id();
            $table->json('title')->nullable();
            $table->json('subtitle')->nullable();
            $table->json('items')->nullable(); // [{title:{az,en,ru}, description:{az,en,ru}, image:path}]
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('home_why_us');
    }
};
