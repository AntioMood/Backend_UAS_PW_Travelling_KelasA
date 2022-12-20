<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tiket extends Model
{
    use HasFactory;

    protected $fillable = [
        'namaPembeli',
        'id_tempatWisata',
        'id_trip',
        'tlp',
        'tipeKelas',
        'tglBeli',
        'email',
        'harga',
    ];

    public function trip(){
        return $this->belongsTo(Trip::class, 'id_trip');
    }
}