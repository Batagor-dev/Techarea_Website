<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Portofolio;
use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\SoftDeletes;


class KategoriPortofolio extends Model
{
    use HasFactory, HasUuid, SoftDeletes;

    protected $table = 'kategori_portofolios';

    protected $fillable = [
        'uuid',
        'name_kategori_project_id',
        'name_kategori_project_en',
    ];

    public function portofolios()
    {
        return $this->hasMany(Portofolio::class);
    }

    public function getRouteKeyName()
    {
        return 'uuid';
    }
}
