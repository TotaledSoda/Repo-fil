<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class about extends Model
{
    protected $table = 'abouts';
    
    // Esto es lo que evita el error de "MassAssignmentException"
    protected $fillable = ['eyebrow', 'title', 'description', 'image_path'];
}
