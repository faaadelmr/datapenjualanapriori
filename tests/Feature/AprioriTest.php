<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\User;
use App\Services\AprioriService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AprioriTest extends TestCase
{
    use RefreshDatabase;

    public function test_apriori_analysis_with_sample_data()
    {
        // Create test user
        $user = User::factory()->create();

        // Create sample products
        $product1 = Product::create(['name' => 'Product A', 'quantity' => 100, 'price' => 1000]);
        $product2 = Product::create(['name' => 'Product B', 'quantity' => 100, 'price' => 2000]);
        $product3 = Product::create(['name' => 'Product C', 'quantity' => 100, 'price' => 3000]);
        $product4 = Product::create(['name' => 'Product D', 'quantity' => 100, 'price' => 4000]);

        // Create sample sales with itemsets
        // Sale 1: Product A, Product B
        $sale1 = Sale::create([
            'invoice_number' => 'INV-000001',
            'sale_date' => now(),
            'total_amount' => 3000
        ]);
        SaleItem::create([
            'sale_id' => $sale1->id,
            'product_id' => $product1->id,
            'quantity' => 1,
            'unit_price' => 1000,
            'total_price' => 1000
        ]);
        SaleItem::create([
            'sale_id' => $sale1->id,
            'product_id' => $product2->id,
            'quantity' => 1,
            'unit_price' => 2000,
            'total_price' => 2000
        ]);

        // Sale 2: Product A, Product B, Product C
        $sale2 = Sale::create([
            'invoice_number' => 'INV-000002',
            'sale_date' => now(),
            'total_amount' => 6000
        ]);
        SaleItem::create([
            'sale_id' => $sale2->id,
            'product_id' => $product1->id,
            'quantity' => 1,
            'unit_price' => 1000,
            'total_price' => 1000
        ]);
        SaleItem::create([
            'sale_id' => $sale2->id,
            'product_id' => $product2->id,
            'quantity' => 1,
            'unit_price' => 2000,
            'total_price' => 2000
        ]);
        SaleItem::create([
            'sale_id' => $sale2->id,
            'product_id' => $product3->id,
            'quantity' => 1,
            'unit_price' => 3000,
            'total_price' => 3000
        ]);

        // Sale 3: Product A, Product B
        $sale3 = Sale::create([
            'invoice_number' => 'INV-000003',
            'sale_date' => now(),
            'total_amount' => 3000
        ]);
        SaleItem::create([
            'sale_id' => $sale3->id,
            'product_id' => $product1->id,
            'quantity' => 1,
            'unit_price' => 1000,
            'total_price' => 1000
        ]);
        SaleItem::create([
            'sale_id' => $sale3->id,
            'product_id' => $product2->id,
            'quantity' => 1,
            'unit_price' => 2000,
            'total_price' => 2000
        ]);

        // Sale 4: Product C, Product D
        $sale4 = Sale::create([
            'invoice_number' => 'INV-000004',
            'sale_date' => now(),
            'total_amount' => 7000
        ]);
        SaleItem::create([
            'sale_id' => $sale4->id,
            'product_id' => $product3->id,
            'quantity' => 1,
            'unit_price' => 3000,
            'total_price' => 3000
        ]);
        SaleItem::create([
            'sale_id' => $sale4->id,
            'product_id' => $product4->id,
            'quantity' => 1,
            'unit_price' => 4000,
            'total_price' => 4000
        ]);

        // Run Apriori analysis
        $aprioriService = new AprioriService(0.5, 0.5); // 50% support, 50% confidence
        $results = $aprioriService->getAnalysisResults();

        // Assertions
        $this->assertEquals(4, $results['total_transactions']);
        
        // Should find frequent itemsets
        $this->assertGreaterThan(0, $results['summary']['total_frequent_itemsets']);
        
        // Check if Product A and Product B are frequently bought together
        $frequentItemsets = $results['frequent_itemsets'];
        $foundAB = false;
        
        foreach ($frequentItemsets as $itemset) {
            if (count($itemset['items']) == 2 && 
                in_array('Product A', $itemset['items']) && 
                in_array('Product B', $itemset['items'])) {
                $foundAB = true;
                break;
            }
        }
        
        $this->assertTrue($foundAB, 'Product A and Product B should be found as a frequent itemset');
    }

    public function test_apriori_recommendations()
    {
        // Create test user
        $user = User::factory()->create();

        // Create sample products
        $product1 = Product::create(['name' => 'Product A', 'quantity' => 100, 'price' => 1000]);
        $product2 = Product::create(['name' => 'Product B', 'quantity' => 100, 'price' => 2000]);
        $product3 = Product::create(['name' => 'Product C', 'quantity' => 100, 'price' => 3000]);

        // Create sales where Product A and Product B are frequently bought together
        for ($i = 1; $i <= 5; $i++) {
            $sale = Sale::create([
                'invoice_number' => 'INV-' . str_pad($i, 6, '0', STR_PAD_LEFT),
                'sale_date' => now(),
                'total_amount' => 3000
            ]);
            
            SaleItem::create([
                'sale_id' => $sale->id,
                'product_id' => $product1->id,
                'quantity' => 1,
                'unit_price' => 1000,
                'total_price' => 1000
            ]);
            
            SaleItem::create([
                'sale_id' => $sale->id,
                'product_id' => $product2->id,
                'quantity' => 1,
                'unit_price' => 2000,
                'total_price' => 2000
            ]);
        }

        // Add one sale with Product A and Product C
        $sale6 = Sale::create([
            'invoice_number' => 'INV-000006',
            'sale_date' => now(),
            'total_amount' => 4000
        ]);
        
        SaleItem::create([
            'sale_id' => $sale6->id,
            'product_id' => $product1->id,
            'quantity' => 1,
            'unit_price' => 1000,
            'total_price' => 1000
        ]);
        
        SaleItem::create([
            'sale_id' => $sale6->id,
            'product_id' => $product3->id,
            'quantity' => 1,
            'unit_price' => 3000,
            'total_price' => 3000
        ]);

        // Get recommendations for Product A
        $aprioriService = new AprioriService(0.3, 0.5);
        $recommendations = $aprioriService->getProductRecommendations('Product A');

        // Should have recommendations
        $this->assertGreaterThan(0, $recommendations->count());
        
        // Product B should be recommended when Product A is bought
        $foundB = false;
        foreach ($recommendations as $recommendation) {
            if (in_array('Product B', $recommendation['recommended_products'])) {
                $foundB = true;
                break;
            }
        }
        
        $this->assertTrue($foundB, 'Product B should be recommended when Product A is bought');
    }
} 