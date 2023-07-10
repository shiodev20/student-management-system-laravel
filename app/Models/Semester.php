<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
  use HasFactory;

  public $timestamps = false; 
  public $incrementing = false;
  protected $table = 'semesters';
  protected $fillable = [
    'id',
    'name',
    'status',
    'coefficient',
  ];

  public static function getSumOfCoefficient() {
    $semesters = self::all();

    $sumOfCoefficient = 0;

    foreach ($semesters as $semester) {
      $sumOfCoefficient += $semester->coefficient;
    }

    return $sumOfCoefficient;
  }

  public static function getCurrentSemester() {
    return self::where('status', '=', 1)->first();
  }
}
