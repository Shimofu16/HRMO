<div>
    <div class="container mx-auto">
        <div class="flex flex-col items-center justify-center my-5">
            <div class="flex mt-5 space-x-10">
                <!-- Signature Dropdowns -->
                <div class="flex flex-col">
                    <h3 class="mb-3 text-md">Signatures</h3>
                    <div class="flex flex-col space-y-3">
                        @php
                            $count = 1;
                            if ($payment_method == 'atm' || $payment_method == 'cash') {
                                $count = 4;
                                if ($payment_method == 'cash' && $employment_type == 'jo') {
                                    $count = 5;
                                }
                            }
                        @endphp
                        @for ($i = 1; $i <= $count; $i++)
                            <div class="flex flex-col">
                                <label for="signature{{ $i }}" class="mb-1 text-sm text-gray">Signature {{ $i }}</label>
                                <select id="signature{{ $i }}" wire:model.live="selected_signatures.{{ $i }}" class="text-sm border-gray-300 rounded-lg">
                                    <option value="" selected>Please select here</option>
                                    @foreach ($signatures as $signature)
                                        <option value="{{ $signature->name }}">{{ $signature->name }} - {{ $signature->position }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endfor
                    </div>
                </div>

                <!-- Payment and Employment Type Dropdowns -->
                <div class="flex flex-col">
                    <h3 class="mb-3 text-md">Types of Payroll</h3>
                    <div class="flex space-x-3">
                        <div class="flex flex-col">
                            <label for="payment_method" class="mb-1 text-sm text-gray">Payment</label>
                            <select name="payment_method" id="payment_method" wire:model.live='payment_method' class="text-sm border-gray-300 rounded-lg">
                                <option value="" selected>Please select here</option>
                                <option value="atm">ATM</option>
                                <option value="cash">Cash</option>
                            </select>
                        </div>
                        <div class="flex flex-col">
                            <label for="employment_type" class="mb-1 text-sm text-gray">Employment</label>
                            <select name="employment_type" id="employment_type" wire:model.live='employment_type' class="text-sm border-gray-300 rounded-lg">
                                <option value="" selected>Please select here</option>
                                <option value="perm">Permanent</option>
                                <option value="cas">Casual</option>
                                <option value="cos">Contract of Service</option>
                                <option value="jo">Job Order</option>
                                <option value="elect">Elective</option>
                                <option value="coterm">Coterminous</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Generate Button -->
            <div class="flex flex-col mt-5" style="width: 200px">
                <button type="button" class="text-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-xs px-5 py-2.5 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800" onclick="generatePDF('{{ $filename }}')">
                    Download
                </button>
                <a href="{{ route('payrolls.index') }}" class="text-center text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-xs px-5 py-2.5 mb-2 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700">
                    Back to Payroll
                </a>
            </div>
        </div>
    </div>

    <div id="element-to-print" class="overflow-x-auto">
        @if ($employment_type)
            @if ($isEmpty)
                <h3 class="p-4 mb-3 text-xl text-center text-white bg-red-600">No Employees found</h3>
            @else
                @if ($payment_method == 'atm')
                    <!-- ATM Payroll Table -->
                    @include('livewire.payroll.partials.atm')
                @elseif ($payment_method == 'cash')
                    <!-- Cash Payroll Table -->
                    @include('livewire.payroll.partials.cash')
                @endif
            @endif
        @endif
    </div>
</div>
