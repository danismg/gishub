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
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            // category. name, brand, total, kondisi, usur, noted -> nullable
            $table->string('category');
            $table->string('name');
            $table->string('brand')->nullable();
            $table->string('total')->nullable();
            // enum status -> new, old,broken, Null
            $table->enum('status', ['new', 'good', 'broken', 'null']);
            $table->string('user')->nullable();
            $table->string('noted')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};
