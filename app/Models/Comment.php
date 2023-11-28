<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
  use HasFactory;

  protected $table = 'comments';

  protected $fillable = [
    'content',
    'post_id',
    'commenter_id'
  ];

  public function commenter()
  {
    return $this->hasOne(User::class, 'id', 'commenter_id');
  }
}
