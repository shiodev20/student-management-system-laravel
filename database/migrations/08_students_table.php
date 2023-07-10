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
        Schema::create('students', function (Blueprint $table) {
            $table->string('id', 10)->primary();
            $table->string('first_name');
            $table->string('last_name');
            $table->boolean('gender');
            $table->date('dob');
            $table->string('address', 1000);
            $table->string('email');
            $table->string('parent_name');
            $table->string('parent_phone', 11);
            $table->timestamp('enroll_date')->useCurrent();
            $table->string('account_id', 10)->nullable();
            $table->unsignedBigInteger('role_id');
            $table->boolean('status')->default(1);
            $table->foreign('role_id')->references('id')->on('roles');
            $table->foreign('account_id')->references('id')->on('accounts');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
