<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Invoice;
use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use hasFactory, HasUuid, SoftDeletes;

    protected $fillable = [
        'company_client',
        'name_client', 
        'email',
        'phone_number',
        'address',
    ];

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
    public function getRouteKeyName()
    {
        return 'uuid';
    }
    
}
