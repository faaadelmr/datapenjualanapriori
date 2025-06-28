<div>
    <section class="w-full">
        <div class="flex justify-between items-center mb-6">
            <flux:heading>{{ __('Add New Product') }}</flux:heading>
            <flux:button href="{{ route('products.index') }}" variant="outline">{{ __('Back to Products') }}</flux:button>
        </div>

        <div class="bg-white dark:bg-zinc-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <form wire:submit="store" class="space-y-6">
                    <div>
                        <flux:input wire:model="name" :label="__('Product Name')" required />
                        @error('name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <flux:input wire:model="quantity" type="number" :label="__('Quantity')" required />
                        @error('quantity') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <flux:input wire:model="price" type="number" step="0.01" :label="__('Price')" required />
                        @error('price') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex justify-end">
                        <flux:button type="submit">{{ __('Create Product') }}</flux:button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
