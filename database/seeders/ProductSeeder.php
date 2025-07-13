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
            ['name' => 'JetZ Coklat', 'quantity' => 550, 'price' => 4000],
            ['name' => 'Ring Pomo Jagung Bakar', 'quantity' => 650, 'price' => 3000],
            ['name' => 'Momogi Jagung Bakar', 'quantity' => 1200, 'price' => 1000],
            ['name' => 'Oishi Pillow Coklat', 'quantity' => 750, 'price' => 5000],
            ['name' => 'Sukro Oven Bawang', 'quantity' => 500, 'price' => 6000],
            
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
            ['name' => 'Le Minerale 600ml', 'quantity' => 950, 'price' => 3500],
            ['name' => 'Floridina Orange', 'quantity' => 700, 'price' => 5000],
            ['name' => 'Nutri Sari Jeruk', 'quantity' => 800, 'price' => 2000],
            ['name' => 'Pop Ice Coklat', 'quantity' => 1500, 'price' => 1500],
            ['name' => 'Marjan Squash Jeruk', 'quantity' => 400, 'price' => 15000],
            
            // Mie Instan
            ['name' => 'Indomie Goreng Original', 'quantity' => 1500, 'price' => 3000],
            ['name' => 'Indomie Soto Mie', 'quantity' => 1000, 'price' => 3000],
            ['name' => 'Mie Sedaap Goreng', 'quantity' => 800, 'price' => 3000],
            ['name' => 'Supermie Ayam Bawang', 'quantity' => 900, 'price' => 2500],
            ['name' => 'Sarimi Isi 2 Ayam Kremes', 'quantity' => 700, 'price' => 4000],
            ['name' => 'Pop Mie Rasa Ayam', 'quantity' => 600, 'price' => 4500],
            ['name' => 'Indomie Ayam Geprek', 'quantity' => 1100, 'price' => 3500],
            ['name' => 'Mie Sedaap Kuah Soto', 'quantity' => 750, 'price' => 3000],
            ['name' => 'Pop Mie Kuah Kari Ayam', 'quantity' => 550, 'price' => 5000],
            ['name' => 'Indomie Ayam Bawang', 'quantity' => 950, 'price' => 3000],
            ['name' => 'Sarimi Goreng Ayam Kecap', 'quantity' => 650, 'price' => 4000],
            
            // Kebutuhan Dapur Lainnya
            ['name' => 'Bawang Merah 500gr', 'quantity' => 150, 'price' => 10000],
            ['name' => 'Bawang Putih 250gr', 'quantity' => 200, 'price' => 8000],
            ['name' => 'Tomat 500gr', 'quantity' => 180, 'price' => 7000],
            ['name' => 'Cabe Rawit 250gr', 'quantity' => 100, 'price' => 15000],
            ['name' => 'Wortel 500gr', 'quantity' => 220, 'price' => 6000],
            ['name' => 'Kentang 1kg', 'quantity' => 170, 'price' => 12000],
            ['name' => 'Santan Kara 65ml', 'quantity' => 500, 'price' => 3500],
            ['name' => 'Kangkung 250gr', 'quantity' => 300, 'price' => 4000],
            ['name' => 'Bayam 250gr', 'quantity' => 350, 'price' => 4500],
            ['name' => 'Tahu Putih', 'quantity' => 400, 'price' => 5000],
            ['name' => 'Tempe', 'quantity' => 380, 'price' => 6000],
            ['name' => 'Gula Merah 250gr', 'quantity' => 250, 'price' => 8000],

            // Susu & Dairy
            ['name' => 'Susu Dancow Fortigro', 'quantity' => 200, 'price' => 45000],
            ['name' => 'Susu SGM Eksplor', 'quantity' => 250, 'price' => 38000],
            ['name' => 'Keju Kraft Singles', 'quantity' => 150, 'price' => 25000],
            ['name' => 'Yogurt Cimory Strawberry', 'quantity' => 400, 'price' => 8500],
            ['name' => 'Susu Kental Manis Frisian Flag', 'quantity' => 350, 'price' => 12000],
            ['name' => 'Susu Bear Brand', 'quantity' => 280, 'price' => 10000],
            ['name' => 'Susu Ultra Milk Full Cream 1L', 'quantity' => 220, 'price' => 18000],
            ['name' => 'Greenfields Susu Pasteurisasi', 'quantity' => 180, 'price' => 22000],
            ['name' => 'Keju Prochiz Cheddar', 'quantity' => 170, 'price' => 19000],
            ['name' => 'Biokul Yogurt Set', 'quantity' => 320, 'price' => 15000],
            
            // Bumbu & Masakan
            ['name' => 'Royco Rasa Ayam', 'quantity' => 2000, 'price' => 1500],
            ['name' => 'Masako Rasa Sapi', 'quantity' => 1800, 'price' => 1500],
            ['name' => 'Kecap Manis ABC 600ml', 'quantity' => 300, 'price' => 18000],
            ['name' => 'Saos Sambal ABC 340ml', 'quantity' => 250, 'price' => 15000],
            ['name' => 'Minyak Goreng Bimoli 2L', 'quantity' => 400, 'price' => 32000],
            ['name' => 'Garam Dapur Cap Kapal', 'quantity' => 1000, 'price' => 3000],
            ['name' => 'Gula Pasir Gulaku 1kg', 'quantity' => 500, 'price' => 15000],
            ['name' => 'Merica Bubuk Kupu-Kupu', 'quantity' => 450, 'price' => 5000],
            ['name' => 'Ketumbar Bubuk', 'quantity' => 600, 'price' => 3000],
            ['name' => 'Laos Bubuk', 'quantity' => 550, 'price' => 3500],
            ['name' => 'Bumbu Nasi Goreng Sajiku', 'quantity' => 700, 'price' => 2000],
            ['name' => 'Bumbu Sop Sajiku', 'quantity' => 650, 'price' => 2000],
            
            // Perawatan Pribadi
            ['name' => 'Sabun Mandi Lifebuoy', 'quantity' => 600, 'price' => 4500],
            ['name' => 'Shampo Pantene 170ml', 'quantity' => 350, 'price' => 18000],
            ['name' => 'Pasta Gigi Pepsodent', 'quantity' => 450, 'price' => 8500],
            ['name' => 'Sikat Gigi Formula', 'quantity' => 500, 'price' => 6000],
            ['name' => 'Deodorant Rexona', 'quantity' => 300, 'price' => 12000],
            ['name' => 'Tissue Paseo 250 Sheet', 'quantity' => 400, 'price' => 15000],
            
            ['name' => 'Shampo Clear Anti Ketombe', 'quantity' => 300, 'price' => 20000],
            ['name' => 'Pasta Gigi Closeup', 'quantity' => 400, 'price' => 9000],
            ['name' => 'Sabun Cuci Muka Garnier', 'quantity' => 250, 'price' => 15000],
            ['name' => 'Body Lotion Nivea', 'quantity' => 280, 'price' => 22000],
            ['name' => 'Minyak Kayu Putih Cap Lang', 'quantity' => 500, 'price' => 10000],
            // Pembersih Rumah
            ['name' => 'Sabun Cuci Piring Sunlight', 'quantity' => 550, 'price' => 8500],
            ['name' => 'Deterjen Rinso Matic', 'quantity' => 250, 'price' => 25000],
            ['name' => 'Pembersih Lantai Vixal', 'quantity' => 350, 'price' => 12000],
            ['name' => 'Kamper Bagus Anti Ngengat', 'quantity' => 400, 'price' => 7500],
            
            // Roti & Kue
            ['name' => 'Pembersih Kaca Cling', 'quantity' => 350, 'price' => 10000],
            ['name' => 'Pewangi Pakaian Molto', 'quantity' => 450, 'price' => 18000],
            ['name' => 'Stella Gantung Pewangi Ruangan', 'quantity' => 500, 'price' => 9000],
            ['name' => 'Baygon Semprot Anti Nyamuk', 'quantity' => 300, 'price' => 20000],
            ['name' => 'Sikat Kamar Mandi', 'quantity' => 600, 'price' => 5000],
            ['name' => 'Roti Tawar Sari Roti', 'quantity' => 300, 'price' => 12000],
            ['name' => 'Biskuit Roma Kelapa', 'quantity' => 650, 'price' => 6500],
            ['name' => 'Wafer Tango Coklat', 'quantity' => 800, 'price' => 4000],
            ['name' => 'Oreo Original', 'quantity' => 450, 'price' => 8500],
            ['name' => 'Better Biskuit Sandwich', 'quantity' => 700, 'price' => 5500],
            
            // Es Krim
            ['name' => 'Regal Marie Biskuit', 'quantity' => 550, 'price' => 7000],
            ['name' => 'Khong Guan Merah Biskuit', 'quantity' => 200, 'price' => 50000],
            ['name' => 'Nissin Kelapa Ijo', 'quantity' => 600, 'price' => 8000],
            ['name' => 'Good Time Cookies', 'quantity' => 400, 'price' => 10000],
            ['name' => 'Roti Gandum Utuh', 'quantity' => 250, 'price' => 15000],
            ['name' => 'Es Krim Walls Cornetto', 'quantity' => 250, 'price' => 8000],
            ['name' => 'Es Krim Aice Mochi', 'quantity' => 500, 'price' => 3000],
            ['name' => 'Magnum Almond', 'quantity' => 200, 'price' => 15000],
            
            // Buah Kaleng & Selai
            ['name' => 'Es Krim Walls Paddle Pop', 'quantity' => 450, 'price' => 5000],
            ['name' => 'Es Krim Campina Hula Hula', 'quantity' => 300, 'price' => 6000],
            ['name' => 'Es Krim Indoeskrim Neapolitan', 'quantity' => 180, 'price' => 20000],
            ['name' => 'Es Krim Viennetta', 'quantity' => 100, 'price' => 50000],
            ['name' => 'Es Krim Glico Wings Frost Bite', 'quantity' => 350, 'price' => 4000],
            ['name' => 'Buah Kaleng Delmonte Nanas', 'quantity' => 300, 'price' => 18000],
            ['name' => 'Selai Kacang Skippy', 'quantity' => 150, 'price' => 35000],
            
            // Rokok
            ['name' => 'Buah Kaleng Kokita Leci', 'quantity' => 250, 'price' => 20000],
            ['name' => 'Selai Coklat Ceres', 'quantity' => 200, 'price' => 25000],
            ['name' => 'Selai Strawberry Mariza', 'quantity' => 220, 'price' => 18000],
            ['name' => 'Manisan Kolang Kaling', 'quantity' => 400, 'price' => 15000],
            ['name' => 'Agar-Agar Swallow Globe', 'quantity' => 700, 'price' => 5000],
            ['name' => 'Gudang Garam Surya 12', 'quantity' => 400, 'price' => 23000],
            ['name' => 'Marlboro Merah', 'quantity' => 350, 'price' => 25000],
            ['name' => 'Sampoerna Mild 16', 'quantity' => 300, 'price' => 24000],
            ['name' => 'Djarum Super 16', 'quantity' => 320, 'price' => 24000],
            
            // Tambahan Produk Minimarket
            ['name' => 'Beras Premium 5kg', 'quantity' => 200, 'price' => 65000],
            ['name' => 'Telur Ayam 1kg', 'quantity' => 250, 'price' => 28000],
            ['name' => 'Margarin Blue Band', 'quantity' => 400, 'price' => 12000],
            ['name' => 'Tepung Terigu Segitiga Biru', 'quantity' => 350, 'price' => 8500],
            ['name' => 'Kopi Kapal Api Bubuk', 'quantity' => 600, 'price' => 15000],
            ['name' => 'Teh Celup Sariwangi', 'quantity' => 450, 'price' => 8000],
            ['name' => 'Garam Beryodium Dolpin', 'quantity' => 800, 'price' => 2500],
            ['name' => 'Merica Bubuk Ladaku', 'quantity' => 500, 'price' => 4000],
            ['name' => 'Susu Bubuk Indomilk', 'quantity' => 300, 'price' => 10000],
            ['name' => 'Gula Merah Batok', 'quantity' => 280, 'price' => 12000],
            ['name' => 'Kecap Asin Abc', 'quantity' => 350, 'price' => 10000],
            ['name' => 'Saos Tomat Abc', 'quantity' => 380, 'price' => 10000],
            ['name' => 'Mie Telur Cap 3 Ayam', 'quantity' => 450, 'price' => 7000],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
