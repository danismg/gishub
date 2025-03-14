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
        Schema::create('doc_audits', function (Blueprint $table) {
            $table->id();
            $table->string('persyaratan');
            $table->string('file');
            $table->string('status')->default('pending');
            // noted
            $table->text('noted')->nullable();


            // auditors
            $table->foreignId('report_id')->constrained()->onDelete('cascade');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doc_audits');
    }
};
