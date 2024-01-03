<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Buku extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'judul',
        'kategori',
        'deskripsi',
        'jumlah',
        'slug'
    ];
    // public function kategoris() {
    //     return $this->belongsTo(Kategori::class, 'kategori_id');
    // }

    public function galleries() {
        return $this->hasMany(BukuGallery::class, 'bukus_id', 'id');
    }
}