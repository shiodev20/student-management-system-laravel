<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subject extends Model
{
  use HasFactory;

  public $timestamps = false;
  public $incrementing = false;
  protected $fillable = ['id', 'name', 'coefficient'];

  public function teachers(): HasMany {
    return $this->hasMany(Teacher::class, 'subject_id', 'id');
  }

  public function marks(): HasMany {
    return $this->hasMany(Mark::class, 'subject_id', 'id');
  }

  public static function getSumOfCoefficient() {
    $subjects = self::all();

    $sumOfCoefficient = 0;

    foreach ($subjects as $subject) {
      $sumOfCoefficient += $subject->coefficient;
    }

    return $sumOfCoefficient;    
  }
}
