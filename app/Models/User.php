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
        'role_id',
        'royalty_points',
        'is_member',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'role'
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
    public function role() {
        return $this->belongsTo(Role::class);
    }

    public function loyalty(){
        return $this->belongsTo(Loyalty::class);
    }

    /** check is user id belong to admin role id */
    public function isAdmin(): Bool{
        return in_array(auth()->user()->role_id, [Role::ADMIN]);
    }

    /** check if user id has super_admin role id */
    public function isSuperAdmin(): Bool{
        return in_array(auth()->user()->role_id, [Role::SUPER_ADMIN]);
    }
}
