<?php

namespace App\Models;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Approve extends Model
{
  use HasFactory;

  protected $guarded = ['id', 'updated_at'];

  // Relacion 1 a 1 inversa
  public function post()
  {
    return $this->belongsTo(Post::class);
  }
}
