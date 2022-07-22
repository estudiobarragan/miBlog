<?php

namespace App\Models;

use App\Models\Post;
use Attribute;
use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publication extends Model
{
  use HasFactory;
  protected $guarded = ['id', 'updated_at'];

  public function post()
  {
    return $this->belongsTo(Post::class);
  }

  protected function getStartAttribute($value)
  {

    return date_format(new DateTime($value), 'd-M-Y');
  }
}
