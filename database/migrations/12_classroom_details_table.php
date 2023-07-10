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
    Schema::create('classroom_details', function (Blueprint $table) {
      $table->id();
      $table->string('classroom_id', 10);
      $table->string('student_id', 10);
      $table->foreign('classroom_id')->references('id')->on('classrooms');
      $table->foreign('student_id')->references('id')->on('students');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('classroom_details');
  }
};
