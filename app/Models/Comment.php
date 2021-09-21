<?php

namespace App\Models;

use App\Models\Post;
use App\Models\User;
use App\Models\Video;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
  use HasFactory;

  // Relacion 1 a N polomorfica
  public function commentable()
  {
    return $this->morphTo();
  }

  // Relacion 1 a N inversa
  public function user()
  {
    return $this->belongsTo(User::class);
  }

  // Relacion 1 a N inversa plimorfica
  public function posts()
  {
    return $this->morphedByMany(Post::class, 'taggeable');
  }
  public function videos()
  {
    return $this->morphedByMany(Video::class, 'taggeable');
  }
}
