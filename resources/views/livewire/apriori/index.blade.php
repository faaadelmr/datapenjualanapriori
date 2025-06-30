<div class="py-12 bg-gradient-to-b from-blue-50 to-white dark:from-gray-900 dark:to-gray-900 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl overflow-hidden border border-gray-200 dark:border-gray-700 relative">
            <!-- Header + Tabs -->
            <div class="flex items-center justify-between px-8 py-6 border-b border-gray-100 dark:border-gray-700 bg-gradient-to-r from-blue-600 via-blue-500 to-blue-400 dark:from-blue-900 dark:to-blue-800">
                <h2 class="text-3xl md:text-4xl font-extrabold text-white tracking-tight flex items-center gap-2">
                    <span class="inline-flex items-center justify-center h-10 w-10 rounded-full bg-white bg-opacity-20 text-blue-100 mr-2">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M16 17l-4 4m0 0l-4-4m4 4V3" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </span>
                    Apriori Market Basket Analysis
                </h2>
                <div class="flex space-x-2">
                    <button wire:click="$set('activeTab', 'analysis')" 
                        class="px-6 py-2 rounded-full font-semibold transition-all duration-200 focus:outline-none shadow-sm
                        {{ $activeTab === 'analysis' ? 'bg-white text-blue-700 dark:bg-blue-700 dark:text-white' : 'bg-blue-100 text-blue-700 hover:bg-blue-200 dark:bg-blue-900 dark:text-blue-200 dark:hover:bg-blue-800' }}">
                        Analysis
                    </button>
                    <button wire:click="$set('activeTab', 'recommendations')" 
                        class="px-6 py-2 rounded-full font-semibold transition-all duration-200 focus:outline-none shadow-sm
                        {{ $activeTab === 'recommendations' ? 'bg-white text-blue-700 dark:bg-blue-700 dark:text-white' : 'bg-blue-100 text-blue-700 hover:bg-blue-200 dark:bg-blue-900 dark:text-blue-200 dark:hover:bg-blue-800' }}">
                        Recommendations
                    </button>
                </div>
            </div>

            <div class="p-8 md:p-10 text-gray-900 dark:text-gray-100">
                <!-- Alerts -->
                @if (session()->has('error'))
                    <div class="bg-red-100 dark:bg-red-900 border border-red-400 dark:border-red-800 text-red-700 dark:text-red-100 px-4 py-3 rounded-lg mb-6 shadow-sm flex items-center gap-2">
                        <svg class="h-5 w-5 text-red-500 dark:text-red-200" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.054 0 1.918-.816 1.994-1.85l.007-.15V5.85A1.994 1.994 0 0 0 18.928 4H5.072a1.994 1.994 0 0 0-1.994 1.85l-.007.15v12.001c0 1.054.816 1.918 1.85 1.994l.15.007z" /></svg>
                        {{ session('error') }}
                    </div>
                @endif

                @if (session()->has('success'))
                    <div class="bg-green-100 dark:bg-green-900 border border-green-400 dark:border-green-800 text-green-700 dark:text-green-100 px-4 py-3 rounded-lg mb-6 shadow-sm flex items-center gap-2">
                        <svg class="h-5 w-5 text-green-500 dark:text-green-200" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M9 12l2 2l4-4m6 2a9 9 0 1 1-18 0a9 9 0 0 1 18 0z" /></svg>
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Analysis Tab -->
                @if ($activeTab === 'analysis')
                    <div class="mb-8">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                            <div>
                                <label for="minSupport" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Minimum Support
                                </label>
                                <input type="number" 
                                    id="minSupport" 
                                    wire:model="minSupport" 
                                    step="0.01" 
                                    min="0" 
                                    max="1"
                                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-900 dark:text-white transition">
                                <p class="text-xs text-gray-400 mt-1">Value between 0 and 1 (e.g., 0.1 = 10%)</p>
                            </div>
                            <div>
                                <label for="minConfidence" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Minimum Confidence
                                </label>
                                <input type="number" 
                                    id="minConfidence" 
                                    wire:model="minConfidence" 
                                    step="0.01" 
                                    min="0" 
                                    max="1"
                                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-900 dark:text-white transition">
                                <p class="text-xs text-gray-400 mt-1">Value between 0 and 1 (e.g., 0.5 = 50%)</p>
                            </div>
                            <div class="flex items-end">
                                <button wire:click="runAnalysis" 
                                    wire:loading.attr="disabled"
                                    class="w-full bg-gradient-to-r from-blue-600 to-blue-400 hover:from-blue-700 hover:to-blue-500 text-white font-bold py-2 px-4 rounded-lg shadow-md transition disabled:opacity-50">
                                    <span wire:loading.remove>Run Analysis</span>
                                    <span wire:loading>Analyzing...</span>
                                </button>
                            </div>
                        </div>

                        @if ($analysisResults)
                            <div class="bg-gradient-to-r from-blue-50 to-white dark:from-gray-900 dark:to-gray-800 rounded-2xl p-6 mb-8 border border-blue-100 dark:border-gray-700 shadow-md">
                                <h3 class="text-xl font-bold mb-6 text-blue-700 dark:text-blue-300">Analysis Summary</h3>
                                <div class="grid grid-cols-2 sm:grid-cols-4 gap-6">
                                    <div class="flex flex-col items-center">
                                        <div class="text-3xl font-extrabold text-blue-600 dark:text-blue-400">{{ $analysisResults['total_transactions'] }}</div>
                                        <div class="text-xs font-semibold text-gray-500 dark:text-gray-400 mt-1">Total Transactions</div>
                                    </div>
                                    <div class="flex flex-col items-center">
                                        <div class="text-3xl font-extrabold text-green-600 dark:text-green-400">{{ $analysisResults['summary']['total_frequent_itemsets'] }}</div>
                                        <div class="text-xs font-semibold text-gray-500 dark:text-gray-400 mt-1">Frequent Itemsets</div>
                                    </div>
                                    <div class="flex flex-col items-center">
                                        <div class="text-3xl font-extrabold text-purple-600 dark:text-purple-400">{{ $analysisResults['summary']['total_association_rules'] }}</div>
                                        <div class="text-xs font-semibold text-gray-500 dark:text-gray-400 mt-1">Association Rules</div>
                                    </div>
                                    <div class="flex flex-col items-center">
                                        <div class="text-3xl font-extrabold text-orange-600 dark:text-orange-400">{{ number_format($analysisResults['summary']['avg_confidence'] * 100, 1) }}%</div>
                                        <div class="text-xs font-semibold text-gray-500 dark:text-gray-400 mt-1">Avg Confidence</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Frequent Itemsets -->
                            <div class="mb-8">
                                <h3 class="text-lg font-bold mb-4 text-blue-700 dark:text-blue-300">Frequent Itemsets</h3>
                                <div class="overflow-x-auto rounded-xl shadow border border-gray-100 dark:border-gray-700">
                                    <table class="min-w-full bg-white dark:bg-gray-900 rounded-xl text-sm">
                                        <thead class="sticky top-0 z-10 bg-blue-50 dark:bg-gray-800">
                                            <tr>
                                                <th class="px-6 py-3 text-left font-semibold text-gray-600 dark:text-gray-300 uppercase">Items</th>
                                                <th class="px-6 py-3 text-left font-semibold text-gray-600 dark:text-gray-300 uppercase">Support</th>
                                                <th class="px-6 py-3 text-left font-semibold text-gray-600 dark:text-gray-300 uppercase">Count</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                                            @foreach ($analysisResults['frequent_itemsets'] as $itemset)
                                                <tr class="hover:bg-blue-50 dark:hover:bg-gray-800 transition">
                                                    <td class="px-6 py-4">
                                                        <span class="inline-flex items-center px-3 py-1 bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 rounded-full font-medium">
                                                            {{ implode(', ', $itemset['items']) }}
                                                        </span>
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        {{ number_format($itemset['support'] * 100, 2) }}%
                                                    </td>
                                                    <td class="px-6 py-4">
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
                                <h3 class="text-lg font-bold mb-4 text-blue-700 dark:text-blue-300">Association Rules</h3>
                                <div class="overflow-x-auto rounded-xl shadow border border-gray-100 dark:border-gray-700">
                                    <table class="min-w-full bg-white dark:bg-gray-900 rounded-xl text-sm">
                                        <thead class="sticky top-0 z-10 bg-blue-50 dark:bg-gray-800">
                                            <tr>
                                                <th class="px-6 py-3 text-left font-semibold text-gray-600 dark:text-gray-300 uppercase">Antecedent</th>
                                                <th class="px-6 py-3 text-left font-semibold text-gray-600 dark:text-gray-300 uppercase">Consequent</th>
                                                <th class="px-6 py-3 text-left font-semibold text-gray-600 dark:text-gray-300 uppercase">Support</th>
                                                <th class="px-6 py-3 text-left font-semibold text-gray-600 dark:text-gray-300 uppercase">Confidence</th>
                                                <th class="px-6 py-3 text-left font-semibold text-gray-600 dark:text-gray-300 uppercase">Lift</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                                            @foreach ($analysisResults['association_rules'] as $rule)
                                                <tr class="hover:bg-blue-50 dark:hover:bg-gray-800 transition">
                                                    <td class="px-6 py-4">
                                                        <span class="inline-flex items-center px-3 py-1 bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 rounded-full font-medium">
                                                            {{ implode(', ', $rule['antecedent']) }}
                                                        </span>
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        <span class="inline-flex items-center px-3 py-1 bg-purple-100 dark:bg-purple-900 text-purple-800 dark:text-purple-200 rounded-full font-medium">
                                                            {{ implode(', ', $rule['consequent']) }}
                                                        </span>
                                                    </td>
                                                    <td class="px-6 py-4">{{ number_format($rule['support'] * 100, 2) }}%</td>
                                                    <td class="px-6 py-4">{{ number_format($rule['confidence'] * 100, 2) }}%</td>
                                                    <td class="px-6 py-4">{{ number_format($rule['lift'], 3) }}</td>
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
                    <div class="mb-8">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                            <div>
                                <label for="selectedProduct" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Select Product
                                </label>
                                <select id="selectedProduct" 
                                    wire:model="selectedProduct"
                                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 dark:bg-gray-900 dark:text-white transition">
                                    <option value="">Select a product...</option>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->name }}">{{ $product->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="flex items-end">
                                <button wire:click="getProductRecommendations" 
                                    wire:loading.attr="disabled"
                                    class="w-full bg-gradient-to-r from-green-600 to-green-400 hover:from-green-700 hover:to-green-500 text-white font-bold py-2 px-4 rounded-lg shadow-md transition disabled:opacity-50">
                                    <span wire:loading.remove>Get Recommendations</span>
                                    <span wire:loading>Processing...</span>
                                </button>
                            </div>
                        </div>

                        @if ($productRecommendations)
                            <div>
                                <h3 class="text-lg font-bold mb-4 text-green-700 dark:text-green-300">Product Recommendations for "<span class="font-mono">{{ $selectedProduct }}</span>"</h3>
                                <div class="overflow-x-auto rounded-xl shadow border border-gray-100 dark:border-gray-700">
                                    <table class="min-w-full bg-white dark:bg-gray-900 rounded-xl text-sm">
                                        <thead class="sticky top-0 z-10 bg-green-50 dark:bg-gray-800">
                                            <tr>
                                                <th class="px-6 py-3 text-left font-semibold text-gray-600 dark:text-gray-300 uppercase">Recommended Products</th>
                                                <th class="px-6 py-3 text-left font-semibold text-gray-600 dark:text-gray-300 uppercase">Confidence</th>
                                                <th class="px-6 py-3 text-left font-semibold text-gray-600 dark:text-gray-300 uppercase">Lift</th>
                                                <th class="px-6 py-3 text-left font-semibold text-gray-600 dark:text-gray-300 uppercase">Support</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                                            @foreach ($productRecommendations as $recommendation)
                                                <tr class="hover:bg-green-50 dark:hover:bg-gray-800 transition">
                                                    <td class="px-6 py-4">
                                                        <span class="inline-flex items-center px-3 py-1 bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 rounded-full font-medium">
                                                            {{ implode(', ', $recommendation['recommended_products']) }}
                                                        </span>
                                                    </td>
                                                    <td class="px-6 py-4">{{ number_format($recommendation['confidence'] * 100, 2) }}%</td>
                                                    <td class="px-6 py-4">{{ number_format($recommendation['lift'], 3) }}</td>
                                                    <td class="px-6 py-4">{{ number_format($recommendation['support'] * 100, 2) }}%</td>
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