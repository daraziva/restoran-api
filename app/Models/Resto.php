<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Resto extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'tanggal',
        'nama',
        'pesanan',
        'level',
        'jumlah',
    ];
}
