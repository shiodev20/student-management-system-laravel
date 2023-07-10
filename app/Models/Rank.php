<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rank extends Model
{
  use HasFactory;

  public $timestamps = false;
  public $incrementing = false;

  public static function getRankByMark($mark) {

    $result = new Mark();

    $ranks = self::all();
    
    foreach ($ranks as $rank) {
      if($mark >= $rank->min_value && $mark <= $rank->max_value) {
        $result = $rank;
        break;
      }
    }

    return $result;
  }
}
