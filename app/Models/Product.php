<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProductPayment;

class Product extends Model {
    use HasFactory;

    protected $fillable = [
        'name',
        'quantity',
        'price',
    ];
}
