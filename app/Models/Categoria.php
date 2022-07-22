<?php

namespace App\Models;

use App\Models\Post;
use App\Models\Video;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Maize\Markable\Markable;
use Maize\Markable\Models\Favorite;

class Categoria extends Model
{
  use HasFactory;
  use Markable;

  protected $fillable = ['name', 'slug'];

  protected static $marks = [
    Favorite::class,
  ];

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
