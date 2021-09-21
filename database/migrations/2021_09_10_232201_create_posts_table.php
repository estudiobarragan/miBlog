<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('posts', function (Blueprint $table) {
      $table->id();
      $table->string('name');
      $table->string('slug')->unique();
      $table->text('extract')->nullable();
      $table->longText('body')->nullable();
      $table->unsignedBigInteger('user_id')->nullable();
      $table->unsignedBigInteger('editor_id')->nullable();
      $table->unsignedBigInteger('publicador_id')->nullable();
      $table->unsignedBigInteger('categoria_id')->nullable();
      $table->unsignedBigInteger('state_id')->nullable();
      $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
      $table->foreign('editor_id')->references('id')->on('users')->onDelete('set null');
      $table->foreign('publicador_id')->references('id')->on('users')->onDelete('set null');
      $table->foreign('categoria_id')->references('id')->on('categorias')->onDelete('set null');
      $table->foreign('state_id')->references('id')->on('states')->onDelete('cascade');
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
    Schema::dropIfExists('posts');
  }
}
