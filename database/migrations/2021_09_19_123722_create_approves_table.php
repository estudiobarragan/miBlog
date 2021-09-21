<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApprovesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('approves', function (Blueprint $table) {
      $table->id();
      $table->enum('level', [1, 2, 3])->default(1); // Inicial - Intermedio - Avanzado
      $table->integer('timeToRead')->default(10); // minutos
      $table->boolean('linksSource')->default(false);
      $table->boolean('understandable')->default(false);
      $table->boolean('title')->default(false);
      $table->boolean('image')->default(false);
      $table->boolean('summary')->default(false);
      $table->boolean('conclusion')->default(false);
      $table->boolean('examples')->default(false);
      $table->boolean('tagRight')->default(false);
      $table->boolean('categoryRight')->default(false);
      $table->text('feedback')->nullable();
      $table->enum('approved', [0, 1, 2, 3])->default(1); //Cancelado-Guardar-Aprobado-Rechazado
      $table->unsignedBigInteger('post_id')->unique();
      $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('approves');
  }
}
