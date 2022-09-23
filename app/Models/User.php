<?php

namespace App\Models;

use App\Models\Comment;
use App\Models\Image;
use App\Models\Permiso;
use App\Models\Post;
use App\Models\Profile;
use App\Models\Video;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Jetstream\HasTeams;
use Laravel\Sanctum\HasApiTokens;
use Maize\Markable\Markable;
use Maize\Markable\Models\Favorite;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
  use HasApiTokens;
  use HasFactory;
  use HasProfilePhoto;
  use HasTeams;
  use Notifiable;
  use TwoFactorAuthenticatable;

  use HasRoles;
  use Markable;
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'name', 'email', 'password','profile_photo_path',
  ];
  protected static $marks = [
    Favorite::class,
  ];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [
    'password',
    'remember_token',
    'two_factor_recovery_codes',
    'two_factor_secret',
  ];

  /**
   * The attributes that should be cast to native types.
   *
   * @var array
   */
  protected $casts = [
    'email_verified_at' => 'datetime',
  ];

  /**
   * The accessors to append to the model's array form.
   *
   * @var array
   */
  /* protected $appends = [
    'profile_photo_url',
  ]; */

  // Relacion 1 a 1
  public function profile()
  {
    return $this->hasOne(Profile::class);
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
  // Relacion 1 a N polimorfica
  public function comments()
  {
    return $this->hasMany(Comment::class);
  }

  // Relacion 1 a 1 polomorfica
  public function image()
  {
    return $this->morphOne(Image::class, 'imageable');
  }
}
