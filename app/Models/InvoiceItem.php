<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\InvoiceItem;

class InvoiceItem extends Model
{
    use hasFactory, SoftDeletes;
    
    protected $fillable = [
        'invoice_id',
        'item_name',
        'item_description',
        'item_price',
    ];

    
    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
    
}
