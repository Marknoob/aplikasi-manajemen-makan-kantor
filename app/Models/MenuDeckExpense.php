<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuDeckExpense extends Model
{
    protected $table = 'menu_deck_expenses';

    protected $fillable = [
        'menu_deck_id',
        'deskripsi_biaya',
        'jumlah_biaya',
        'is_active',
    ];

    public function menusDeck()
    {
        return $this->belongsTo(MenusDeck::class, 'menu_deck_id');
    }
}
