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
    Schema::create('ranks', function (Blueprint $table) {
      $table->string('id', 6)->primary();
      $table->string('name');
      $table->unsignedFloat('min_value', 3, 1);
      $table->unsignedFloat('max_value', 3, 1);
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('ranks');
  }
};
