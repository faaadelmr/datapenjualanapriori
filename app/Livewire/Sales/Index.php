<?php

namespace App\Livewire\Sales;

use App\Models\Sale;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $confirmingSaleDeletion = false;
    public $saleIdToDelete = null;

    public function render()
    {
        $sales = Sale::with('saleItems.product')
            ->where('invoice_number', 'like', '%' . $this->search . '%')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.sales.index', [
            'sales' => $sales,
        ]);
    }

    public function confirmDelete($id)
    {
        $this->saleIdToDelete = $id;
        $this->confirmingSaleDeletion = true;
    }

    public function deleteSale()
    {
        if ($this->saleIdToDelete) {
            $sale = Sale::with('saleItems.product')->find($this->saleIdToDelete);
            if ($sale) {
                // Restore stock for each item
                foreach ($sale->saleItems as $item) {
                    $item->product->increaseStock($item->quantity);
                }
                
                $sale->delete();
                session()->flash('message', 'Sale deleted successfully and stock restored.');
            }
        }
        
        $this->confirmingSaleDeletion = false;
        $this->saleIdToDelete = null;
        
        // Reset pagination if needed
        $this->resetPage();
    }

    public function cancelDelete()
    {
        $this->confirmingSaleDeletion = false;
        $this->saleIdToDelete = null;
    }
}
