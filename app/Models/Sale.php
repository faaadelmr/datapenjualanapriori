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
        // Get the latest invoice number
        $latestInvoice = self::orderBy('id', 'desc')->first();
        
        // If no invoice exists, start with INV-000001
        if (!$latestInvoice) {
            return 'INV-000001';
        }
        
        // Extract the numeric part of the latest invoice number
        $latestNumber = (int) substr($latestInvoice->invoice_number, 4);
        
        // Increment the number and format it with leading zeros
        $newNumber = $latestNumber + 1;
        $formattedNumber = str_pad($newNumber, 6, '0', STR_PAD_LEFT);
        
        // Generate the new invoice number
        $newInvoiceNumber = 'INV-' . $formattedNumber;
        
        // Check if the generated invoice number already exists (to be extra safe)
        while (self::where('invoice_number', $newInvoiceNumber)->exists()) {
            $newNumber++;
            $formattedNumber = str_pad($newNumber, 6, '0', STR_PAD_LEFT);
            $newInvoiceNumber = 'INV-' . $formattedNumber;
        }
        
        return $newInvoiceNumber;
    }
}
