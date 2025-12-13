<x-filament-widgets::widget class="col-span-full" style="grid-column: 1 / -1 !important;">
    <x-filament::section>
        {{-- Filters --}}
        <div style="display: flex; flex-wrap: wrap; gap: 1rem; margin-bottom: 1.5rem; align-items: flex-end;">
            <div style="flex: 1; min-width: 150px;">
                <label style="display: block; font-size: 0.875rem; font-weight: 500; color: rgb(55 65 81); margin-bottom: 0.25rem;">Year</label>
                <x-filament::input.wrapper>
                    <x-filament::input.select wire:model="selectedYear">
                        <option value="all">All Years</option>
                        @foreach($this->getYears() as $year)
                            <option value="{{ $year }}">{{ $year }}</option>
                        @endforeach
                    </x-filament::input.select>
                </x-filament::input.wrapper>
            </div>
            
            <div style="flex: 1; min-width: 150px;">
                <label style="display: block; font-size: 0.875rem; font-weight: 500; color: rgb(55 65 81); margin-bottom: 0.25rem;">Month</label>
                <x-filament::input.wrapper>
                    <x-filament::input.select wire:model="selectedMonth">
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

            <div style="flex: 1; min-width: 150px;">
                <label style="display: block; font-size: 0.875rem; font-weight: 500; color: rgb(55 65 81); margin-bottom: 0.25rem;">Date From</label>
                <x-filament::input.wrapper>
                    <x-filament::input type="date" wire:model="dateFrom" />
                </x-filament::input.wrapper>
            </div>

            <div style="flex: 1; min-width: 150px;">
                <label style="display: block; font-size: 0.875rem; font-weight: 500; color: rgb(55 65 81); margin-bottom: 0.25rem;">Date To</label>
                <x-filament::input.wrapper>
                    <x-filament::input type="date" wire:model="dateTo" />
                </x-filament::input.wrapper>
            </div>

            <button wire:click="applyFilters" type="button" style="padding: 0.625rem 1.5rem; background-color: rgb(251 146 60); color: white; font-size: 0.875rem; font-weight: 600; border-radius: 0.5rem; border: none; cursor: pointer; transition: background-color 0.15s; white-space: nowrap; height: 42px;" onmouseover="this.style.backgroundColor='rgb(249 115 22)'" onmouseout="this.style.backgroundColor='rgb(251 146 60)'">
                Filter
            </button>
        </div>

        {{-- Active Filter Summary --}}
        @if($appliedDateFrom || $appliedDateTo || ($appliedYear !== 'all' && $appliedYear != date('Y')) || $appliedMonth !== 'all')
            <div style="margin-bottom: 1rem; padding: 0.75rem; background-color: rgb(243 244 246); border-radius: 0.5rem; font-size: 0.875rem; color: rgb(55 65 81); display: flex; align-items: center; justify-content: space-between;">
                <div>
                    <span style="font-weight: 600; margin-right: 0.5rem;">Active Filter:</span>
                    
                    @if($appliedDateFrom || $appliedDateTo)
                        <span style="background-color: rgb(224 231 255); color: rgb(67 56 202); padding: 0.125rem 0.5rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 500;">
                            Date: 
                            @if($appliedDateFrom) {{ \Carbon\Carbon::parse($appliedDateFrom)->format('M d, Y') }} @endif
                            @if($appliedDateFrom && $appliedDateTo) - @endif
                            @if($appliedDateTo) {{ \Carbon\Carbon::parse($appliedDateTo)->format('M d, Y') }} @endif
                        </span>
                    @else
                        @if($appliedYear !== 'all')
                            <span style="background-color: rgb(224 231 255); color: rgb(67 56 202); padding: 0.125rem 0.5rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 500; margin-right: 0.5rem;">
                                Year: {{ $appliedYear }}
                            </span>
                        @endif
                        
                        @if($appliedMonth !== 'all')
                            <span style="background-color: rgb(224 231 255); color: rgb(67 56 202); padding: 0.125rem 0.5rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 500;">
                                Month: {{ DateTime::createFromFormat('!m', $appliedMonth)->format('F') }}
                            </span>
                        @endif
                    @endif
                </div>
                
                <button wire:click="resetFilters" type="button" style="color: rgb(107 114 128); font-size: 0.75rem; font-weight: 500; text-decoration: underline; background: none; border: none; cursor: pointer; padding: 0.25rem 0.5rem;" onmouseover="this.style.color='rgb(31 41 55)'" onmouseout="this.style.color='rgb(107 114 128)'">
                    Clear Filters
                </button>
            </div>
        @endif

        {{-- Table --}}
        <div style="margin-top: 1.5rem; overflow: hidden; border-radius: 0.75rem; background-color: white; box-shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1); border: 1px solid rgb(229 231 235);">
            <div style="overflow-x: auto;" wire:key="table-{{ $appliedYear }}-{{ $appliedMonth }}-{{ $appliedDateFrom }}-{{ $appliedDateTo }}">
                <table style="width: 100%; table-layout: fixed; border-collapse: collapse;">
                    <thead>
                        <tr style="background-color: rgb(249 250 251);">
                            <th style="width: 10% !important; min-width: 10%; padding: 0.875rem 1.5rem; text-align: left; font-size: 0.875rem; font-weight: 600; color: rgb(17 24 39);">
                                Year
                            </th>
                            <th style="width: 12% !important; min-width: 12%; padding: 0.875rem 1.5rem; text-align: left; font-size: 0.875rem; font-weight: 600; color: rgb(17 24 39);">
                                Month
                            </th>
                            <th style="width: 10% !important; min-width: 10%; padding: 0.875rem 1.5rem; text-align: center; font-size: 0.875rem; font-weight: 600; color: rgb(17 24 39);">
                                Sales
                            </th>
                            <th style="width: 12% !important; min-width: 12%; padding: 0.875rem 1.5rem; text-align: center; font-size: 0.875rem; font-weight: 600; color: rgb(17 24 39);">
                                Fully Paid
                            </th>
                            <th style="width: 12% !important; min-width: 12%; padding: 0.875rem 1.5rem; text-align: center; font-size: 0.875rem; font-weight: 600; color: rgb(17 24 39);">
                                Due Count
                            </th>
                            <th style="width: 15% !important; min-width: 15%; padding: 0.875rem 1.5rem; text-align: right; font-size: 0.875rem; font-weight: 600; color: rgb(17 24 39);">
                                Dollar Sold
                            </th>
                            <th style="width: 15% !important; min-width: 15%; padding: 0.875rem 1.5rem; text-align: right; font-size: 0.875rem; font-weight: 600; color: rgb(17 24 39);">
                                Profit
                            </th>
                            <th style="width: 14% !important; min-width: 14%; padding: 0.875rem 1.5rem; text-align: right; font-size: 0.875rem; font-weight: 600; color: rgb(17 24 39);">
                                Total Due
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
                                <td style="padding: 1rem 1.5rem; text-align: center; font-size: 0.875rem; font-weight: 500; color: rgb(34 197 94);">
                                    {{ $row->fully_paid_count }}
                                </td>
                                <td style="padding: 1rem 1.5rem; text-align: center; font-size: 0.875rem; font-weight: 500; color: rgb(239 68 68);">
                                    {{ $row->due_count }}
                                </td>
                                <td style="padding: 1rem 1.5rem; text-align: right; font-size: 0.875rem; color: rgb(17 24 39);">
                                    ${{ number_format($row->total_amount, 2) }}
                                </td>
                                <td style="padding: 1rem 1.5rem; text-align: right; font-size: 0.875rem; font-weight: 600; color: rgb(22 163 74);">
                                    ৳{{ number_format($row->total_profit, 2) }}
                                </td>
                                <td style="padding: 1rem 1.5rem; text-align: right; font-size: 0.875rem; font-weight: 600; color: rgb(220 38 38);">
                                    ৳{{ number_format($row->total_due, 2) }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" style="padding: 3rem 1.5rem; text-align: center; font-size: 0.875rem; color: rgb(107 114 128);">
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
