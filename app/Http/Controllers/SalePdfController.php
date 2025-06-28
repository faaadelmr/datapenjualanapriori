<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class SalePdfController extends Controller
{
    public function generatePdf(Sale $sale)
    {
        $sale->load('saleItems.product');
        
        $pdf = Pdf::loadView('pdf.invoice', compact('sale'));
        
        return $pdf->download('invoice-' . $sale->invoice_number . '.pdf');
    }
}
