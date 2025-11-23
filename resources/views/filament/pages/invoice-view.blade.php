<x-filament-panels::page>
@vite('resources/css/app.css')

    @if($record)
        <div class="space-y-6">
            {{-- Invoice Header --}}
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <div class="flex justify-between items-start">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Invoice #{{ $record->id }}</h2>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                            Date: {{ $record->created_at->format('F d, Y') }}
                        </p>
                    </div>
                    <div class="ml-auto">
                        <x-filament::button wire:click="downloadInvoice" class="bg-indigo-600 hover:bg-indigo-700 text-white">
                            Download PDF
                        </x-filament::button>
                    </div>
                </div>
            </div>

            {{-- Customer Information --}}
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Customer Information</h3>
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Customer Name</p>
                    <p class="text-base text-gray-900 dark:text-white">{{ $record->customer?->name ?? 'N/A' }}</p>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Customer Phone</p>
                <p class="text-base text-gray-900 dark:text-white">{{ $record->customer?->phone ?? 'N/A' }}</p>
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400 mt-2">Customer Address</p>
                <p class="text-base text-gray-900 dark:text-white">{{ $record->customer?->address ?? 'N/A' }}</p>
                </div>
            </div>

            {{-- Sale Details --}}
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Sale Details</h3>
                <div class="overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
        <thead class="bg-gray-50 dark:bg-gray-900">
            <tr>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Description</th>
                <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Amount</th>
                <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Rate</th>
                <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Total</th>
            </tr>
        </thead>
        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
    <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
        <td class="px-4 py-4 text-sm text-gray-900 dark:text-white">Dollar Sale</td>
        <td class="px-4 py-4 text-sm text-right text-gray-900 dark:text-white">${{ number_format($record->amount ?? 0, 2) }}</td>
        <td class="px-4 py-4 text-sm text-right text-gray-900 dark:text-white">{{ number_format($record->rate ?? 0, 2) }}</td>
        <td class="px-4 py-4 text-sm text-right text-gray-900 dark:text-white">৳{{ number_format($record->total_price ?? 0, 2) }}</td>
    </tr>
    <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
        <td class="px-4 py-4 text-sm text-gray-900 dark:text-white">Paid Amount</td>
        <td class="px-4 py-4 text-sm text-right text-gray-900 dark:text-white">৳{{ number_format($record->payments->sum('amount') ?? 0, 2) }}</td>
        <td class="px-4 py-4 text-sm text-right text-gray-900 dark:text-white">-</td>
        <td class="px-4 py-4 text-sm text-right text-gray-900 dark:text-white">-</td>
    </tr>
    <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
        <td class="px-4 py-4 text-sm text-gray-900 dark:text-white">Due Amount</td>
        <td class="px-4 py-4 text-sm text-right text-gray-900 dark:text-white">৳{{ number_format(($record->total_price ?? 0) - $record->payments->sum('amount'), 2) }}</td>
        <td class="px-4 py-4 text-sm text-right text-gray-900 dark:text-white">-</td>
        <td class="px-4 py-4 text-sm text-right text-gray-900 dark:text-white">-</td>
    </tr>
</tbody>
    </table>
</div>
            </div>

            {{-- Summary --}}
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <div class="flex justify-end">
                    <div class="w-64 space-y-2">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600 dark:text-gray-400">Total Price:</span>
                            <span class="font-semibold text-gray-900 dark:text-white">৳{{ number_format($record->total_price ?? 0, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-sm border-t pt-2">
                            <span class="text-gray-600 dark:text-gray-400">Paid Amount:</span>
                            <span class="font-semibold text-gray-900 dark:text-white">৳{{ number_format($record->payments->sum('amount') ?? 0, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-sm border-t pt-2">
                            <span class="text-gray-600 dark:text-gray-400">Due Amount:</span>
                            <span class="font-semibold text-red-600 dark:text-red-400">৳{{ number_format(($record->total_price ?? 0) - $record->payments->sum('amount'), 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="text-center py-12">
            <p class="text-gray-500 dark:text-gray-400">No record found.</p>
        </div>
    @endif
</x-filament-panels::page>

