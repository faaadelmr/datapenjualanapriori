<div>
    <section class="w-full">
        <div class="flex justify-between items-center mb-6">
            <flux:heading>{{ __('Edit Sale') }} {{ $sale->invoice_number }}</flux:heading>
            <flux:button href="{{ route('sales.show', $sale) }}" variant="outline">{{ __('Back to Invoice') }}</flux:button>
        </div>

        <div class="bg-white dark:bg-zinc-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                @if (session()->has('error'))
                    <div class="mb-4 text-sm text-red-600">
                        {{ session('error') }}
                    </div>
                @endif

                <form wire:submit="update" class="space-y-6">
                    <div>
                        <flux:input wire:model="sale_date" type="date" :label="__('Sale Date')" required />
                        @error('sale_date') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <div class="flex justify-between items-center mb-4">
                            <flux:heading size="sm">{{ __('Items') }}</flux:heading>
                            <flux:button type="button" wire:click="addItem" size="xs">{{ __('Add Item') }}</flux:button>
                        </div>

                        @foreach($items as $index => $item)
                            <div class="grid grid-cols-12 gap-4 mb-4 p-4 border rounded-lg">
                                <div class="col-span-4">
                                    <select wire:model.live="items.{{ $index }}.product_id" class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600">
                                        <option value="">Select Product</option>
                                        @foreach($products as $product)
                                            <option value="{{ $product->id }}">{{ $product->name }} (Stock: {{ $product->quantity }})</option>
                                        @endforeach
                                    </select>
                                    @error("items.{$index}.product_id") <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>

                                <div class="col-span-2">
                                    <flux:input wire:model.live="items.{{ $index }}.quantity" type="number" min="1" placeholder="Qty" />
                                    @error("items.{$index}.quantity") <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>

                                <div class="col-span-2">
                                    <flux:input wire:model="items.{{ $index }}.unit_price" type="number" step="0.01" placeholder="Price" readonly />
                                </div>

                                <div class="col-span-3">
                                    <flux:input wire:model="items.{{ $index }}.total_price" type="number" step="0.01" placeholder="Total" readonly />
                                </div>

                                <div class="col-span-1">
                                    @if(count($items) > 1)
                                        <flux:button type="button" wire:click="removeItem({{ $index }})" variant="danger" size="xs">Remove</flux:button>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="border-t pt-4">
                        <div class="flex justify-between items-center">
                            <flux:heading size="lg">{{ __('Total Amount') }}</flux:heading>
                            <flux:heading size="lg">Rp {{ number_format($total_amount, 0, ',', '.') }}</flux:heading>
                        </div>
                    </div>

                    <div class="flex justify-end">
                        <flux:button type="submit">{{ __('Update Sale') }}</flux:button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
