<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Grade extends Model
{
  use HasFactory;

  public $timestamps = false;
  public $incrementing = false;
  protected $fillable = ['id', 'name'];

  public function classrooms(): HasMany {
    return $this->hasMany(Classroom::class, 'grade_id', 'id');
  }
}
