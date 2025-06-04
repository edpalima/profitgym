<x-filament::page>
    <x-filament::card>
        <form wire:submit.prevent="generateReport">
            <div class="flex flex-wrap items-end gap-4">
                <!-- Start Date -->
                <div class="flex-1">
                    <label for="startDate" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Start
                        Date</label>
                    <input type="date" id="startDate" wire:model="startDate"
                        class="block w-full mt-1 rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white shadow-sm">
                </div>

                <!-- End Date -->
                <div class="flex-1">
                    <label for="endDate" class="block text-sm font-medium text-gray-700 dark:text-gray-300">End
                        Date</label>
                    <input type="date" id="endDate" wire:model="endDate"
                        class="block w-full mt-1 rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white shadow-sm">
                </div>

                <!-- Buttons -->
                <div class="flex gap-2">
                    <x-filament::button type="submit" wire:loading.attr="disabled">
                        Generate Reports
                    </x-filament::button>
                    <x-filament::button wire:click="exportExcel" wire:loading.attr="disabled"
                        icon="heroicon-o-arrow-down-tray">
                        Excel
                    </x-filament::button>
                    <x-filament::button wire:click="printPdf" wire:loading.attr="disabled"
                        icon="heroicon-o-arrow-down-tray">
                        PDF
                    </x-filament::button>
                </div>
            </div>
        </form>

        <br>

        <!-- Revenue Table -->
        <div class="mt-8 overflow-x-auto">
            <table class="w-full table-auto border-collapse border border-gray-300 dark:border-gray-600">
                <thead>
                    <tr class="bg-gray-100 dark:bg-gray-700">
                        <th
                            class="px-4 py-2 text-left text-sm font-semibold text-gray-700 dark:text-gray-300 border border-gray-300 dark:border-gray-600">
                            Date</th>
                        <th
                            class="px-4 py-2 text-left text-sm font-semibold text-gray-700 dark:text-gray-300 border border-gray-300 dark:border-gray-600">
                            Revenue</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($revenues as $revenue)
                        <tr>
                            <td class="px-4 py-2 border border-gray-300 dark:border-gray-600">{{ $revenue['date'] }}
                            </td>
                            <td class="px-4 py-2 border border-gray-300 dark:border-gray-600">
                                ₱{{ number_format((float) $revenue['revenue_raw'], 2) }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="px-4 py-2 text-center text-gray-500 dark:text-gray-400">
                                No revenue data available for the selected date range.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
                @if (!empty($revenues))
                    <tfoot>
                        <tr class="bg-gray-200 dark:bg-gray-800 font-semibold">
                            <td class="px-4 py-2 border border-gray-300 dark:border-gray-600">Total Revenue</td>
                            <td class="px-4 py-2 border border-gray-300 dark:border-gray-600">
                                ₱{{ number_format($totalRevenue, 2) }}</td>
                        </tr>
                    </tfoot>
                @endif
            </table>
        </div>
    </x-filament::card>
</x-filament::page>
