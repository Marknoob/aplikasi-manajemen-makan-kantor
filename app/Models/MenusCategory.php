<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenusCategory  extends Model
{
    protected $table = 'menus_category';
    
    protected $fillable = [
        'kategori_bahan_utama',
        'keterangan',
        'is_active',
    ];
}
