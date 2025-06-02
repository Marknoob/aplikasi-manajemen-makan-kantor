<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = 'menus';

    protected $fillable = [
        'nama_menu',
        'category_id',
        'vendor_id',
        'harga',
        'terakhir_dipilih',
        'is_active',
    ];

    public function category()
    {
        return $this->belongsTo(MenusCategory::class, 'category_id');
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function details()
    {
        return $this->hasMany(MenusDetail::class, 'menu_id');
    }

    public function menusDeck()
    {
        return $this->hasMany(MenusDeck::class);
    }
}
