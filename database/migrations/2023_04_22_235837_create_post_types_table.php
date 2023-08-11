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
    Schema::create('post_types', function (Blueprint $table) {
      $table->id();
      $table->foreignId("post_id")->references("id")->on("posts")->cascadeOnDelete();
      $table->foreignId("type_id")->references("id")->on("types")->cascadeOnDelete();
      $table->integer("price");
      $table->date("start_date")->nullable();
      $table->date("end_date")->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('post_types');
  }
};
