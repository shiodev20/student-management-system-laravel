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
        Schema::create('teaching_assignments', function (Blueprint $table) {
            $table->id();
            $table->string('classroom_id', 10);
            $table->string('subject_id', 6);
            $table->string('subject_teacher_id', 10)->nullable();
            $table->foreign('classroom_id')->references('id')->on('classrooms');
            $table->foreign('subject_id')->references('id')->on('subjects');
            $table->foreign('subject_teacher_id')->references('id')->on('teachers');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teaching_assignments');
    }
};
