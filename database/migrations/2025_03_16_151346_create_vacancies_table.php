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
        Schema::create('vacancies', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('employment_type');
            $table->string('job_location_type');
            $table->string('location')->nullable();
            $table->string('salary_frequency');
            $table->string('salary');
            $table->unsignedBigInteger('employer_id');
            $table->foreign('employer_id')->references('id')
                ->on('users')->onDelete('cascade');
            $table->text('full_description');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vacancies');
    }
};
