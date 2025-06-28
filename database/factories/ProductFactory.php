<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $products = [
            // Makanan Ringan
            ['name' => 'Chitato Rasa Sapi Panggang', 'price' => 8500],
            ['name' => 'Taro Net Rasa Rumput Laut', 'price' => 7000],
            ['name' => 'Qtela Singkong Balado', 'price' => 6500],
            ['name' => 'Cheetos Jagung Bakar', 'price' => 9000],
            ['name' => 'Lays Potato Chips Original', 'price' => 12000],
            ['name' => 'Pilus Garuda Original', 'price' => 5500],
            ['name' => 'Richeese Nabati Keju', 'price' => 4500],
            ['name' => 'Kacang Garuda Kacang Atom', 'price' => 3500],
            
            // Minuman
            ['name' => 'Aqua Botol 600ml', 'price' => 3000],
            ['name' => 'Coca Cola Kaleng 330ml', 'price' => 6000],
            ['name' => 'Teh Botol Sosro 450ml', 'price' => 4500],
            ['name' => 'Pocari Sweat 350ml', 'price' => 7500],
            ['name' => 'Fanta Orange Kaleng', 'price' => 6000],
            ['name' => 'Sprite Kaleng 330ml', 'price' => 6000],
            ['name' => 'Ultra Milk Coklat 250ml', 'price' => 5500],
            ['name' => 'Yakult Original 5 Pack', 'price' => 11000],
            ['name' => 'Mizone Apel Guava 500ml', 'price' => 6500],
            ['name' => 'Good Day Cappuccino', 'price' => 2500],
            
            // Mie Instan
            ['name' => 'Indomie Goreng Original', 'price' => 3000],
            ['name' => 'Indomie Soto Mie', 'price' => 3000],
            ['name' => 'Mie Sedaap Goreng', 'price' => 3000],
            ['name' => 'Supermie Ayam Bawang', 'price' => 2500],
            ['name' => 'Sarimi Isi 2 Ayam Kremes', 'price' => 4000],
            ['name' => 'Pop Mie Rasa Ayam', 'price' => 4500],
            
            // Susu & Dairy
            ['name' => 'Susu Dancow Fortigro', 'price' => 45000],
            ['name' => 'Susu SGM Eksplor', 'price' => 38000],
            ['name' => 'Keju Kraft Singles', 'price' => 25000],
            ['name' => 'Yogurt Cimory Strawberry', 'price' => 8500],
            ['name' => 'Susu Kental Manis Frisian Flag', 'price' => 12000],
            
            // Bumbu & Masakan
            ['name' => 'Royco Rasa Ayam', 'price' => 1500],
            ['name' => 'Masako Rasa Sapi', 'price' => 1500],
            ['name' => 'Kecap Manis ABC 600ml', 'price' => 18000],
            ['name' => 'Saos Sambal ABC 340ml', 'price' => 15000],
            ['name' => 'Minyak Goreng Bimoli 2L', 'price' => 32000],
            ['name' => 'Garam Dapur Cap Kapal', 'price' => 3000],
            ['name' => 'Gula Pasir Gulaku 1kg', 'price' => 15000],
            
            // Perawatan Pribadi
            ['name' => 'Sabun Mandi Lifebuoy', 'price' => 4500],
            ['name' => 'Shampo Pantene 170ml', 'price' => 18000],
            ['name' => 'Pasta Gigi Pepsodent', 'price' => 8500],
            ['name' => 'Sikat Gigi Formula', 'price' => 6000],
            ['name' => 'Deodorant Rexona', 'price' => 12000],
            ['name' => 'Tissue Paseo 250 Sheet', 'price' => 15000],
            
            // Pembersih Rumah
            ['name' => 'Sabun Cuci Piring Sunlight', 'price' => 8500],
            ['name' => 'Deterjen Rinso Matic', 'price' => 25000],
            ['name' => 'Pembersih Lantai Vixal', 'price' => 12000],
            ['name' => 'Kamper Bagus Anti Ngengat', 'price' => 7500],
            
            // Roti & Kue
            ['name' => 'Roti Tawar Sari Roti', 'price' => 12000],
            ['name' => 'Biskuit Roma Kelapa', 'price' => 6500],
            ['name' => 'Wafer Tango Coklat', 'price' => 4000],
            ['name' => 'Oreo Original', 'price' => 8500],
            ['name' => 'Better Biskuit Sandwich', 'price' => 5500],
            
            // Es Krim
            ['name' => 'Es Krim Walls Cornetto', 'price' => 8000],
            ['name' => 'Es Krim Aice Mochi', 'price' => 3000],
            ['name' => 'Magnum Almond', 'price' => 15000],
            
            // Buah Kaleng
            ['name' => 'Buah Kaleng Delmonte Nanas', 'price' => 18000],
            ['name' => 'Selai Kacang Skippy', 'price' => 35000],
            
            // Rokok (opsional)
            ['name' => 'Gudang Garam Surya 12', 'price' => 23000],
            ['name' => 'Marlboro Merah', 'price' => 25000],
            ['name' => 'Sampoerna Mild 16', 'price' => 24000],
        ];

        $product = $this->faker->randomElement($products);
        
        return [
            'name' => $product['name'],
            'quantity' => $this->faker->numberBetween(10, 100),
            'price' => $product['price'],
        ];
    }
}
