<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BukuGallery extends Model
{
    use HasFactory;

    protected $fillable = [
        'bukus_id' , 'url' , 'is_featured'
    ];
}