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
            // Pattern 1: Makanan Ringan + Minuman ringan
            [
                'products' => ['Chitato Rasa Sapi Panggang', 'Aqua Botol 600ml'],
                'frequency' => 82,
                'transactions' => 250
            ],
            // Pattern 2: Mie Instan + Minuman bersoda
            [
                'products' => ['Indomie Goreng Original', 'Coca Cola Kaleng 330ml'],
                'frequency' => 78,
                'transactions' => 210
            ],
            // Pattern 3: Susu bubuk + Roti Tawar
            [
                'products' => ['Susu Dancow Fortigro', 'Roti Tawar Sari Roti'],
                'frequency' => 72,
                'transactions' => 180
            ],
            // Pattern 4: Bumbu dapur lengkap
            [
                'products' => ['Royco Rasa Ayam', 'Minyak Goreng Bimoli 2L', 'Garam Dapur Cap Kapal'],
                'frequency' => 65,
                'transactions' => 140
            ],
            // Pattern 5: Perawatan Pribadi Harian
            [
                'products' => ['Sabun Mandi Lifebuoy', 'Shampo Pantene 170ml', 'Pasta Gigi Pepsodent'],
                'frequency' => 68,
                'transactions' => 120
            ],
            // Pattern 6: Snack Manis + Teh
            [
                'products' => ['Richeese Nabati Keju', 'Teh Botol Sosro 450ml'],
                'frequency' => 87,
                'transactions' => 200
            ],
            // Pattern 7: Es Krim + Minuman kaleng
            [
                'products' => ['Es Krim Walls Cornetto', 'Fanta Orange Kaleng'],
                'frequency' => 88,
                'transactions' => 100
            ],
            // Pattern 8: Rokok + Minuman bersoda
            [
                'products' => ['Gudang Garam Surya 12', 'Coca Cola Kaleng 330ml'],
                'frequency' => 83,
                'transactions' => 110
            ],
            // Pattern 9: Biskuit manis + Susu kemasan
            [
                'products' => ['Oreo Original', 'Ultra Milk Coklat 250ml'],
                'frequency' => 74,
                'transactions' => 130
            ],
            // Pattern 10: Pembersih Rumah Tangga
            [
                'products' => ['Sabun Cuci Piring Sunlight', 'Deterjen Rinso Matic'],
                'frequency' => 77,
                'transactions' => 105
            ],
            // Pattern 11: Sarapan Sehat
            [
                'products' => ['Nutri Sari Jeruk', 'Telur Ayam 1kg', 'Roti Gandum Utuh'],
                'frequency' => 70,
                'transactions' => 90
            ],
            // Pattern 12: Snack Coklat + Minuman Energi
            [
                'products' => ['JetZ Coklat', 'Pocari Sweat 350ml'],
                'frequency' => 76,
                'transactions' => 85
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
        $randomTransactions = 900;
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
                    'Indomie Goreng Original',
                    'Aqua Botol 600ml',
                    'Chitato Rasa Sapi Panggang',
                    'Teh Botol Sosro 450ml',
                    'Richeese Nabati Keju',
                    'Yakult Original 5 Pack',
                    'Good Day Cappuccino',
                    'Pilus Garuda Original',
                    'Cheetos Jagung Bakar',
                    'Qtela Singkong Balado',
                ],
                'count' => 350
            ],
            // Pola campuran minuman dan makanan ringan
            [
                'products' => [
                    'Sprite Kaleng 330ml',
                    'Lays Potato Chips Original',
                    'Ring Pomo Jagung Bakar',
                    'Floridina Orange',
                    'JetZ Coklat',
                ],
                'count' => 435
            ],
            // Pola belanja dapur dan mie instan
            [
                'products' => [
                    'Indomie Ayam Geprek',
                    'Cabe Rawit 250gr',
                    'Bawang Merah 500gr',
                    'Santan Kara 65ml',
                    'Tomat 500gr',
                ],
                'count' => 340
            ],
            // Pola susu & sarapan
            [
                'products' => [
                    'Susu Ultra Milk Full Cream 1L',
                    'Keju Kraft Singles',
                    'Roti Tawar Sari Roti',
                    'Wafer Tango Coklat',
                    'Nutri Sari Jeruk',
                ],
                'count' => 425
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
