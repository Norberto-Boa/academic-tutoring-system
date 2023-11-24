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
    Schema::table('lecturer_student', function (Blueprint $table) {
      $table->string('topic');
      $table->string('proposal_url');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('lecturer_student', function (Blueprint $table) {
      //
    });
  }
};
