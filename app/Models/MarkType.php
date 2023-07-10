<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarkType extends Model
{
  use HasFactory;

  public $timestamps = false;
  public $incrementing = false;
  protected $fillable = ['id', 'name', 'coefficient'];

  public static function getSumOfCoefficient() {
    $markTypes = self::all();

    $sumOfCoefficient = 0;

    foreach ($markTypes as $markType) {
      $sumOfCoefficient += $markType->coefficient;
    }

    return $sumOfCoefficient;    
  }
}
