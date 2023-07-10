<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
  use HasFactory;

  public $timestamps = false;
  protected $fillable = [
    'id',
    'name'
  ];

  public function employees(): HasMany {
    return $this->hasMany(Employee::class, 'role_id', 'id');
  }

  public function teachers(): HasMany {
    return $this->hasMany(Teacher::class, 'role_id', 'id');
  }
}
