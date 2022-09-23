<?php

namespace App\Models;

use App\Models\Post;
use App\Models\User;
use App\Models\Video;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Maize\Markable\Markable;
use Maize\Markable\Models\Reaction;

class Comment extends Model
{
  use HasFactory;
  use Markable;
  protected static $marks = [
    Reaction::class,
  ];

  protected $fillable = ['mensaje', 'user_id', 'commentable_id', 'commentable_type'];

  // Relacion 1 a N polomorfica
  public function commentable()
  {
    return $this->morphTo()->orderBy('id','DESC');
  }

  // Relacion 1 a N polomorfica
  public function replies()
  {
    return $this->morphMany(Comment::class, 'commentable')->orderBy('id','DESC');
  }

  // Relacion 1 a N inversa
  public function user()
  {
    return $this->belongsTo(User::class);
  }

  // Relacion 1 a N inversa polimorfica
  public function posts()
  {
    return $this->morphedByMany(Post::class, 'taggeable');
  }
  public function videos()
  {
    return $this->morphedByMany(Video::class, 'taggeable');
  }
}
