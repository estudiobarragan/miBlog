<?php

namespace App\Models;

use App\Models\Post;
use App\Models\Video;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Maize\Markable\Markable;
use Maize\Markable\Models\Favorite;

class Tag extends Model
{
  use HasFactory;
  use Markable;

  protected $fillable = ['name', 'slug', 'color'];

  protected static $marks = [
    Favorite::class,
  ];

  public function getRouteKeyName()
  {
    return "slug";
  }

  // Relacion N a N inversa plimorfica
  public function posts()
  {
    return $this->morphedByMany(Post::class, 'taggable');
  }
  public function videos()
  {
    return $this->morphedByMany(Video::class, 'taggable');
  }
}
