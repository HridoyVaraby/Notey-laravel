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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('description')->nullable();
            $table->timestamps();
        });

        // Insert default categories
        DB::table('categories')->insert([
            ['name' => 'All', 'slug' => 'all', 'description' => 'All notes', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Important', 'slug' => 'important', 'description' => 'Important notes', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Bookmarked', 'slug' => 'bookmarked', 'description' => 'Bookmarked notes', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};