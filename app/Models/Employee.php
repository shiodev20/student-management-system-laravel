<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Employee extends Model
{
  use HasFactory;

  public $timestamps = false;
  public $incrementing = false;
  protected $fillable = [
    'id',
    'first_name',
    'last_name',
    'gender',
    'dob',
    'address',
    'email',
    'phone',
    'account_id',
    'role_id',
  ];

  public function account(): BelongsTo {
    return $this->belongsTo(Account::class, 'account_id', 'id');
  }

  public function role(): BelongsTo {
    return $this->belongsTo(Role::class, 'role_id', 'id');
  }
}
