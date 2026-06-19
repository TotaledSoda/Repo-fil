<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Servicios extends Model
{
    protected $table = 'servicios';
    
    // Esto permite que Filament guarde estos datos
    protected $fillable = ['title', 'description', 'icon', 'technologies', 'image_path'];

    protected $casts = [
        'technologies' => 'array',
    ];
}