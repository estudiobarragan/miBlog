<?php

namespace App\Models;

use App\Models\Categoria;
use App\Models\Comment;
use App\Models\Image;
use App\Models\Publication;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Maize\Markable\Markable;
use Maize\Markable\Models\Bookmark;

class Post extends Model
{
  use HasFactory;
  use Markable;

  protected $guarded = ['id', 'updated_at'];
  protected static $marks = [
    Bookmark::class,
  ];

  public function getRouteKeyName()
  {
    return "slug";
  }

  // Relacion 1 a 1
  public function approve()
  {
    return $this->hasOne(Approve::class);
  }
  public function publication()
  {
    return $this->hasOne(Publication::class);
  }

  // Relacion 1 a N inversa
  public function user()
  {
    return $this->belongsTo(User::class);
  }
  public function editor()
  {
    return $this->belongsTo(User::class);
  }
  public function publicador()
  {
    return $this->belongsTo(User::class);
  }

  public function state()
  {
    return $this->belongsTo(State::class);
  }

  public function categoria()
  {
    return $this->belongsTo(Categoria::class);
  }

  // Relacion 1 a 1 polomorfica
  public function image()
  {
    return $this->morphOne(Image::class, 'imageable');
  }

  // Relacion 1 a N polomorfica
  public function comments()
  {
    return $this->morphMany(Comment::class, 'commentable');
  }

  // Relacion N a N polimorfica
  public function tags()
  {
    return $this->morphToMany(Tag::class, 'taggable');
  }
}
