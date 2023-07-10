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
    Schema::create('rules', function (Blueprint $table) {
      $table->id();
      $table->unsignedInteger('class_size', false);
      $table->unsignedInteger('max_age', false);
      $table->unsignedInteger('min_age', false);
      $table->unsignedFloat('pass_mark', false);
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('rules');
  }
};
