<?php

namespace App\Models;

use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasUuid, SoftDeletes;

    protected $fillable = [
        'uuid',
        'kategori_project_id',
        'name_project',
        'deskripsi_project',
        'status_project',
    ];

    public function getRouteKeyName()
    {
        return 'uuid';
    }

    public function kategoriProject()
    {
        return $this->belongsTo(KategoriProject::class, 'kategori_project_id');
    }
}