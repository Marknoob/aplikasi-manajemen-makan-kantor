<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenusComponent  extends Model
{
    protected $table = 'menus_component';

    protected $fillable = [
        'nama_komponen',
        'jenis_komponen',
        'is_active',
    ];

    public function details()
    {
        return $this->hasMany(MenusDetail::class, 'component_id');
    }
}
