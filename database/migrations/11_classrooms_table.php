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
        Schema::create('classrooms', function (Blueprint $table) {
            $table->string('id', 10)->primary();
            $table->string('name');
            $table->unsignedInteger('size')->default(0);
            $table->string('grade_id', 6);
            $table->string('year_id', 6);
            $table->string('head_teacher_id', 10)->nullable();
            $table->foreign('grade_id')->references('id')->on('grades');
            $table->foreign('year_id')->references('id')->on('years');
            $table->foreign('head_teacher_id')->references('id')->on('teachers');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classrooms');
    }
};
