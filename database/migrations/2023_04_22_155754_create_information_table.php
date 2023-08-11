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
    Schema::create('information', function (Blueprint $table) {
      $table->id();
      $table->string("name");
      $table->string("code");
      // $table->integer("row_num")->unique()->nullable();
      // $table->enum("type_row", ['left', 'right', 'full'])->default('full');
      $table->foreignId("category_id")->references("id")->on("categories")->cascadeOnDelete();
      // $table->enum('type', ['Dropdown', 'TextField', 'Segmented'])->default('Dropdown');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('information');
  }
};
