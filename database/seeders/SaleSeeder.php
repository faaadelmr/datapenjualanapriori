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
        
        // Definisikan pola pembelian untuk testing Apriori
        $purchasePatterns = [
            // Pattern 1: Makanan Ringan + Minuman (Sering dibeli bersamaan)
            [
                'products' => ['Chitato Rasa Sapi Panggang', 'Aqua Botol 600ml'],
                'frequency' => 80, // 80% kemungkinan dibeli bersamaan
                'transactions' => 200
            ],
            // Pattern 2: Mie Instan + Minuman
            [
                'products' => ['Indomie Goreng Original', 'Coca Cola Kaleng 330ml'],
                'frequency' => 75,
                'transactions' => 180
            ],
            // Pattern 3: Susu + Roti
            [
                'products' => ['Susu Dancow Fortigro', 'Roti Tawar Sari Roti'],
                'frequency' => 70,
                'transactions' => 150
            ],
            // Pattern 4: Bumbu Masak
            [
                'products' => ['Royco Rasa Ayam', 'Minyak Goreng Bimoli 2L', 'Garam Dapur Cap Kapal'],
                'frequency' => 60,
                'transactions' => 120
            ],
            // Pattern 5: Perawatan Pribadi
            [
                'products' => ['Sabun Mandi Lifebuoy', 'Shampo Pantene 170ml', 'Pasta Gigi Pepsodent'],
                'frequency' => 65,
                'transactions' => 100
            ],
            // Pattern 6: Snack + Minuman
            [
                'products' => ['Richeese Nabati Keju', 'Teh Botol Sosro 450ml'],
                'frequency' => 85,
                'transactions' => 160
            ],
            // Pattern 7: Es Krim + Minuman
            [
                'products' => ['Es Krim Walls Cornetto', 'Fanta Orange Kaleng'],
                'frequency' => 90,
                'transactions' => 80
            ],
            // Pattern 8: Rokok + Minuman
            [
                'products' => ['Gudang Garam Surya 12', 'Coca Cola Kaleng 330ml'],
                'frequency' => 80,
                'transactions' => 90
            ],
            // Pattern 9: Biskuit + Susu
            [
                'products' => ['Oreo Original', 'Ultra Milk Coklat 250ml'],
                'frequency' => 70,
                'transactions' => 110
            ],
            // Pattern 10: Pembersih Rumah
            [
                'products' => ['Sabun Cuci Piring Sunlight', 'Deterjen Rinso Matic'],
                'frequency' => 75,
                'transactions' => 95
            ]
        ];

        $invoiceNumber = 1;

        // Buat transaksi berdasarkan pola yang telah didefinisikan
        foreach ($purchasePatterns as $pattern) {
            $productNames = $pattern['products'];
            $frequency = $pattern['frequency'];
            $transactions = $pattern['transactions'];

            for ($i = 0; $i < $transactions; $i++) {
                $sale = Sale::create([
                    'invoice_number' => 'INV-' . str_pad($invoiceNumber++, 6, '0', STR_PAD_LEFT),
                    'sale_date' => $faker->dateTimeBetween('-3 months', 'now')->format('Y-m-d'),
                    'total_amount' => 0,
                ]);

                $totalAmount = 0;
                $selectedProducts = [];

                // Ambil produk berdasarkan nama
                foreach ($productNames as $productName) {
                    $product = Product::where('name', $productName)->first();
                    if ($product) {
                        $selectedProducts[] = $product;
                    }
                }

                // Buat sale items untuk produk yang dipilih
                foreach ($selectedProducts as $product) {
                    $quantity = $faker->numberBetween(1, 2);
                    $unitPrice = $product->price;
                    $totalPrice = $quantity * $unitPrice;

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

                // Update total amount
                $sale->update(['total_amount' => $totalAmount]);
            }
        }

        // Buat transaksi random untuk variasi (20% dari total transaksi)
        $randomTransactions = 200;
        for ($i = 0; $i < $randomTransactions; $i++) {
            $sale = Sale::create([
                'invoice_number' => 'INV-' . str_pad($invoiceNumber++, 6, '0', STR_PAD_LEFT),
                'sale_date' => $faker->dateTimeBetween('-3 months', 'now')->format('Y-m-d'),
                'total_amount' => 0,
            ]);

            $itemCount = $faker->numberBetween(1, 4);
            $totalAmount = 0;

            // Ambil produk random
            $selectedProducts = Product::inRandomOrder()->take($itemCount)->get();

            foreach ($selectedProducts as $product) {
                $quantity = $faker->numberBetween(1, 2);
                $unitPrice = $product->price;
                $totalPrice = $quantity * $unitPrice;

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

            $sale->update(['total_amount' => $totalAmount]);
        }

        // Buat beberapa transaksi dengan pola khusus untuk testing
        $specialPatterns = [
            // Transaksi dengan banyak item (untuk testing itemset besar)
            [
                'products' => [
                    'Indomie Goreng Original', 'Aqua Botol 600ml', 'Chitato Rasa Sapi Panggang',
                    'Teh Botol Sosro 450ml', 'Richeese Nabati Keju'
                ],
                'count' => 50
            ],
            // Transaksi dengan produk mahal
            [
                'products' => ['Susu Dancow Fortigro', 'Roti Tawar Sari Roti', 'Keju Kraft Singles'],
                'count' => 30
            ],
            // Transaksi dengan produk murah
            [
                'products' => ['Royco Rasa Ayam', 'Garam Dapur Cap Kapal', 'Gula Pasir Gulaku 1kg'],
                'count' => 40
            ]
        ];

        foreach ($specialPatterns as $pattern) {
            for ($i = 0; $i < $pattern['count']; $i++) {
                $sale = Sale::create([
                    'invoice_number' => 'INV-' . str_pad($invoiceNumber++, 6, '0', STR_PAD_LEFT),
                    'sale_date' => $faker->dateTimeBetween('-3 months', 'now')->format('Y-m-d'),
                    'total_amount' => 0,
                ]);

                $totalAmount = 0;

                foreach ($pattern['products'] as $productName) {
                    $product = Product::where('name', $productName)->first();
                    if ($product) {
                        $quantity = $faker->numberBetween(1, 2);
                        $unitPrice = $product->price;
                        $totalPrice = $quantity * $unitPrice;

                        SaleItem::create([
                            'sale_id' => $sale->id,
                            'product_id' => $product->id,
                            'quantity' => $quantity,
                            'unit_price' => $unitPrice,
                            'total_price' => $totalPrice,
                        ]);

                        $totalAmount += $totalPrice;

                        $product->quantity -= $quantity;
                        $product->save();
                    }
                }

                $sale->update(['total_amount' => $totalAmount]);
            }
        }

        echo "Created " . ($invoiceNumber - 1) . " sales transactions for Apriori testing\n";
        echo "Patterns created:\n";
        foreach ($purchasePatterns as $pattern) {
            echo "- " . implode(' + ', $pattern['products']) . " (" . $pattern['transactions'] . " transactions)\n";
        }
    }
}
