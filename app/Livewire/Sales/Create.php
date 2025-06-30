<?php

namespace App\Livewire\Sales;

use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use Livewire\Component;

class Create extends Component
{
    public $sale_date;
    public $items = [];
    public $total_amount = 0;
    public $productSearch = '';
    private $productNameCache = [];

    protected $rules = [
        'sale_date' => 'required|date',
        'items.*.product_id' => 'required|exists:products,id',
        'items.*.quantity' => 'required|integer|min:1',
    ];

    public function mount()
    {
        $this->sale_date = now()->format('Y-m-d');
        $this->addItem();
    }

    public function render()
    {
        $productsQuery = Product::where('quantity', '>', 0);

        if (!empty($this->productSearch)) {
            $productsQuery->where('name', 'like', '%' . $this->productSearch . '%');
        }

        // Limit results for performance
        $products = $productsQuery->limit(15)->get();

        return view('livewire.sales.create', [
            'products' => $products,
        ]);
    }

    public function addItem()
    {
        $this->items[] = [
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

    public function selectProduct($index, $productId)
    {
        $product = Product::find($productId);
        if ($product) {
            $this->items[$index]['product_id'] = $product->id;
            $this->items[$index]['unit_price'] = $product->price;
            $this->calculateItemTotal($index);
            $this->calculateTotal();
            $this->productSearch = '';
            $this->resetValidation('items.' . $index . '.product_id');
        }
    }

    public function updatedItems($value, $key)
    {
        $parts = explode('.', $key);
        $index = $parts[0];
        $field = $parts[1];

        // Product selection is now handled by selectProduct()
        if ($field === 'quantity') {
            // Ensure quantity is not less than 1
            if ($this->items[$index]['quantity'] < 1) {
                $this->items[$index]['quantity'] = 1;
            }
            $this->calculateItemTotal($index);
            $this->calculateTotal();
        }
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

    public function getProductName($productId)
    {
        if (!$productId) {
            return 'Select Product';
        }

        if (isset($this->productNameCache[$productId])) {
            return $this->productNameCache[$productId];
        }

        $product = Product::find($productId);
        $this->productNameCache[$productId] = $product ? $product->name : 'Product not found';

        return $this->productNameCache[$productId];
    }

    public function store()
    {
        $this->validate();

        // Validate stock availability
        foreach ($this->items as $item) {
            $product = Product::find($item['product_id']);
            if ($product->quantity < $item['quantity']) {
                session()->flash('error', "Insufficient stock for {$product->name}. Available: {$product->quantity}");
                return;
            }
        }

        $sale = Sale::create([
            'invoice_number' => Sale::generateInvoiceNumber(),
            'sale_date' => $this->sale_date,
            'total_amount' => $this->total_amount,
        ]);

        foreach ($this->items as $item) {
            SaleItem::create([
                'sale_id' => $sale->id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['unit_price'],
                'total_price' => $item['total_price'],
            ]);

            // Reduce stock
            $product = Product::find($item['product_id']);
            $product->reduceStock($item['quantity']);
        }

        session()->flash('message', 'Sale created successfully.');
        
        return redirect()->route('sales.show', $sale);
    }
}
