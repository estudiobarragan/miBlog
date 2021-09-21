<?php

namespace App\Models;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
  use HasFactory;

  protected $fillable = ['name', 'slug', 'color'];

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
