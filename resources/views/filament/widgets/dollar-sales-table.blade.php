<x-filament-widgets::widget class="col-span-full" style="grid-column: 1 / -1 !important;">
    <x-filament::section>
        {{-- Filters --}}
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
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
        <div style="margin-top: 1.5rem; overflow: hidden; border-radius: 0.75rem; background-color: white; box-shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1); border: 1px solid rgb(229 231 235);">
            <div style="overflow-x: auto;">
                <table style="width: 100%; table-layout: fixed; border-collapse: collapse;">
                    <thead>
                        <tr style="background-color: rgb(249 250 251);">
                            <th style="width: 15% !important; min-width: 15%; padding: 0.875rem 1.5rem; text-align: left; font-size: 0.875rem; font-weight: 600; color: rgb(17 24 39);">
                                Year
                            </th>
                            <th style="width: 20% !important; min-width: 20%; padding: 0.875rem 1.5rem; text-align: left; font-size: 0.875rem; font-weight: 600; color: rgb(17 24 39);">
                                Month
                            </th>
                            <th style="width: 15% !important; min-width: 15%; padding: 0.875rem 1.5rem; text-align: center; font-size: 0.875rem; font-weight: 600; color: rgb(17 24 39);">
                                Sales
                            </th>
                            <th style="width: 25% !important; min-width: 25%; padding: 0.875rem 1.5rem; text-align: right; font-size: 0.875rem; font-weight: 600; color: rgb(17 24 39);">
                                Dollar Sold
                            </th>
                            <th style="width: 25% !important; min-width: 25%; padding: 0.875rem 1.5rem; text-align: right; font-size: 0.875rem; font-weight: 600; color: rgb(17 24 39);">
                                Profit
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($this->getData() as $row)
                            <tr style="border-top: 1px solid rgb(229 231 235); transition: background-color 0.15s;" onmouseover="this.style.backgroundColor='rgb(249 250 251)'" onmouseout="this.style.backgroundColor='white'">
                                <td style="padding: 1rem 1.5rem; font-size: 0.875rem; color: rgb(17 24 39);">
                                    {{ $row->year }}
                                </td>
                                <td style="padding: 1rem 1.5rem; font-size: 0.875rem; color: rgb(17 24 39);">
                                    {{ DateTime::createFromFormat('!m', $row->month)->format('F') }}
                                </td>
                                <td style="padding: 1rem 1.5rem; text-align: center; font-size: 0.875rem; font-weight: 500; color: rgb(17 24 39);">
                                    {{ $row->total_sales }}
                                </td>
                                <td style="padding: 1rem 1.5rem; text-align: right; font-size: 0.875rem; color: rgb(17 24 39);">
                                    ${{ number_format($row->total_amount, 2) }}
                                </td>
                                <td style="padding: 1rem 1.5rem; text-align: right; font-size: 0.875rem; font-weight: 600; color: rgb(22 163 74);">
                                    ৳{{ number_format($row->total_profit, 2) }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="padding: 3rem 1.5rem; text-align: center; font-size: 0.875rem; color: rgb(107 114 128);">
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
