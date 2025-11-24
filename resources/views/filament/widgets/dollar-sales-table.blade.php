<x-filament-widgets::widget>
    <x-filament::section>
        {{-- Filters --}}
        <div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-2">
            <x-filament::input.wrapper>
                <x-filament::input.select wire:model.live="selectedYear">
                    <option value="all">All Years</option>
                    @foreach($this->getYears() as $year)
                        <option value="{{ $year }}">{{ $year }}</option>
                    @endforeach
                </x-filament::input.select>
            </x-filament::input.wrapper>
            
            <x-filament::input.wrapper>
                <x-filament::input.select wire:model.live="selectedMonth">
                    <option value="all">All Months</option>
                    <option value="1">January</option>
                    <option value="2">February</option>
                    <option value="3">March</option>
                    <option value="4">April</option>
                    <option value="5">May</option>
                    <option value="6">June</option>
                    <option value="7">July</option>
                    <option value="8">August</option>
                    <option value="9">September</option>
                    <option value="10">October</option>
                    <option value="11">November</option>
                    <option value="12">December</option>
                </x-filament::input.select>
            </x-filament::input.wrapper>
        </div>

        {{-- Table --}}
        <div class="overflow-hidden rounded-lg border border-gray-200 dark:border-gray-700">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-800">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-700 dark:text-gray-300">
                                Year
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-700 dark:text-gray-300">
                                Month
                            </th>
                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium uppercase tracking-wider text-gray-700 dark:text-gray-300">
                                Sales
                            </th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider text-gray-700 dark:text-gray-300">
                                Dollar Sold
                            </th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider text-gray-700 dark:text-gray-300">
                                Profit
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white dark:divide-gray-700 dark:bg-gray-900">
                        @forelse($this->getData() as $row)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50">
                                <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900 dark:text-gray-100">
                                    {{ $row->year }}
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-700 dark:text-gray-300">
                                    {{ DateTime::createFromFormat('!m', $row->month)->format('F') }}
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-center text-sm font-semibold text-gray-900 dark:text-gray-100">
                                    {{ $row->total_sales }}
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-right text-sm text-gray-900 dark:text-gray-100">
                                    ${{ number_format($row->total_amount, 2) }}
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-right text-sm font-bold text-green-600 dark:text-green-400">
                                    ৳{{ number_format($row->total_profit, 2) }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-sm text-gray-500 dark:text-gray-400">
                                    No sales data found. Try adjusting your filters.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
