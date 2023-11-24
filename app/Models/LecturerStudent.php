<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class LecturerStudent extends Model
{
  use HasFactory, HasRoles;

  /**
   * The table associated with the model.
   *
   * @var string
   */
  protected $table = 'lecturer_student';

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'lecturer_id',
    'student_id',
    'topic',
    'proposal_url'
  ];
}
