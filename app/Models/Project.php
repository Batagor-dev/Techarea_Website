<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\HasSlug;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasSlug, SoftDeletes;

    protected $fillable = [
        'name_project_id',
        'name_project_en',
        'slug',
        'image',
        'technology',
        'link_demo',
        'deskripsi_id',
        'deskripsi_en',
    ];

    protected $casts = [
        'technology' => 'array', // biar auto json <-> array
    ];

    protected $slugFrom = 'name_project_id';

    public function getRouteKeyName()
    {
        return 'slug';
    }
}