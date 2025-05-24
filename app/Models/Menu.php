<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = 'menus';
    protected $fillable = [
        'nama_menu',
        'karbohidrat',
        'protein',
        'sayur',
        'buah',
        'kategori_bahan_utama',
        'vendor_id',
        'harga',
        'jumlah_vote',
        'terakhir_dipilih',
        'is_active',
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function menusDeck()
    {
        return $this->hasMany(MenusDeck::class);
    }
}
