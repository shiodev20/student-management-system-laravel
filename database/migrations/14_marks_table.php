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
    Schema::create('marks', function (Blueprint $table) {
      $table->id();
      $table->string('year_id', 6);
      $table->string('semester_id', 6);
      $table->string('classroom_id', 10);
      $table->string('subject_id', 6);
      $table->string('student_id', 10);
      $table->string('mark_type_id', 6);
      $table->unsignedFloat('mark', 3, 1)->default(0.0);

      $table->foreign('year_id')->references('id')->on('years');
      $table->foreign('semester_id')->references('id')->on('semesters');
      $table->foreign('classroom_id')->references('id')->on('classrooms');
      $table->foreign('subject_id')->references('id')->on('subjects');
      $table->foreign('student_id')->references('id')->on('students');
      $table->foreign('mark_type_id')->references('id')->on('mark_types');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('marks');
  }
};
