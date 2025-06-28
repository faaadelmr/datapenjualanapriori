<x-layouts.app :title="__('Dashboard')">
    <div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-4">Welcome to Your Dashboard</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                        <div class="bg-blue-100 dark:bg-blue-900 p-4 rounded-lg">
                            <h4 class="font-semibold text-blue-800 dark:text-blue-200">Products</h4>
                            <p class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ \App\Models\Product::count() }}</p>
                            <a href="{{ route('products.index') }}" class="text-sm text-blue-600 dark:text-blue-400 hover:underline">View Products</a>
                        </div>
                        
                        <div class="bg-green-100 dark:bg-green-900 p-4 rounded-lg">
                            <h4 class="font-semibold text-green-800 dark:text-green-200">Sales</h4>
                            <p class="text-2xl font-bold text-green-600 dark:text-green-400">{{ \App\Models\Sale::count() }}</p>
                            <a href="{{ route('sales.index') }}" class="text-sm text-green-600 dark:text-green-400 hover:underline">View Sales</a>
                        </div>
                        
                        <div class="bg-purple-100 dark:bg-purple-900 p-4 rounded-lg">
                            <h4 class="font-semibold text-purple-800 dark:text-purple-200">Total Revenue</h4>
                            <p class="text-2xl font-bold text-purple-600 dark:text-purple-400">Rp {{ number_format(\App\Models\Sale::sum('total_amount'), 0, ',', '.') }}</p>
                        </div>
                        
                        <div class="bg-orange-100 dark:bg-orange-900 p-4 rounded-lg">
                            <h4 class="font-semibold text-orange-800 dark:text-orange-200">Apriori Analysis</h4>
                            <p class="text-sm text-orange-600 dark:text-orange-400 mb-2">Market Basket Analysis</p>
                            <a href="{{ route('apriori.index') }}" class="text-sm text-orange-600 dark:text-orange-400 hover:underline">Run Analysis</a>
                        </div>
                    </div>

                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                        <h4 class="font-semibold mb-2">Quick Actions</h4>
                        <div class="flex flex-wrap gap-2">
                            <a href="{{ route('products.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm">
                                Add Product
                            </a>
                            <a href="{{ route('sales.create') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded text-sm">
                                Create Sale
                            </a>
                            <a href="{{ route('apriori.index') }}" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded text-sm">
                                Apriori Analysis
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</x-layouts.app>
