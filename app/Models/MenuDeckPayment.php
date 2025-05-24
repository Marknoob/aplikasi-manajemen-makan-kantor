<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuDeckPayment extends Model
{
    protected $table = 'menu_deck_payments';

    protected $fillable = [
        'menu_deck_id',
        'deskripsi_pembayaran',
        'jumlah_bayar',
        'tanggal_bayar',
        'metode_pembayaran',
        'file_path',
    ];

    public function menusDeck()
    {
        return $this->belongsTo(MenusDeck::class, 'menu_deck_id');
    }
}
