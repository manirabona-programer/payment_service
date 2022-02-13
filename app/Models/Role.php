<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model{
    use HasFactory;

    public const USER = 1;
    public const ADMIN = 2;
    public const SUPER_ADMIN = 3;

    public function users(){
        return $this->belongToMany(User::class);
    }
}
