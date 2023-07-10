<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Year extends Model
{
  use HasFactory;
  public $timestamps = false;
  public $incrementing = false;
  
  protected $table = 'years';
  protected $fillable = [
    'id',
    'name',
    'status',
  ];
  
  public static function getCurrentYear() {
    return self::where('status', '=', 1)->first();
  }
}
