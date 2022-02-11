<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
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

    /** relatioship between user and role */
    public function roles(){
        return $this->belongsToMany(Role::class);
    }

    /** check is user id belong to admin role id */
    public function isAdmin(): Bool {
      return in_array(Role::ADMIN, $this->roles()->pluck('id')->toArray());
    }

    /** check if user id has super_admin role id */
    public function isSuperAdmin(): Bool {
      return in_array(Role::SUPER_ADMIN, $this->roles()->pluck('id')->toArray());
    }
}
