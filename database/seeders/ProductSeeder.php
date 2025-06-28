<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            // Makanan Ringan
            ['name' => 'Chitato Rasa Sapi Panggang', 'quantity' => 500, 'price' => 8500],
            ['name' => 'Taro Net Rasa Rumput Laut', 'quantity' => 450, 'price' => 7000],
            ['name' => 'Qtela Singkong Balado', 'quantity' => 600, 'price' => 6500],
            ['name' => 'Cheetos Jagung Bakar', 'quantity' => 350, 'price' => 9000],
            ['name' => 'Lays Potato Chips Original', 'quantity' => 250, 'price' => 12000],
            ['name' => 'Pilus Garuda Original', 'quantity' => 800, 'price' => 5500],
            ['name' => 'Richeese Nabati Keju', 'quantity' => 900, 'price' => 4500],
            ['name' => 'Kacang Garuda Kacang Atom', 'quantity' => 700, 'price' => 3500],
            
            // Minuman
            ['name' => 'Aqua Botol 600ml', 'quantity' => 1000, 'price' => 3000],
            ['name' => 'Coca Cola Kaleng 330ml', 'quantity' => 750, 'price' => 6000],
            ['name' => 'Teh Botol Sosro 450ml', 'quantity' => 850, 'price' => 4500],
            ['name' => 'Pocari Sweat 350ml', 'quantity' => 400, 'price' => 7500],
            ['name' => 'Fanta Orange Kaleng', 'quantity' => 600, 'price' => 6000],
            ['name' => 'Sprite Kaleng 330ml', 'quantity' => 550, 'price' => 6000],
            ['name' => 'Ultra Milk Coklat 250ml', 'quantity' => 450, 'price' => 5500],
            ['name' => 'Yakult Original 5 Pack', 'quantity' => 300, 'price' => 11000],
            ['name' => 'Mizone Apel Guava 500ml', 'quantity' => 500, 'price' => 6500],
            ['name' => 'Good Day Cappuccino', 'quantity' => 1200, 'price' => 2500],
            
            // Mie Instan
            ['name' => 'Indomie Goreng Original', 'quantity' => 1500, 'price' => 3000],
            ['name' => 'Indomie Soto Mie', 'quantity' => 1000, 'price' => 3000],
            ['name' => 'Mie Sedaap Goreng', 'quantity' => 800, 'price' => 3000],
            ['name' => 'Supermie Ayam Bawang', 'quantity' => 900, 'price' => 2500],
            ['name' => 'Sarimi Isi 2 Ayam Kremes', 'quantity' => 700, 'price' => 4000],
            ['name' => 'Pop Mie Rasa Ayam', 'quantity' => 600, 'price' => 4500],
            
            // Susu & Dairy
            ['name' => 'Susu Dancow Fortigro', 'quantity' => 200, 'price' => 45000],
            ['name' => 'Susu SGM Eksplor', 'quantity' => 250, 'price' => 38000],
            ['name' => 'Keju Kraft Singles', 'quantity' => 150, 'price' => 25000],
            ['name' => 'Yogurt Cimory Strawberry', 'quantity' => 400, 'price' => 8500],
            ['name' => 'Susu Kental Manis Frisian Flag', 'quantity' => 350, 'price' => 12000],
            
            // Bumbu & Masakan
            ['name' => 'Royco Rasa Ayam', 'quantity' => 2000, 'price' => 1500],
            ['name' => 'Masako Rasa Sapi', 'quantity' => 1800, 'price' => 1500],
            ['name' => 'Kecap Manis ABC 600ml', 'quantity' => 300, 'price' => 18000],
            ['name' => 'Saos Sambal ABC 340ml', 'quantity' => 250, 'price' => 15000],
            ['name' => 'Minyak Goreng Bimoli 2L', 'quantity' => 400, 'price' => 32000],
            ['name' => 'Garam Dapur Cap Kapal', 'quantity' => 1000, 'price' => 3000],
            ['name' => 'Gula Pasir Gulaku 1kg', 'quantity' => 500, 'price' => 15000],
            
            // Perawatan Pribadi
            ['name' => 'Sabun Mandi Lifebuoy', 'quantity' => 600, 'price' => 4500],
            ['name' => 'Shampo Pantene 170ml', 'quantity' => 350, 'price' => 18000],
            ['name' => 'Pasta Gigi Pepsodent', 'quantity' => 450, 'price' => 8500],
            ['name' => 'Sikat Gigi Formula', 'quantity' => 500, 'price' => 6000],
            ['name' => 'Deodorant Rexona', 'quantity' => 300, 'price' => 12000],
            ['name' => 'Tissue Paseo 250 Sheet', 'quantity' => 400, 'price' => 15000],
            
            // Pembersih Rumah
            ['name' => 'Sabun Cuci Piring Sunlight', 'quantity' => 550, 'price' => 8500],
            ['name' => 'Deterjen Rinso Matic', 'quantity' => 250, 'price' => 25000],
            ['name' => 'Pembersih Lantai Vixal', 'quantity' => 350, 'price' => 12000],
            ['name' => 'Kamper Bagus Anti Ngengat', 'quantity' => 400, 'price' => 7500],
            
            // Roti & Kue
            ['name' => 'Roti Tawar Sari Roti', 'quantity' => 300, 'price' => 12000],
            ['name' => 'Biskuit Roma Kelapa', 'quantity' => 650, 'price' => 6500],
            ['name' => 'Wafer Tango Coklat', 'quantity' => 800, 'price' => 4000],
            ['name' => 'Oreo Original', 'quantity' => 450, 'price' => 8500],
            ['name' => 'Better Biskuit Sandwich', 'quantity' => 700, 'price' => 5500],
            
            // Es Krim
            ['name' => 'Es Krim Walls Cornetto', 'quantity' => 250, 'price' => 8000],
            ['name' => 'Es Krim Aice Mochi', 'quantity' => 500, 'price' => 3000],
            ['name' => 'Magnum Almond', 'quantity' => 200, 'price' => 15000],
            
            // Buah Kaleng & Selai
            ['name' => 'Buah Kaleng Delmonte Nanas', 'quantity' => 300, 'price' => 18000],
            ['name' => 'Selai Kacang Skippy', 'quantity' => 150, 'price' => 35000],
            
            // Rokok
            ['name' => 'Gudang Garam Surya 12', 'quantity' => 400, 'price' => 23000],
            ['name' => 'Marlboro Merah', 'quantity' => 350, 'price' => 25000],
            ['name' => 'Sampoerna Mild 16', 'quantity' => 300, 'price' => 24000],
            
            // Tambahan Produk Minimarket
            ['name' => 'Beras Premium 5kg', 'quantity' => 200, 'price' => 65000],
            ['name' => 'Telur Ayam 1kg', 'quantity' => 250, 'price' => 28000],
            ['name' => 'Margarin Blue Band', 'quantity' => 400, 'price' => 12000],
            ['name' => 'Tepung Terigu Segitiga Biru', 'quantity' => 350, 'price' => 8500],
            ['name' => 'Kopi Kapal Api Bubuk', 'quantity' => 600, 'price' => 15000],
            ['name' => 'Teh Celup Sariwangi', 'quantity' => 450, 'price' => 8000],
            ['name' => 'Garam Beryodium Dolpin', 'quantity' => 800, 'price' => 2500],
            ['name' => 'Merica Bubuk Ladaku', 'quantity' => 500, 'price' => 4000],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
