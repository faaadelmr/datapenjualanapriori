<?php

namespace App\Livewire\Sales;

use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use Livewire\Component;

class Edit extends Component
{
    public Sale $sale;
    public $sale_date;
    public $items = [];
    public $total_amount = 0;
    public $originalItems = [];

    protected $rules = [
        'sale_date' => 'required|date',
        'items.*.product_id' => 'required|exists:products,id',
        'items.*.quantity' => 'required|integer|min:1',
    ];

    public function mount(Sale $sale)
    {
        $this->sale = $sale->load('saleItems.product');
        $this->sale_date = $sale->sale_date->format('Y-m-d');
        
        // Store original items for stock restoration
        $this->originalItems = $sale->saleItems->toArray();
        
        // Load current items
        $this->items = $sale->saleItems->map(function ($item) {
            return [
                'id' => $item->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'unit_price' => $item->unit_price,
                'total_price' => $item->total_price,
            ];
        })->toArray();

        $this->calculateTotal();
    }

    public function render()
    {
        $products = Product::all();
        
        return view('livewire.sales.edit', [
            'products' => $products,
        ]);
    }

    public function addItem()
    {
        $this->items[] = [
            'id' => null,
            'product_id' => '',
            'quantity' => 1,
            'unit_price' => 0,
            'total_price' => 0,
        ];
    }

    public function removeItem($index)
    {
        unset($this->items[$index]);
        $this->items = array_values($this->items);
        $this->calculateTotal();
    }

    public function updatedItems($value, $key)
    {
        $parts = explode('.', $key);
        $index = $parts[0];
        $field = $parts[1];

        if ($field === 'product_id' && $value) {
            $product = Product::find($value);
            if ($product) {
                $this->items[$index]['unit_price'] = $product->price;
                $this->calculateItemTotal($index);
            }
        }

        if ($field === 'quantity') {
            $this->calculateItemTotal($index);
        }

        $this->calculateTotal();
    }

    public function calculateItemTotal($index)
    {
        $quantity = $this->items[$index]['quantity'] ?? 0;
        $unitPrice = $this->items[$index]['unit_price'] ?? 0;
        $this->items[$index]['total_price'] = $quantity * $unitPrice;
    }

    public function calculateTotal()
    {
        $this->total_amount = collect($this->items)->sum('total_price');
    }

    public function update()
    {
        $this->validate();

        // Restore original stock
        foreach ($this->originalItems as $originalItem) {
            $product = Product::find($originalItem['product_id']);
            $product->increaseStock($originalItem['quantity']);
        }

        // Validate new stock availability
        foreach ($this->items as $item) {
            $product = Product::find($item['product_id']);
            if ($product->quantity < $item['quantity']) {
                // Restore the original stock back since validation failed
                foreach ($this->originalItems as $originalItem) {
                    $product = Product::find($originalItem['product_id']);
                    $product->reduceStock($originalItem['quantity']);
                }
                
                session()->flash('error', "Insufficient stock for {$product->name}. Available: {$product->quantity}");
                return;
            }
        }

        // Update sale
        $this->sale->update([
            'sale_date' => $this->sale_date,
            'total_amount' => $this->total_amount,
        ]);

        // Delete existing items
        $this->sale->saleItems()->delete();

                // Create new items and reduce stock
        foreach ($this->items as $item) {
            SaleItem::create([
                'sale_id' => $this->sale->id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['unit_price'],
                'total_price' => $item['total_price'],
            ]);

            // Reduce stock with new quantities
            $product = Product::find($item['product_id']);
            $product->reduceStock($item['quantity']);
        }

        session()->flash('message', 'Sale updated successfully.');
        
        return redirect()->route('sales.show', $this->sale);
    }
}
