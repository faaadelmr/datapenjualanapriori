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
            ['name' => 'Chitato Rasa Sapi Panggang', 'quantity' => 50, 'price' => 8500],
            ['name' => 'Taro Net Rasa Rumput Laut', 'quantity' => 45, 'price' => 7000],
            ['name' => 'Qtela Singkong Balado', 'quantity' => 60, 'price' => 6500],
            ['name' => 'Cheetos Jagung Bakar', 'quantity' => 35, 'price' => 9000],
            ['name' => 'Lays Potato Chips Original', 'quantity' => 25, 'price' => 12000],
            ['name' => 'Pilus Garuda Original', 'quantity' => 80, 'price' => 5500],
            ['name' => 'Richeese Nabati Keju', 'quantity' => 90, 'price' => 4500],
            ['name' => 'Kacang Garuda Kacang Atom', 'quantity' => 70, 'price' => 3500],
            
            // Minuman
            ['name' => 'Aqua Botol 600ml', 'quantity' => 100, 'price' => 3000],
            ['name' => 'Coca Cola Kaleng 330ml', 'quantity' => 75, 'price' => 6000],
            ['name' => 'Teh Botol Sosro 450ml', 'quantity' => 85, 'price' => 4500],
            ['name' => 'Pocari Sweat 350ml', 'quantity' => 40, 'price' => 7500],
            ['name' => 'Fanta Orange Kaleng', 'quantity' => 60, 'price' => 6000],
            ['name' => 'Sprite Kaleng 330ml', 'quantity' => 55, 'price' => 6000],
            ['name' => 'Ultra Milk Coklat 250ml', 'quantity' => 45, 'price' => 5500],
            ['name' => 'Yakult Original 5 Pack', 'quantity' => 30, 'price' => 11000],
            ['name' => 'Mizone Apel Guava 500ml', 'quantity' => 50, 'price' => 6500],
            ['name' => 'Good Day Cappuccino', 'quantity' => 120, 'price' => 2500],
            
            // Mie Instan
            ['name' => 'Indomie Goreng Original', 'quantity' => 150, 'price' => 3000],
            ['name' => 'Indomie Soto Mie', 'quantity' => 100, 'price' => 3000],
            ['name' => 'Mie Sedaap Goreng', 'quantity' => 80, 'price' => 3000],
            ['name' => 'Supermie Ayam Bawang', 'quantity' => 90, 'price' => 2500],
            ['name' => 'Sarimi Isi 2 Ayam Kremes', 'quantity' => 70, 'price' => 4000],
            ['name' => 'Pop Mie Rasa Ayam', 'quantity' => 60, 'price' => 4500],
            
            // Susu & Dairy
            ['name' => 'Susu Dancow Fortigro', 'quantity' => 20, 'price' => 45000],
            ['name' => 'Susu SGM Eksplor', 'quantity' => 25, 'price' => 38000],
            ['name' => 'Keju Kraft Singles', 'quantity' => 15, 'price' => 25000],
            ['name' => 'Yogurt Cimory Strawberry', 'quantity' => 40, 'price' => 8500],
            ['name' => 'Susu Kental Manis Frisian Flag', 'quantity' => 35, 'price' => 12000],
            
            // Bumbu & Masakan
            ['name' => 'Royco Rasa Ayam', 'quantity' => 200, 'price' => 1500],
            ['name' => 'Masako Rasa Sapi', 'quantity' => 180, 'price' => 1500],
            ['name' => 'Kecap Manis ABC 600ml', 'quantity' => 30, 'price' => 18000],
            ['name' => 'Saos Sambal ABC 340ml', 'quantity' => 25, 'price' => 15000],
            ['name' => 'Minyak Goreng Bimoli 2L', 'quantity' => 40, 'price' => 32000],
            ['name' => 'Garam Dapur Cap Kapal', 'quantity' => 100, 'price' => 3000],
            ['name' => 'Gula Pasir Gulaku 1kg', 'quantity' => 50, 'price' => 15000],
            
            // Perawatan Pribadi
            ['name' => 'Sabun Mandi Lifebuoy', 'quantity' => 60, 'price' => 4500],
            ['name' => 'Shampo Pantene 170ml', 'quantity' => 35, 'price' => 18000],
            ['name' => 'Pasta Gigi Pepsodent', 'quantity' => 45, 'price' => 8500],
            ['name' => 'Sikat Gigi Formula', 'quantity' => 50, 'price' => 6000],
            ['name' => 'Deodorant Rexona', 'quantity' => 30, 'price' => 12000],
            ['name' => 'Tissue Paseo 250 Sheet', 'quantity' => 40, 'price' => 15000],
            
            // Pembersih Rumah
            ['name' => 'Sabun Cuci Piring Sunlight', 'quantity' => 55, 'price' => 8500],
            ['name' => 'Deterjen Rinso Matic', 'quantity' => 25, 'price' => 25000],
            ['name' => 'Pembersih Lantai Vixal', 'quantity' => 35, 'price' => 12000],
            ['name' => 'Kamper Bagus Anti Ngengat', 'quantity' => 40, 'price' => 7500],
            
            // Roti & Kue
            ['name' => 'Roti Tawar Sari Roti', 'quantity' => 30, 'price' => 12000],
            ['name' => 'Biskuit Roma Kelapa', 'quantity' => 65, 'price' => 6500],
            ['name' => 'Wafer Tango Coklat', 'quantity' => 80, 'price' => 4000],
            ['name' => 'Oreo Original', 'quantity' => 45, 'price' => 8500],
            ['name' => 'Better Biskuit Sandwich', 'quantity' => 70, 'price' => 5500],
            
            // Es Krim
            ['name' => 'Es Krim Walls Cornetto', 'quantity' => 25, 'price' => 8000],
            ['name' => 'Es Krim Aice Mochi', 'quantity' => 50, 'price' => 3000],
            ['name' => 'Magnum Almond', 'quantity' => 20, 'price' => 15000],
            
            // Buah Kaleng & Selai
            ['name' => 'Buah Kaleng Delmonte Nanas', 'quantity' => 30, 'price' => 18000],
            ['name' => 'Selai Kacang Skippy', 'quantity' => 15, 'price' => 35000],
            
            // Rokok
            ['name' => 'Gudang Garam Surya 12', 'quantity' => 40, 'price' => 23000],
            ['name' => 'Marlboro Merah', 'quantity' => 35, 'price' => 25000],
            ['name' => 'Sampoerna Mild 16', 'quantity' => 30, 'price' => 24000],
            
            // Tambahan Produk Minimarket
            ['name' => 'Beras Premium 5kg', 'quantity' => 20, 'price' => 65000],
            ['name' => 'Telur Ayam 1kg', 'quantity' => 25, 'price' => 28000],
            ['name' => 'Margarin Blue Band', 'quantity' => 40, 'price' => 12000],
            ['name' => 'Tepung Terigu Segitiga Biru', 'quantity' => 35, 'price' => 8500],
            ['name' => 'Kopi Kapal Api Bubuk', 'quantity' => 60, 'price' => 15000],
            ['name' => 'Teh Celup Sariwangi', 'quantity' => 45, 'price' => 8000],
            ['name' => 'Garam Beryodium Dolpin', 'quantity' => 80, 'price' => 2500],
            ['name' => 'Merica Bubuk Ladaku', 'quantity' => 50, 'price' => 4000],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
