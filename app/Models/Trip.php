<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    use HasFactory;

    protected $fillable = [
        'namaBiro',
        'tipePerjalanan',
        'jenisTransportasi',
    ];

    public function tikets(){
        return $this->hasMany(Trip::class, 'id_trip', 'id');
    }
}
