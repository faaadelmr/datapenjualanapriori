<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold">Apriori Market Basket Analysis</h2>
                    <div class="flex space-x-2">
                        <button wire:click="$set('activeTab', 'analysis')" 
                                class="px-4 py-2 rounded-lg {{ $activeTab === 'analysis' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700' }}">
                            Analysis
                        </button>
                        <button wire:click="$set('activeTab', 'recommendations')" 
                                class="px-4 py-2 rounded-lg {{ $activeTab === 'recommendations' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700' }}">
                            Recommendations
                        </button>
                    </div>
                </div>

                @if (session()->has('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        {{ session('error') }}
                    </div>
                @endif

                @if (session()->has('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Analysis Tab -->
                @if ($activeTab === 'analysis')
                    <div class="mb-6">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                            <div>
                                <label for="minSupport" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Minimum Support
                                </label>
                                <input type="number" 
                                       id="minSupport" 
                                       wire:model="minSupport" 
                                       step="0.01" 
                                       min="0" 
                                       max="1"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <p class="text-xs text-gray-500 mt-1">Value between 0 and 1 (e.g., 0.1 = 10%)</p>
                            </div>
                            
                            <div>
                                <label for="minConfidence" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Minimum Confidence
                                </label>
                                <input type="number" 
                                       id="minConfidence" 
                                       wire:model="minConfidence" 
                                       step="0.01" 
                                       min="0" 
                                       max="1"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <p class="text-xs text-gray-500 mt-1">Value between 0 and 1 (e.g., 0.5 = 50%)</p>
                            </div>
                            
                            <div class="flex items-end">
                                <button wire:click="runAnalysis" 
                                        wire:loading.attr="disabled"
                                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded disabled:opacity-50">
                                    <span wire:loading.remove>Run Analysis</span>
                                    <span wire:loading>Analyzing...</span>
                                </button>
                            </div>
                        </div>

                        @if ($analysisResults)
                            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 mb-6">
                                <h3 class="text-lg font-semibold mb-4">Analysis Summary</h3>
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                    <div class="text-center">
                                        <div class="text-2xl font-bold text-blue-600">{{ $analysisResults['total_transactions'] }}</div>
                                        <div class="text-sm text-gray-600 dark:text-gray-400">Total Transactions</div>
                                    </div>
                                    <div class="text-center">
                                        <div class="text-2xl font-bold text-green-600">{{ $analysisResults['summary']['total_frequent_itemsets'] }}</div>
                                        <div class="text-sm text-gray-600 dark:text-gray-400">Frequent Itemsets</div>
                                    </div>
                                    <div class="text-center">
                                        <div class="text-2xl font-bold text-purple-600">{{ $analysisResults['summary']['total_association_rules'] }}</div>
                                        <div class="text-sm text-gray-600 dark:text-gray-400">Association Rules</div>
                                    </div>
                                    <div class="text-center">
                                        <div class="text-2xl font-bold text-orange-600">{{ number_format($analysisResults['summary']['avg_confidence'] * 100, 1) }}%</div>
                                        <div class="text-sm text-gray-600 dark:text-gray-400">Avg Confidence</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Frequent Itemsets -->
                            <div class="mb-6">
                                <h3 class="text-lg font-semibold mb-4">Frequent Itemsets</h3>
                                <div class="overflow-x-auto">
                                    <table class="min-w-full bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600">
                                        <thead>
                                            <tr class="bg-gray-100 dark:bg-gray-700">
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Items</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Support</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Count</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                                            @foreach ($analysisResults['frequent_itemsets'] as $itemset)
                                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                            {{ implode(', ', $itemset['items']) }}
                                                        </span>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                                        {{ number_format($itemset['support'] * 100, 2) }}%
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                                        {{ $itemset['count'] }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Association Rules -->
                            <div>
                                <h3 class="text-lg font-semibold mb-4">Association Rules</h3>
                                <div class="overflow-x-auto">
                                    <table class="min-w-full bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600">
                                        <thead>
                                            <tr class="bg-gray-100 dark:bg-gray-700">
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Antecedent</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Consequent</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Support</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Confidence</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Lift</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                                            @foreach ($analysisResults['association_rules'] as $rule)
                                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                            {{ implode(', ', $rule['antecedent']) }}
                                                        </span>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                                            {{ implode(', ', $rule['consequent']) }}
                                                        </span>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                                        {{ number_format($rule['support'] * 100, 2) }}%
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                                        {{ number_format($rule['confidence'] * 100, 2) }}%
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                                        {{ number_format($rule['lift'], 3) }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif
                    </div>
                @endif

                <!-- Recommendations Tab -->
                @if ($activeTab === 'recommendations')
                    <div class="mb-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                            <div>
                                <label for="selectedProduct" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Select Product
                                </label>
                                <select id="selectedProduct" 
                                        wire:model="selectedProduct"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="">Select a product...</option>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->name }}">{{ $product->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="flex items-end">
                                <button wire:click="getProductRecommendations" 
                                        wire:loading.attr="disabled"
                                        class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded disabled:opacity-50">
                                    <span wire:loading.remove>Get Recommendations</span>
                                    <span wire:loading>Processing...</span>
                                </button>
                            </div>
                        </div>

                        @if ($productRecommendations)
                            <div>
                                <h3 class="text-lg font-semibold mb-4">Product Recommendations for "{{ $selectedProduct }}"</h3>
                                <div class="overflow-x-auto">
                                    <table class="min-w-full bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600">
                                        <thead>
                                            <tr class="bg-gray-100 dark:bg-gray-700">
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Recommended Products</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Confidence</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Lift</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Support</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                                            @foreach ($productRecommendations as $recommendation)
                                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                            {{ implode(', ', $recommendation['recommended_products']) }}
                                                        </span>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                                        {{ number_format($recommendation['confidence'] * 100, 2) }}%
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                                        {{ number_format($recommendation['lift'], 3) }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                                        {{ number_format($recommendation['support'] * 100, 2) }}%
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
</div> 