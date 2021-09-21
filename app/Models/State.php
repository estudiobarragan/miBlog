<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
  use HasFactory;

  // Relacion 1 a N
  public function posts()
  {
    return $this->hasMany(Post::class);
  }
}
