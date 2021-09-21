<?php

namespace App\Models;

use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
  use HasFactory;

  // Relacion 1 a N inversa
  public function user()
  {
    return $this->belongsTo(User::class);
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
    return $this->morphMany(Comments::class, 'commentable');
  }
  // Relacion N a N polimorfica
  public function tags()
  {
    return $this->morphToMany(Tag::class, 'taggable');
  }
}
