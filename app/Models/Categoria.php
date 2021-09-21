<?php

namespace App\Models;

use App\Models\Post;
use App\Models\Video;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
  use HasFactory;

  protected $fillable = ['name', 'slug'];

  public function getRouteKeyName()
  {
    return "slug";
  }

  // Relacion 1 a N
  public function posts()
  {
    return $this->hasMany(Post::class);
  }
  public function videos()
  {
    return $this->hasMany(Video::class);
  }
}
