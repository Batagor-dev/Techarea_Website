<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Invoice;


class Perusahaan extends Model
{
    use HasFactory, HasUuid, SoftDeletes;

    protected $fillable = [
        'uuid', 'name_perusahaan', 'no_telp', 'email', 'alamat', 'logo'
    ];

    public function getRouteKeyName()
    {
        return 'uuid';
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
}
