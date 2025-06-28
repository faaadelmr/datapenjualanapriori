<?php

namespace App\Services;

use App\Models\Sale;
use App\Models\Product;
use App\Models\SaleItem;
use Illuminate\Support\Collection;

class AprioriService
{
    private $minSupport;
    private $minConfidence;
    private $transactions;
    private $frequentItemsets;
    private $associationRules;

    public function __construct($minSupport = 0.1, $minConfidence = 0.5)
    {
        $this->minSupport = $minSupport;
        $this->minConfidence = $minConfidence;
        $this->transactions = collect();
        $this->frequentItemsets = collect();
        $this->associationRules = collect();
    }

    /**
     * Load transactions from database
     */
    public function loadTransactions()
    {
        $sales = Sale::with(['saleItems.product'])->get();
        
        $this->transactions = $sales->map(function ($sale) {
            return $sale->saleItems->map(function ($item) {
                return $item->product->name;
            })->toArray();
        });

        return $this;
    }

    /**
     * Generate frequent 1-itemsets
     */
    private function generateFrequent1Itemsets()
    {
        $itemCounts = [];
        $totalTransactions = $this->transactions->count();

        foreach ($this->transactions as $transaction) {
            foreach ($transaction as $item) {
                if (!isset($itemCounts[$item])) {
                    $itemCounts[$item] = 0;
                }
                $itemCounts[$item]++;
            }
        }

        $frequent1Itemsets = collect();
        foreach ($itemCounts as $item => $count) {
            $support = $count / $totalTransactions;
            if ($support >= $this->minSupport) {
                $frequent1Itemsets->push([
                    'items' => [$item],
                    'support' => $support,
                    'count' => $count
                ]);
            }
        }

        return $frequent1Itemsets;
    }

    /**
     * Generate candidate itemsets from frequent itemsets
     */
    private function generateCandidates($frequentItemsets, $k)
    {
        $candidates = collect();
        $itemsets = $frequentItemsets->pluck('items')->toArray();

        for ($i = 0; $i < count($itemsets); $i++) {
            for ($j = $i + 1; $j < count($itemsets); $j++) {
                $itemset1 = $itemsets[$i];
                $itemset2 = $itemsets[$j];

                // Check if first k-2 elements are the same
                $canMerge = true;
                for ($m = 0; $m < $k - 2; $m++) {
                    if ($itemset1[$m] !== $itemset2[$m]) {
                        $canMerge = false;
                        break;
                    }
                }

                if ($canMerge && $itemset1[$k - 2] < $itemset2[$k - 2]) {
                    $newItemset = array_merge(array_slice($itemset1, 0, $k - 1), [$itemset2[$k - 2]]);
                    $candidates->push($newItemset);
                }
            }
        }

        return $candidates;
    }

    /**
     * Calculate support for an itemset
     */
    private function calculateSupport($itemset)
    {
        $count = 0;
        $totalTransactions = $this->transactions->count();

        foreach ($this->transactions as $transaction) {
            $containsAll = true;
            foreach ($itemset as $item) {
                if (!in_array($item, $transaction)) {
                    $containsAll = false;
                    break;
                }
            }
            if ($containsAll) {
                $count++;
            }
        }

        return [
            'support' => $count / $totalTransactions,
            'count' => $count
        ];
    }

    /**
     * Generate frequent itemsets
     */
    public function generateFrequentItemsets()
    {
        $this->frequentItemsets = collect();
        $currentFrequent = $this->generateFrequent1Itemsets();
        $k = 1;

        while ($currentFrequent->count() > 0) {
            $this->frequentItemsets = $this->frequentItemsets->merge($currentFrequent);
            
            $k++;
            $candidates = $this->generateCandidates($currentFrequent, $k);
            
            $currentFrequent = collect();
            foreach ($candidates as $candidate) {
                $support = $this->calculateSupport($candidate);
                if ($support['support'] >= $this->minSupport) {
                    $currentFrequent->push([
                        'items' => $candidate,
                        'support' => $support['support'],
                        'count' => $support['count']
                    ]);
                }
            }
        }

        return $this->frequentItemsets;
    }

    /**
     * Generate association rules
     */
    public function generateAssociationRules()
    {
        $this->associationRules = collect();

        foreach ($this->frequentItemsets as $itemset) {
            if (count($itemset['items']) < 2) {
                continue;
            }

            $this->generateRulesFromItemset($itemset);
        }

        return $this->associationRules;
    }

    /**
     * Generate rules from a specific itemset
     */
    private function generateRulesFromItemset($itemset)
    {
        $items = $itemset['items'];
        $itemsetSupport = $itemset['support'];

        // Generate all possible combinations
        $combinations = $this->generateCombinations($items);

        foreach ($combinations as $combination) {
            $antecedent = $combination;
            $consequent = array_values(array_diff($items, $antecedent));

            if (empty($consequent)) {
                continue;
            }

            // Find support for antecedent
            $antecedentSupport = $this->calculateSupport($antecedent)['support'];

            if ($antecedentSupport > 0) {
                $confidence = $itemsetSupport / $antecedentSupport;
                
                if ($confidence >= $this->minConfidence) {
                    $lift = $confidence / $this->calculateSupport($consequent)['support'];
                    
                    $this->associationRules->push([
                        'antecedent' => $antecedent,
                        'consequent' => $consequent,
                        'support' => $itemsetSupport,
                        'confidence' => $confidence,
                        'lift' => $lift
                    ]);
                }
            }
        }
    }

    /**
     * Generate all possible combinations of items
     */
    private function generateCombinations($items)
    {
        $combinations = [];
        $n = count($items);

        for ($i = 1; $i < (1 << $n); $i++) {
            $combination = [];
            for ($j = 0; $j < $n; $j++) {
                if ($i & (1 << $j)) {
                    $combination[] = $items[$j];
                }
            }
            if (count($combination) < count($items)) {
                $combinations[] = $combination;
            }
        }

        return $combinations;
    }

    /**
     * Get analysis results
     */
    public function getAnalysisResults()
    {
        $this->loadTransactions();
        $frequentItemsets = $this->generateFrequentItemsets();
        $associationRules = $this->generateAssociationRules();

        return [
            'total_transactions' => $this->transactions->count(),
            'min_support' => $this->minSupport,
            'min_confidence' => $this->minConfidence,
            'frequent_itemsets' => $frequentItemsets,
            'association_rules' => $associationRules->sortByDesc('confidence'),
            'summary' => [
                'total_frequent_itemsets' => $frequentItemsets->count(),
                'total_association_rules' => $associationRules->count(),
                'avg_confidence' => $associationRules->avg('confidence'),
                'avg_lift' => $associationRules->avg('lift'),
            ]
        ];
    }

    /**
     * Get product recommendations for a given product
     */
    public function getProductRecommendations($productName)
    {
        $this->loadTransactions();
        $this->generateFrequentItemsets();
        $this->generateAssociationRules();

        return $this->associationRules
            ->filter(function ($rule) use ($productName) {
                return in_array($productName, $rule['antecedent']);
            })
            ->map(function ($rule) {
                return [
                    'recommended_products' => $rule['consequent'],
                    'confidence' => $rule['confidence'],
                    'lift' => $rule['lift'],
                    'support' => $rule['support']
                ];
            })
            ->sortByDesc('confidence');
    }
} 