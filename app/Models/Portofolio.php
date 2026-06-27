<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\HasSlug;
use Illuminate\Database\Eloquent\SoftDeletes;

class Portofolio extends Model
{
    use HasSlug, SoftDeletes;

    protected $fillable = [
        'kategori_portofolio_id',
        'name_project_id',
        'name_project_en',
        'slug',
        'image',
        'link_demo',
        'deskripsi_id',
        'deskripsi_en',
    ];

    protected $slugFrom = 'name_project_id';

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function kategoriPortofolio()
    {
        return $this->belongsTo(KategoriPortofolio::class);
    }

    public function getImageAttribute($value)
    {
        return $value ? asset('storage/' . $value) : null;
    }
}