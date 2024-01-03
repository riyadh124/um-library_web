<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListMaterial extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    public function material(){
        return $this->belongsTo(Material::class,'material_id');
    }
}
