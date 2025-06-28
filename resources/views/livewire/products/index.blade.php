<div>
    <section class="w-full">
        <div class="flex justify-between items-center mb-6">
            <flux:heading>{{ __('Products') }}</flux:heading>
            <flux:button href="{{ route('products.create') }}">{{ __('Add Product') }}</flux:button>
        </div>

        <div class="mb-4">
            <flux:input wire:model.live="search" placeholder="Search products..." />
        </div>

        <div class="bg-white dark:bg-zinc-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                @if (session()->has('message'))
                    <div class="mb-4 text-sm text-green-600">
                        {{ session('message') }}
                    </div>
                @endif

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-zinc-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Quantity</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Price</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-zinc-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse ($products as $product)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">{{ $product->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">{{ $product->quantity }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">Rp. {{ number_format($product->price) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end space-x-2">
                                            <flux:button href="{{ route('products.edit', $product) }}" size="xs" variant="outline">Edit</flux:button>
                                            <flux:button wire:click="confirmDelete({{ $product->id }})" size="xs" variant="danger">Delete</flux:button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300 text-center">No products found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $products->links() }}
                </div>
            </div>
        </div>

        <!-- Delete Confirmation Modal -->
        <flux:modal name="confirm-product-deletion" :show="$confirmingProductDeletion" focusable class="max-w-lg">
            <div class="space-y-6">
                <div>
                    <flux:heading size="lg">{{ __('Are you sure you want to delete this product?') }}</flux:heading>
                    <flux:subheading>
                        {{ __('Once deleted, this product will be permanently removed.') }}
                    </flux:subheading>
                </div>

                <div class="flex justify-end space-x-2 rtl:space-x-reverse">
                    <flux:button wire:click="cancelDelete" variant="filled">{{ __('Cancel') }}</flux:button>
                    <flux:button wire:click="deleteProduct" variant="danger">{{ __('Delete Product') }}</flux:button>
                </div>
            </div>
        </flux:modal>
    </section>
</div>
