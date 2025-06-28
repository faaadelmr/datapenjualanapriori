<?php

namespace App\Livewire\Products;

use App\Models\Product;
use Livewire\Component;

class Create extends Component
{
    public $name = '';
    public $quantity = 0;
    public $price = 0;

    protected $rules = [
        'name' => 'required|min:3',
        'quantity' => 'required|integer|min:0',
        'price' => 'required|numeric|min:0',
    ];

    public function render()
    {
        return view('livewire.products.create');
    }

    public function store()
    {
        $this->validate();

        Product::create([
            'name' => $this->name,
            'quantity' => $this->quantity,
            'price' => $this->price,
        ]);

        session()->flash('message', 'Product created successfully.');
        
        return redirect()->route('products.index');
    }
}
