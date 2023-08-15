<?php

namespace App\Models;

use App\Models\User;
use App\Models\Location\Area;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
  use HasFactory;
  protected $fillable = [
    'user_id',
    'area_id',
    'category_id',
    'longitude',
    'latitude',
    'description',
    'available',
    'image_main',
  ];
  protected $appends = ['diffInDay'];

  public function his_user()
  {
    return $this->belongsTo(User::class, 'user_id');
  }

  public function area()
  {
    return $this->belongsTo('App\Models\Location\Area');
  }

  public function category()
  {
    return $this->belongsTo(Category::class);
  }

  public function comments()
  {
    return $this->hasMany(Comment::class, "post_id");
  }

  public function images()
  {
    return $this->morphMany(Image::class, "imageable");
  }

  public function types()
  {
    return $this->belongsToMany(Type::class, "post_types")->withPivot('price', 'start_date', 'end_date');
  }

  public function informations()
  {
    return $this->belongsToMany(Information::class, "information_posts")->withPivot('value');
  }

  public function getDiffInDayAttribute()
  {
    return now()->diffInDays($this->created_at);
  }

  public function scopeWithAllRelations($query)
  {
    return $query->with(['his_user', 'area', 'category', 'comments', 'images', 'informations', 'types']);
  }

  public function scopeWithoutAvailable($query)
  {
    return $query->where('available', true);
  }
}
