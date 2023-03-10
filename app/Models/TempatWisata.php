<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempatWisata extends Model
{
    use HasFactory;

    protected $fillable = [
        'namaTempat',
        'alamat',
        'rating',
        'review',
    ];
}
