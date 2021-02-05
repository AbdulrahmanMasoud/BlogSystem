<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\User;

class Post extends Model
{
  use HasFactory;

  protected $guarded = [];

  protected $status = 1;

  public function category()
  {
    return $this->belongsTo(Category::class);
  }

  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public function tags()
  {
    return $this->belongsToMany(Tag::class, 'posts_tags');
  }

  public function status()
  {
    return $this->status == 1 ? true : false;
  }
}
