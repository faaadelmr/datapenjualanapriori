<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_number',
        'sale_date',
        'total_amount',
    ];

    protected $casts = [
        'sale_date' => 'date',
    ];

    public function saleItems()
    {
        return $this->hasMany(SaleItem::class);
    }

    public static function generateInvoiceNumber()
    {
        $lastSale = self::latest()->first();
        $lastNumber = $lastSale ? intval(substr($lastSale->invoice_number, 4)) : 0;
        return 'INV-' . str_pad($lastNumber + 1, 6, '0', STR_PAD_LEFT);
    }
}
