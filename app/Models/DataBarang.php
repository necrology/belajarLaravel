<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataBarang extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_barang',
        'qty',
        'harga'
    ];

    protected $table = 'tbl_data_barang';
}
