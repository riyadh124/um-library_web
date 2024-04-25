<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul_buku',
        'pengarang',
        'penerbit',
        'cover',
        'kode_buku',
        'tahun_terbit',
        'status'
    ];

    public function borrows()
    {
        return $this->hasMany(Borrow::class);
    }
}