<div>
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Date
                </th>
                <th scope="col" class="px-6 py-3">
                    Amount
                </th>
                <th scope="col" class="px-6 py-3">
                    Method
                </th>
                <th scope="col" class="px-6 py-3">
                    Transaction ID
                </th>
                 <th scope="col" class="px-6 py-3">
                    Notes
                </th>
            </tr>
        </thead>
        <tbody>
            @forelse($record->payments as $payment)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <td class="px-6 py-4">
                        {{ $payment->created_at->format('M d, Y H:i') }}
                    </td>
                    <td class="px-6 py-4">
                        {{ number_format($payment->amount, 2) }}
                    </td>
                    <td class="px-6 py-4">
                        {{ ucfirst($payment->payment_method) }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $payment->transaction_id ?? '-' }}
                    </td>
                     <td class="px-6 py-4">
                        {{ $payment->notes ?? '-' }}
                    </td>
                </tr>
            @empty
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <td colspan="5" class="px-6 py-4 text-center">
                        No payments found.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
