<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    protected $table = 'vendors';

    protected $fillable = [
        'id',
        'nama',
        'kontak',
        'alamat',
        'email',
        'penilaian',
        'keterangan',
        'is_active',
    ];

    public function menus()
    {
        return $this->hasMany(Menu::class);
    }
}
