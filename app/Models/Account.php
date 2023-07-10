<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Account extends Authenticatable implements CanResetPassword
{
  use HasApiTokens, HasFactory, Notifiable;

  public $incrementing = false;
  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'id',
    'email',
    'password',
  ];

  /**
   * The attributes that should be hidden for serialization.
   *
   * @var array<int, string>
   */
  protected $hidden = [
    'password',
    'remember_token',
  ];

  /**
   * The attributes that should be cast.
   *
   * @var array<string, string>
   */
  protected $casts = [
    'email_verified_at' => 'datetime',
  ];

  public function employee(): HasOne {
    return $this->hasOne(Employee::class, 'account_id', 'id');
  }

  public function teacher(): HasOne {
    return $this->hasOne(Teacher::class, 'account_id', 'id');
  }

  public function student(): HasOne {
    return $this->hasOne(Student::class, 'account_id', 'id');
  }

}
