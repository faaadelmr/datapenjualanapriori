<?php

namespace App\Livewire\Sales;

use App\Models\Sale;
use Livewire\Component;

class Show extends Component
{
    public Sale $sale;

    public function mount(Sale $sale)
    {
        $this->sale = $sale->load('saleItems.product');
    }

    public function render()
    {
        return view('livewire.sales.show');
    }

    public function downloadPdf()
    {
        return redirect()->route('sales.pdf', $this->sale);
    }
}
