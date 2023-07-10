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
    Schema::create('teachers', function (Blueprint $table) {
      $table->string('id', 10)->primary();
      $table->string('first_name');
      $table->string('last_name');
      $table->boolean('gender');
      $table->date('dob');
      $table->string('address', 1000);
      $table->string('email');
      $table->string('phone', 11);
      $table->string('account_id', 10)->nullable();
      $table->unsignedBigInteger('role_id');
      $table->string('subject_id', 6);
      $table->foreign('account_id')->references('id')->on('accounts');
      $table->foreign('role_id')->references('id')->on('roles');
      $table->foreign('subject_id')->references('id')->on('subjects');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('teachers');
  }
};
