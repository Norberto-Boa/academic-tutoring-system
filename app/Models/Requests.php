<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Requests extends Model
{
  use HasFactory;

  protected $table = '_request';

  protected $fillable = [
    "topic",
    "lecturer_id",
    "student_id",
    "admin_approval",
    "lecturer_approval",
    "description",
    "proposal_url",
  ];

  public function lecturer()
  {
    return $this->hasOne(User::class, "id", "lecturer_id");
  }
  public function student()
  {
    return $this->hasOne(User::class, "id", "student_id");
  }
}
