<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\HasSlug;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sertifikat extends Model
{
    use HasSlug, SoftDeletes;

    protected $fillable = [
        'name_sertifikat_id',
        'name_sertifikat_en',
        'slug',
        'image',
        'published_at',
        'deskripsi_id',
        'deskripsi_en',
    ];

    protected $casts = [
        'published_at' => 'date',
    ];

    protected $slugFrom = 'name_sertifikat_id';

    public function getRouteKeyName()
    {
        return 'slug';
    }
}