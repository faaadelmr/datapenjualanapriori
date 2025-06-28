<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Services\AprioriService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AprioriDataTest extends TestCase
{
    use RefreshDatabase;

    public function test_seeded_data_has_clear_patterns()
    {
        // Seed the database
        $this->seed();

        // Check if we have enough data
        $this->assertGreaterThan(0, Sale::count(), 'Should have sales data');
        $this->assertGreaterThan(0, SaleItem::count(), 'Should have sale items');
        $this->assertGreaterThan(0, Product::count(), 'Should have products');

        // Test specific patterns that should exist
        $patterns = [
            ['Chitato Rasa Sapi Panggang', 'Aqua Botol 600ml'],
            ['Indomie Goreng Original', 'Coca Cola Kaleng 330ml'],
            ['Susu Dancow Fortigro', 'Roti Tawar Sari Roti'],
            ['Royco Rasa Ayam', 'Minyak Goreng Bimoli 2L', 'Garam Dapur Cap Kapal'],
            ['Sabun Mandi Lifebuoy', 'Shampo Pantene 170ml', 'Pasta Gigi Pepsodent'],
            ['Richeese Nabati Keju', 'Teh Botol Sosro 450ml'],
            ['Es Krim Walls Cornetto', 'Fanta Orange Kaleng'],
            ['Gudang Garam Surya 12', 'Coca Cola Kaleng 330ml'],
            ['Oreo Original', 'Ultra Milk Coklat 250ml'],
            ['Sabun Cuci Piring Sunlight', 'Deterjen Rinso Matic']
        ];

        foreach ($patterns as $pattern) {
            $this->assertPatternExists($pattern);
        }
    }

    private function assertPatternExists($productNames)
    {
        $patternCount = 0;
        $totalSales = Sale::count();

        // Get all sales that contain all products in the pattern
        $sales = Sale::whereHas('saleItems.product', function ($query) use ($productNames) {
            $query->whereIn('name', $productNames);
        })->get();

        foreach ($sales as $sale) {
            $saleProductNames = $sale->saleItems->map(function ($item) {
                return $item->product->name;
            })->toArray();

            // Check if all products in pattern are in this sale
            $allFound = true;
            foreach ($productNames as $productName) {
                if (!in_array($productName, $saleProductNames)) {
                    $allFound = false;
                    break;
                }
            }

            if ($allFound) {
                $patternCount++;
            }
        }

        $support = $patternCount / $totalSales;
        
        // Pattern should have at least 5% support
        $this->assertGreaterThan(0.05, $support, 
            "Pattern [" . implode(', ', $productNames) . "] should have support > 5%, but got " . number_format($support * 100, 2) . "%");
        
        echo "Pattern [" . implode(', ', $productNames) . "] has support: " . number_format($support * 100, 2) . "% ($patternCount/$totalSales)\n";
    }

    public function test_apriori_analysis_with_seeded_data()
    {
        // Seed the database
        $this->seed();

        // Run Apriori analysis with reasonable thresholds
        $aprioriService = new AprioriService(0.05, 0.3); // 5% support, 30% confidence
        $results = $aprioriService->getAnalysisResults();

        // Should have results
        $this->assertGreaterThan(0, $results['total_transactions'], 'Should have transactions');
        $this->assertGreaterThan(0, $results['summary']['total_frequent_itemsets'], 'Should find frequent itemsets');
        $this->assertGreaterThan(0, $results['summary']['total_association_rules'], 'Should find association rules');

        echo "\nApriori Analysis Results:\n";
        echo "Total Transactions: " . $results['total_transactions'] . "\n";
        echo "Frequent Itemsets: " . $results['summary']['total_frequent_itemsets'] . "\n";
        echo "Association Rules: " . $results['summary']['total_association_rules'] . "\n";
        echo "Average Confidence: " . number_format($results['summary']['avg_confidence'] * 100, 2) . "%\n";
        echo "Average Lift: " . number_format($results['summary']['avg_lift'], 3) . "\n";

        // Show some example frequent itemsets
        echo "\nTop 5 Frequent Itemsets:\n";
        $frequentItemsets = $results['frequent_itemsets']->sortByDesc('support')->take(5);
        foreach ($frequentItemsets as $itemset) {
            echo "- [" . implode(', ', $itemset['items']) . "] Support: " . number_format($itemset['support'] * 100, 2) . "%\n";
        }

        // Show some example association rules
        echo "\nTop 5 Association Rules:\n";
        $associationRules = $results['association_rules']->take(5);
        foreach ($associationRules as $rule) {
            echo "- [" . implode(', ', $rule['antecedent']) . "] → [" . implode(', ', $rule['consequent']) . "] ";
            echo "Confidence: " . number_format($rule['confidence'] * 100, 2) . "%, ";
            echo "Lift: " . number_format($rule['lift'], 3) . "\n";
        }
    }

    public function test_product_recommendations()
    {
        // Seed the database
        $this->seed();

        $aprioriService = new AprioriService(0.05, 0.3);

        // Test recommendations for products that should have strong associations
        $testProducts = [
            'Chitato Rasa Sapi Panggang',
            'Indomie Goreng Original',
            'Susu Dancow Fortigro'
        ];

        foreach ($testProducts as $productName) {
            $recommendations = $aprioriService->getProductRecommendations($productName);
            
            echo "\nRecommendations for '$productName':\n";
            if ($recommendations->count() > 0) {
                foreach ($recommendations->take(3) as $recommendation) {
                    echo "- " . implode(', ', $recommendation['recommended_products']) . " ";
                    echo "(Confidence: " . number_format($recommendation['confidence'] * 100, 2) . "%, ";
                    echo "Lift: " . number_format($recommendation['lift'], 3) . ")\n";
                }
            } else {
                echo "- No recommendations found\n";
            }

            // Should have at least some recommendations for popular products
            if (in_array($productName, ['Chitato Rasa Sapi Panggang', 'Indomie Goreng Original'])) {
                $this->assertGreaterThan(0, $recommendations->count(), 
                    "Should have recommendations for popular product: $productName");
            }
        }
    }
} 