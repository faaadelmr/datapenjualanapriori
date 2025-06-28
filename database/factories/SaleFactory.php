<?php

namespace Database\Factories;

use App\Models\Sale;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sale>
 */
class SaleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'invoice_number' => $this->generateInvoiceNumber(),
            'sale_date' => $this->faker->dateTimeBetween('-3 months', 'now')->format('Y-m-d'),
            'total_amount' => 0, // Will be calculated after sale items are created
        ];
    }

    private function generateInvoiceNumber(): string
    {
        $lastSale = Sale::latest()->first();
        $lastNumber = $lastSale ? intval(substr($lastSale->invoice_number, 4)) : 0;
        return 'INV-' . str_pad($lastNumber + 1, 6, '0', STR_PAD_LEFT);
    }
}
