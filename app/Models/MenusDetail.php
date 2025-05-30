<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenusDetail  extends Model
{
    protected $table = 'menus_detail';

    protected $fillable = [
        'menu_id',
        'component_id',
        'is_active',
    ];

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'menu_id');
    }

    public function component()
    {
        return $this->belongsTo(MenusComponent::class, 'component_id');
    }
}
