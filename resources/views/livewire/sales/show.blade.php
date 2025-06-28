<div>
    <section class="w-full">
        <div class="flex justify-between items-center mb-6">
            <flux:heading>{{ __('Invoice') }} {{ $sale->invoice_number }}</flux:heading>
            <div class="flex space-x-2">
                <flux:button wire:click="downloadPdf" variant="outline">{{ __('Download PDF') }}</flux:button>
                <flux:button href="{{ route('sales.edit', $sale) }}" variant="outline">{{ __('Edit') }}</flux:button>
                <flux:button href="{{ route('sales.index') }}" variant="outline">{{ __('Back to Sales') }}</flux:button>
            </div>
        </div>

        <div class="bg-white dark:bg-zinc-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-8">
                <!-- Invoice Header -->
                <div class="mb-8">
                    <div class="flex justify-between items-start">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">INVOICE</h1>
                            <p class="text-gray-600 dark:text-gray-300 mt-2">{{ $sale->invoice_number }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-gray-600 dark:text-gray-300">Date: {{ $sale->sale_date->format('d/m/Y') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Items Table -->
                <div class="mb-8">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-zinc-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Product</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Quantity</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Unit Price</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Total</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-zinc-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($sale->saleItems as $item)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">{{ $item->product->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300 text-center">{{ $item->quantity }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300 text-right">Rp {{ number_format($item->unit_price, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300 text-right">Rp {{ number_format($item->total_price, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Total -->
                <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
                    <div class="flex justify-end">
                        <div class="w-64">
                            <div class="flex justify-between items-center py-2 border-b">
                                <span class="text-lg font-semibold text-gray-900 dark:text-white">Total Amount:</span>
                                <span class="text-lg font-bold text-gray-900 dark:text-white">Rp {{ number_format($sale->total_amount, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
