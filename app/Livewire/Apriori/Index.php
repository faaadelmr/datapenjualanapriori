<?php

namespace App\Livewire\Apriori;

use App\Services\AprioriService;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $minSupport = 0.1;
    public $minConfidence = 0.5;
    public $analysisResults = null;
    public $selectedProduct = '';
    public $productRecommendations = null;
    public $isAnalyzing = false;
    public $activeTab = 'analysis';

    protected $queryString = [
        'minSupport' => ['except' => 0.1],
        'minConfidence' => ['except' => 0.5],
    ];

    public function mount()
    {
        $this->selectedProduct = Product::first()?->name ?? '';
    }

    public function runAnalysis()
    {
        $this->isAnalyzing = true;
        
        try {
            $aprioriService = new AprioriService($this->minSupport, $this->minConfidence);
            $this->analysisResults = $aprioriService->getAnalysisResults();
            $this->activeTab = 'analysis';
        } catch (\Exception $e) {
            session()->flash('error', 'Error running analysis: ' . $e->getMessage());
        } finally {
            $this->isAnalyzing = false;
        }
    }

    public function getProductRecommendations()
    {
        if (empty($this->selectedProduct)) {
            session()->flash('error', 'Please select a product first.');
            return;
        }

        $this->isAnalyzing = true;
        
        try {
            $aprioriService = new AprioriService($this->minSupport, $this->minConfidence);
            $this->productRecommendations = $aprioriService->getProductRecommendations($this->selectedProduct);
            $this->activeTab = 'recommendations';
        } catch (\Exception $e) {
            session()->flash('error', 'Error getting recommendations: ' . $e->getMessage());
        } finally {
            $this->isAnalyzing = false;
        }
    }

    public function getProductsProperty()
    {
        return Product::orderBy('name')->get();
    }

    public function render()
    {
        return view('livewire.apriori.index', [
            'products' => $this->products,
        ]);
    }
} 