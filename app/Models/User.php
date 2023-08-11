<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements JWTSubject
{
  use HasApiTokens, HasFactory, Notifiable;

  //### For JWT ###
  // Rest omitted for brevity
  /**
   * Get the identifier that will be stored in the subject claim of the JWT.
   *
   * @return mixed
   */
  public function getJWTIdentifier()
  {
    return $this->getKey();
  }

  /**
   * Return a key value array, containing any custom claims to be added to the JWT.
   *
   * @return array
   */
  public function getJWTCustomClaims()
  {
    return [];
  }

  protected $fillable = [
    'name',
    'email',
    'password',
    'email_verified_at',
    'is_verified',
    'phone',
    'role_id',
    'reset_code',
    'status',
    'image_path',
    'gender',
  ];


  protected $hidden = [
    'password',
    'remember_token',
    'crated_at',
    'updated_at',
  ];

  /**
   * The attributes that should be cast.
   *
   * @var array<string, string>
   */
  protected $casts = [
    'email_verified_at' => 'datetime',
  ];

  public function role()
  {
    return $this->belongsTo(Role::class);
  }

  public function posts()
  {
    return $this->hasMany(Post::class, 'user_id');
  }

  public function favorite_posts()
  {
    return $this->belongsToMany(Post::class, "post_user");
  }

  public function comments()
  {
    return $this->hasMany(Comment::class, 'user_id');
  }
}
