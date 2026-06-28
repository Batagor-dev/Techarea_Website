<?php

namespace App\Models;

use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Testimoni extends Model
{
    use HasUuid, SoftDeletes;

    protected $fillable = [
        'uuid',
        'name_client',
        'testimoni_client_id',
        'testimoni_client_en',
        'rating',
    ];

    public function getRouteKeyName()
    {
        return 'uuid';
    }
}