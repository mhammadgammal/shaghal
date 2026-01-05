<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('jobـvacancies', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title');
            $table->mediumText('description');
            $table->string('location');
            $table->string('salary');
            $table->enum('type', ['full-time', 'hybrid', 'contract', 'remote'])->default('full-time');
            $table->timestamps();
            $table->softDeletes();

            // Relationships
            $table->uuid('companyId');
            $table->foreign('companyId')->references('id')->on('companies')->restrictOnDelete();

            $table->uuid('jobCategoryId');
            $table->foreign('jobCategoryId')->references('id')->on('job_categories')->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job-vacancies');
    }
};
