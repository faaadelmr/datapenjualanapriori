<?php

namespace App\Livewire\Products;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $confirmingProductDeletion = false;
    public $productIdToDelete = null;

    public function render()
    {
        $products = Product::where('name', 'like', '%' . $this->search . '%')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.products.index', [
            'products' => $products,
        ]);
    }

    public function confirmDelete($id)
    {
        $this->productIdToDelete = $id;
        $this->confirmingProductDeletion = true;
    }

    public function deleteProduct()
    {
        if ($this->productIdToDelete) {
            $product = Product::find($this->productIdToDelete);
            if ($product) {
                $product->delete();
                session()->flash('message', 'Product deleted successfully.');
            }
        }
        
        $this->confirmingProductDeletion = false;
        $this->productIdToDelete = null;
    }

    public function cancelDelete()
    {
        $this->confirmingProductDeletion = false;
        $this->productIdToDelete = null;
    }
}
