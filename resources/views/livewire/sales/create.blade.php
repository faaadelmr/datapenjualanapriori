<div>
    <section class="w-full">
        <div class="flex justify-between items-center mb-6">
            <flux:heading>{{ __('New Sale') }}</flux:heading>
            <flux:button href="{{ route('sales.index') }}" variant="outline">{{ __('Back to Sales') }}</flux:button>
        </div>

        <div class="bg-white dark:bg-zinc-800/50 overflow-hidden shadow-xl sm:rounded-2xl border border-gray-200 dark:border-zinc-700">
            <div class="p-6 lg:p-8">
                @if (session()->has('error'))
                    <div class="mb-4 p-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                        {{ session('error') }}
                    </div>
                @endif

                <form wire:submit="store">
                    <div class="mb-6">
                        <flux:input wire:model="sale_date" type="date" :label="__('Sale Date')" required />
                        @error('sale_date') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="border-t border-gray-200 dark:border-zinc-700 pt-6">
                        <div class="flex justify-between items-center mb-4">
                            <flux:heading size="sm">{{ __('Sale Items') }}</flux:heading>
                            <flux:button type="button" wire:click="addItem" size="sm" icon="plus">{{ __('Add Item') }}</flux:button>
                        </div>

                        <div class="space-y-4">
                            @forelse($items as $index => $item)
                                <div wire:key="item-{{ $index }}" class="bg-gray-50 dark:bg-zinc-900/50 p-4 rounded-xl border border-gray-200 dark:border-zinc-700 transition-all">
                                    <div class="flex flex-col md:flex-row md:items-start gap-4">
                                        {{-- Interactive Product Selector --}}
                                        <div class="flex-grow">
                                            <label for="product-{{$index}}" class="text-xs font-medium text-gray-500 dark:text-gray-400">Product</label>
                                            <div x-data="{ open: false }" @click.away="open = false" class="relative mt-1">
                                                <button type="button" @click="open = !open" class="relative w-full cursor-default rounded-md bg-white dark:bg-zinc-800 py-2 pl-3 pr-10 text-left text-gray-900 dark:text-gray-200 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-zinc-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 sm:text-sm sm:leading-6">
                                                    <span class="block truncate">{{ $this->getProductName($item['product_id']) }}</span>
                                                    <span class="pointer-events-none absolute inset-y-0 right-0 ml-3 flex items-center pr-2">
                                                        <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M10 3a.75.75 0 01.53.22l3.5 3.5a.75.75 0 01-1.06 1.06L10 4.81 6.53 8.28a.75.75 0 01-1.06-1.06l3.5-3.5A.75.75 0 0110 3zm-3.72 9.28a.75.75 0 011.06 0L10 15.19l3.47-3.47a.75.75 0 111.06 1.06l-4 4a.75.75 0 01-1.06 0l-4-4a.75.75 0 010-1.06z" clip-rule="evenodd" /></svg>
                                                    </span>
                                                </button>
                                                <div x-show="open" x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="absolute z-10 mt-1 w-full bg-white dark:bg-zinc-800 shadow-lg max-h-56 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto focus:outline-none sm:text-sm">
                                                    <div class="p-2">
                                                        <input wire:model.live.debounce.300ms="productSearch" type="text" placeholder="Search products..." class="w-full rounded-md border-gray-300 dark:border-zinc-600 dark:bg-zinc-900 dark:text-gray-200 focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                                        <div wire:loading wire:target="productSearch" class="text-xs text-gray-500 mt-1">Searching...</div>
                                                    </div>
                                                    <ul class="max-h-40 overflow-y-auto">
                                                        @forelse($products as $product)
                                                            <li @click="open = false" wire:click="selectProduct({{ $index }}, {{ $product->id }})" class="text-gray-900 dark:text-gray-200 relative cursor-default select-none py-2 pl-3 pr-9 hover:bg-indigo-600 hover:text-white">
                                                                <div class="flex flex-col">
                                                                    <span class="font-normal block truncate">{{ $product->name }}</span>
                                                                    <span class="text-xs opacity-70">Stock: {{ $product->quantity }} | Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                                                </div>
                                                            </li>
                                                        @empty
                                                             <li class="text-gray-500 relative cursor-default select-none py-2 pl-3 pr-9">No products found.</li>
                                                        @endforelse
                                                    </ul>
                                                </div>
                                            </div>
                                            @error("items.{$index}.product_id") <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                        </div>

                                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4 w-full md:w-auto">
                                            <div>
                                                <label for="qty-{{$index}}" class="text-xs font-medium text-gray-500 dark:text-gray-400">Qty</label>
                                                <flux:input id="qty-{{$index}}" wire:model.live.debounce.300ms="items.{{ $index }}.quantity" type="number" min="1" class="mt-1 w-24" />
                                                @error("items.{$index}.quantity") <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                            </div>
                                            <div>
                                                <label class="text-xs font-medium text-gray-500 dark:text-gray-400">Price</label>
                                                <div class="mt-1 p-2 h-10 flex items-center rounded-md bg-gray-200 dark:bg-zinc-800 text-gray-600 dark:text-gray-400 w-32">
                                                    Rp {{ number_format($item['unit_price'] ?? 0, 0, ',', '.') }}
                                                </div>
                                            </div>
                                            <div class="col-span-2 md:col-span-1">
                                                <label class="text-xs font-medium text-gray-500 dark:text-gray-400">Total</label>
                                                <div class="mt-1 p-2 h-10 flex items-center rounded-md bg-gray-200 dark:bg-zinc-800 font-semibold text-gray-800 dark:text-gray-200 w-36">
                                                    Rp {{ number_format($item['total_price'] ?? 0, 0, ',', '.') }}
                                                </div>
                                            </div>
                                        </div>

                                        <div class="flex-shrink-0 md:pt-5">
                                            @if(count($items) > 1)
                                                <button type="button" wire:click="removeItem({{ $index }})" class="text-gray-400 hover:text-red-500 dark:hover:text-red-400 transition p-2 rounded-full hover:bg-red-100 dark:hover:bg-red-900/50">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-12 border-2 border-dashed border-gray-300 dark:border-zinc-700 rounded-xl">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                        <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                                    </svg>
                                    <h3 class="mt-2 text-sm font-semibold text-gray-900 dark:text-gray-200">No items added</h3>
                                    <p class="mt-1 text-sm text-gray-500">Get started by adding an item to the sale.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <div class="border-t border-gray-200 dark:border-zinc-700 mt-6 pt-6">
                        <div class="flex justify-between items-center">
                            <flux:heading size="lg">{{ __('Total Amount') }}</flux:heading>
                            <div class="text-right">
                                <flux:heading size="xl" class="text-indigo-600 dark:text-indigo-400">Rp {{ number_format($total_amount, 0, ',', '.') }}</flux:heading>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end mt-8">
                        <flux:button type="submit" wire:loading.attr="disabled" wire:target="store">
                            <span wire:loading.remove wire:target="store">{{ __('Create Sale') }}</span>
                            <span wire:loading wire:target="store">{{ __('Creating...') }}</span>
                        </flux:button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
