<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\HasSlug;

class Paket extends Model
{
    use HasSlug, HasFactory, SoftDeletes;

    protected $table = 'pakets';

    protected $fillable = [
        'slug',
        'kategori_paket_id',
        'kelas_paket_id',
        'name_paket_id',
        'name_paket_en',
        'description_paket_id',
        'description_paket_en',
        'price_paket',
        'is_popular',
        'is_active',
    ];

    protected $casts = [
        'is_popular' => 'boolean',
        'is_active' => 'boolean',
        'price_paket' => 'integer',
    ];

    public function kategoriPaket()
    {
        return $this->belongsTo(KategoriPaket::class, 'kategori_paket_id');
    }

    public function kelasPaket()
    {
        return $this->belongsTo(KelasPaket::class, 'kelas_paket_id');
    }

    protected $slugFrom = 'name_paket_id';

    public function getRouteKeyName()
    {
        return 'slug';
    }

    
}
