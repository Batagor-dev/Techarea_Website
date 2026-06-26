<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Project;
use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\SoftDeletes;


class KategoriProject extends Model
{
    use HasFactory, HasUuid, SoftDeletes;

    protected $table = 'kategori_projects';

    protected $fillable = [
        'uuid',
        'nama_kategori',
    ];

    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    public function getRouteKeyName()
    {
        return 'uuid';
    }
}
