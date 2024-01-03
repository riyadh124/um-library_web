<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workorder extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function listMaterials(){
        return $this->hasMany(ListMaterial::class);
    }

    public function documentationBefore(){
        return $this->hasMany(DocumentationBeforeWork::class);
    }

    public function documentationAfter(){
        return $this->hasMany(DocumentationAfterWork::class);
    }
    
}


