<x-filament-panels::page>
@vite('resources/css/app.css')

@if($record)

<div class="mx-auto w-[420px] space-y-2"> {{-- MEDIUM COMPACT --}}

    {{-- ORGANIZATION HEADER --}}
    <div class="text-center pb-2 border-b border-gray-300 dark:border-gray-700">
        <h1 class="text-lg font-bold text-gray-900 dark:text-white leading-tight">
            {{ config('app.name') ?? 'Your Organization' }}
        </h1>
        <p class="text-sm text-gray-600 dark:text-gray-400 leading-tight">
            Phone: {{ $record->organization_phone ?? '01XXXXXXXXX' }}
        </p>
    </div>

{{-- Top Section: Customer Left | Invoice Right --}}
<div class="bg-white dark:bg-gray-800 shadow rounded p-2 flex justify-between">

    {{-- LEFT: CUSTOMER INFO --}}
    <div class="text-left text-sm leading-tight">
        <p><span class="text-gray-500">Name:</span>
            <span class="font-medium">{{ $record->customer?->name ?? 'N/A' }}</span>
        </p>

        <p><span class="text-gray-500">Phone:</span>
            <span class="font-medium">{{ $record->customer?->phone ?? 'N/A' }}</span>
        </p>

        <p><span class="text-gray-500">Address:</span>
            <span class="text-xs font-medium">{{ $record->customer?->address ?? 'N/A' }}</span>
        </p>
    </div>

    {{-- RIGHT: INVOICE INFO --}}
    <div class="text-right leading-tight">
        <h2 class="text-base font-semibold text-gray-900 dark:text-white">
            Invoice #{{ $record->id }}
        </h2>
        <p class="text-sm text-gray-600 dark:text-gray-400">
            {{ $record->created_at->format('F d, Y') }}
        </p>
    </div>

</div>


    {{-- SALE DETAILS --}}
    <div class="bg-white dark:bg-gray-800 shadow rounded p-2">
        <h3 class="text-sm font-semibold mb-1">Sale Details</h3>

        <div class="space-y-2">

            <div class="border dark:border-gray-700 rounded p-2 bg-gray-50 dark:bg-gray-900">
                <p class="text-xs text-gray-500">Description</p>
                <p class="text-sm font-medium">Dollar Sale</p>

                <div class="flex justify-between text-sm mt-1">
                    <span class="text-gray-600">Amount:</span>
                    <span class="font-semibold">${{ number_format($record->amount, 2) }}</span>
                </div>

                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">Rate:</span>
                    <span class="font-semibold">৳{{ number_format($record->rate, 2) }}</span>
                </div>

                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">Total:</span>
                    <span class="font-semibold">৳{{ number_format($record->total_price, 2) }}</span>
                </div>
            </div>

            <div class="border dark:border-gray-700 rounded p-2 bg-gray-50 dark:bg-gray-900">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">Paid:</span>
                    <span class="font-semibold">৳{{ number_format($record->payments->sum('amount'), 2) }}</span>
                </div>
            </div>

            <div class="border dark:border-gray-700 rounded p-2 bg-gray-50 dark:bg-gray-900">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">Due:</span>
                    <span class="font-semibold text-red-600">
                        ৳{{ number_format($record->total_price - $record->payments->sum('amount'), 2) }}
                    </span>
                </div>
            </div>

        </div>
    </div>

    {{-- SUMMARY --}}
    <div class="bg-white dark:bg-gray-800 shadow rounded p-2">
        <div class="space-y-1 text-sm">

            <div class="flex justify-between">
                <span>Total:</span>
                <span class="font-semibold">৳{{ number_format($record->total_price, 2) }}</span>
            </div>

            <div class="flex justify-between border-t pt-1">
                <span>Paid:</span>
                <span class="font-semibold">৳{{ number_format($record->payments->sum('amount'), 2) }}</span>
            </div>

            <div class="flex justify-between border-t pt-1">
                <span>Due:</span>
                <span class="font-semibold text-red-600">
                    ৳{{ number_format($record->total_price - $record->payments->sum('amount'), 2) }}
                </span>
            </div>

        </div>

        {{-- Auto-generated note --}}
        <div class="text-center mt-3">
            <p class="text-xs text-gray-500 italic">
                This invoice was automatically generated and does not require a signature.
            </p>
        </div>
    </div>

</div>

@else
<div class="text-center py-4">
    <p class="text-sm text-gray-500">No record found.</p>
</div>
@endif

</x-filament-panels::page>
