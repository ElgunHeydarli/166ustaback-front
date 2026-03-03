<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->json('images')->nullable()->after('image');
            $table->json('advantages')->nullable()->after('content');
            $table->json('steps_title')->nullable()->after('advantages');
            $table->json('steps_subtitle')->nullable()->after('steps_title');
            $table->json('steps')->nullable()->after('steps_subtitle');
        });
    }

    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn(['images', 'advantages', 'steps_title', 'steps_subtitle', 'steps']);
        });
    }
};
