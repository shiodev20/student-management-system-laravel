<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassroomDetail extends Model
{
  use HasFactory;

  public $timestamps = false;
  protected $fillable = ['id', 'classroom_id', 'student_id'];
}
