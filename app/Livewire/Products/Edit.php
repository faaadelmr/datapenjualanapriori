<?php

namespace App\Livewire\Products;

use App\Models\Product;
use Livewire\Component;

class Edit extends Component
{
    public Product $product;
    
    public $name;
    public $quantity;
    public $price;

    protected $rules = [
        'name' => 'required|min:3',
        'quantity' => 'required|integer|min:0',
        'price' => 'required|numeric|min:0',
    ];

    public function mount(Product $product)
    {
        $this->product = $product;
        $this->name = $product->name;
        $this->quantity = $product->quantity;
        $this->price = $product->price;
    }

    public function render()
    {
        return view('livewire.products.edit');
    }

    public function update()
    {
        $this->validate();

        $this->product->update([
            'name' => $this->name,
            'quantity' => $this->quantity,
            'price' => $this->price,
        ]);

        session()->flash('message', 'Product updated successfully.');
        
        return redirect()->route('products.index');
    }
}
