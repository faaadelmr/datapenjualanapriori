<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class SaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        
        // Buat 50 transaksi penjualan
        for ($i = 1; $i <= 50; $i++) {
            // Buat sale
            $sale = Sale::create([
                'invoice_number' => 'INV-' . str_pad($i, 6, '0', STR_PAD_LEFT),
                'sale_date' => $faker->dateTimeBetween('-3 months', 'now')->format('Y-m-d'),
                'total_amount' => 0, // akan dihitung setelah item dibuat
            ]);

            // Buat 1-5 item per transaksi
            $itemCount = $faker->numberBetween(1, 5);
            $totalAmount = 0;
            
            // Ambil produk random untuk transaksi ini
            $selectedProducts = Product::inRandomOrder()->take($itemCount)->get();
            
            foreach ($selectedProducts as $product) {
                $quantity = $faker->numberBetween(1, 3);
                $unitPrice = $product->price;
                $totalPrice = $quantity * $unitPrice;
                
                // Buat sale item
                SaleItem::create([
                    'sale_id' => $sale->id,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                    'total_price' => $totalPrice,
                ]);
                
                $totalAmount += $totalPrice;
                
                // Kurangi stok produk
                $product->quantity -= $quantity;
                $product->save();
            }
            
            // Update total amount di sale
            $sale->update(['total_amount' => $totalAmount]);
        }
    }
}
