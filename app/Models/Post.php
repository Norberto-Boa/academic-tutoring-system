<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Post extends Model
{
  use HasFactory;

  protected $table = 'posts';

  protected $fillable = [
    'title',
    'description',
    'document_url',
    'student_lecturer_id'
  ];

  public function project(): HasOne
  {
    return $this->hasOne(LecturerStudent::class, 'id', 'lecturer_student_id');
  }

  public function comments(): HasMany
  {
    return $this->hasMany(Comment::class);
  }
}
