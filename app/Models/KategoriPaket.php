<?php

namespace App\Models;

use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Paket;

class KategoriPaket extends Model
{
    use HasFactory, HasUuid, SoftDeletes;

    protected $table = 'kategori_pakets';

    protected $fillable = [
        'uuid',
        'name_kategori_paket_id',
        'name_kategori_paket_en',
    ];

    public function pakets()
    {
        return $this->hasMany(Paket::class);
    }

    public function getRouteKeyName()
    {
        return 'uuid';
    }
}
