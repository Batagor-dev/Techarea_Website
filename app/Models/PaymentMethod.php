<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\HasUuid;
use App\Models\Invoice;

class PaymentMethod extends Model
{
    use SoftDeletes, HasUuid;

    protected $fillable = [
        'uuid',
        'name_payment_method',
        'type_payment_method',
        'account_name',
        'account_number',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];


    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'payment_method_id', 'id');
    }


    public function getRouteKeyName()
    {
        return 'uuid';
    }
}
