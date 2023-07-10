<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TeachingAssignment extends Model
{
  use HasFactory;

  public $timestamps = false;
  protected $fillable = [
    'id',
    'classroom_id',
    'subject_id',
    'subject_teacher_id',
  ];

  public function subjectTeacher(): BelongsTo {
    return $this->belongsTo(Teacher::class, 'subject_teacher_id');
  }

  public function subject(): BelongsTo {
    return $this->belongsTo(Subject::class, 'subject_id');
  }
}
