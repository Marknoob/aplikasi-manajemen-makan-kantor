<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenusDeck extends Model
{
    protected $table = 'menus_deck';

    protected $fillable = [
        'menu_id',
        'total_serve',
        'status',
        'tanggal_pelaksanaan',
    ];

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    public function expenses()
    {
        return $this->hasMany(MenuDeckExpense::class, 'menu_deck_id');
    }

    public function payments()
    {
        return $this->hasMany(MenuDeckPayment::class, 'menu_deck_id');
    }
}
