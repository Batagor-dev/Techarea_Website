<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Client;
use App\Models\PaymentMethod;
use App\Models\InvoiceItem;

class Invoice extends Model
{
    use hasFactory, HasUuid, SoftDeletes;
    
    protected $fillable = [
        'client_id',
        'payment_method_id',
        'invoice_number',
        'invoice_date',
        'due_date',
        'project_amount',
        'payment_status',
        'status',
        'notes',
    ];

    protected $casts = [
        'invoice_date' => 'date',
        'due_date' => 'date',
    ];
    

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    public function invoiceItems()
    {
        return $this->hasMany(InvoiceItem::class);
    }

    public function getRouteKeyName()
    {
        return 'uuid';
    }
    
}
