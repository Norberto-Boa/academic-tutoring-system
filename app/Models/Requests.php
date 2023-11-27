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
}
