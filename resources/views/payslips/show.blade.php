<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Payslip List
        </h2>
    </x-slot>
    <style>
        .border-2 {
            border: 2px solid #1a1a1a;
        }

        .border-dashed-right {
            border-right: 2px dashed #1a1a1a !important;
        }

        .border-bottom-2 {
            border-bottom: 2px solid #1a1a1a !important;
        }

        table {
            width: 100%;
        }

        /* remove border from table*/

        table tr td {
            border: none !important;
        }
    </style>
    <div class="py-12">
        <div class="flex justify-center mb-3 space-x-3">
            <div class="">
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                    onclick="generatePDF()">Generate PDF</button>

            </div>
        </div>
        <div class="container mx-auto" id="canvas">
            @foreach ($employees as $employee)
                @php
                    $mandatoryDeductions = $employee->getDeductionsBy('Mandatory');
                    $nonmandatoryDeductions = $employee->getDeductionsBy('Non Mandatory');
                    $allowances = $employee->allowances;
                    $salary_grade = $employee->sgrade->sg_amount / 2;
                    $totalDeduction = $employee->computeDeduction();
                    $totalAllowance = $employee->computeAllowance();
                    $totalAmountEarned = $salary_grade + $totalAllowance;
                    $netpay = $totalAmountEarned - $totalDeduction;
                    // dd($mandatoryDeductions,$nonmandatoryDeductions,$totalDeduction);
                @endphp

                <div class="grid grid-cols-1 md:grid-cols-12 gap-4 border-2 p-4 m-2">
                    <div class="col-span-9 border-dashed-right md:pr-4">
                        <div class="title mb-2 text-center">
                            <h6 class="text-xl font-semibold">MUNICIPALITY OF CALAUAN</h6>
                            <span class="block">{{ $department->dep_name }}</span>
                        </div>
                        <div class="grid grid-cols-6 gap-4 mb-3">
                            <div class="col-span-3">
                                <span class="font-semibold">Name: {{ $employee->name }}</span>
                            </div>
                            <div class="col-span-3">
                                <div class="text-right">
                                    <span class="font-semibold">Period: {{ $filter['from'] }}-{{ $filter['to'] }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="border-dashed-right md:pr-4">
                                <h6 class="text-center font-semibold mb-2">EARNINGS</h6>
                                <span class="font-semibold">MONTHLY SALARY:
                                    {{ number_format($salary_grade) }}</span><br>
                                <span class="font-semibold">AMOUNT EARNED:
                                    {{ number_format($salary_grade / 2) }}</span><br>
                                <h6 class="text-center font-semibold mb-2">ALLOWANCES</h6>
                                @foreach ($allowances as $itemallowance)
                                    <span class="mb- block">{{ $itemallowance->allowance->allowance_name }} -
                                        {{ number_format($itemallowance->allowance->allowance_amount) }}</span>
                                @endforeach
                            </div>
                            <div>
                                <h6 class="text-center font-semibold mb-2">DEDUCTION</h6>
                                <span class="font-semibold">MANDATORY</span>
                                @foreach ($mandatoryDeductions as $mandatoryDeduction)
                                    <span class="mb- block">{{ $mandatoryDeduction->deduction->deduction_name }} -
                                        {{ number_format($mandatoryDeduction->deduction->deduction_amount) }}</span>
                                @endforeach
                                <span class="mt-3 font-semibold">NON-MANDATORY</span>
                                @foreach ($nonmandatoryDeductions as $nonmandatoryDeduction)
                                    <span class="mb- block">{{ $nonmandatoryDeduction->deduction->deduction_name }} -
                                        {{ number_format($nonmandatoryDeduction->deduction->deduction_amount) }}</span>
                                @endforeach
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                            <div>
                                <h6 class="mt-3 font-semibold">Total Amount Earned:
                                    {{ number_format($totalAmountEarned) }}
                                </h6>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <h6 class="mt-3 font-semibold">Total Deduction:
                                        {{ number_format($totalDeduction) }}
                                    </h6>
                                </div>
                                <div>
                                    <h6 class="mt-3 font-semibold">NET PAY: {{ number_format($netpay) }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-span-3">
                        <div class="text-center mb-2">
                            <h6 class="text-xl font-semibold">MUNICIPALITY OF CALAUAN</h6>
                            <h6 class="font-semibold">RECEIPT {{ $employee->emp_no }}</h6>
                            <span> &nbsp;</span>
                        </div>
                        <div class="contents">
                            <h6>Received: </h6>
                            <h6 class="mb-3 text-center">NET PAY ₱ {{ number_format($netpay) }}</h6>
                            <h6>For Period:</h6>
                            <h6 class="mb-4 text-center">{{ $filter['from'] }}-{{ $filter['to'] }}</h6>
                            <h6 class="mb-5">Received By: </h6>
                            <h6 class="px-3 border-bottom-2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h6>
                            <h6 class="mb-3 text-center">(Employee Name) </h6>
                            <h6 class="px-3 border-bottom-2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h6>
                            <h6 class="text-center">DATE </h6>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
    <!-- Include HTML2PDF library -->
    <script src="{{ asset('assets/html2pdf/html2pdf.main.js') }}"></script>

    <!-- Define the generatePDF function -->
    <script type="text/javascript">
        function generatePDF() {
            var element = document.getElementById('canvas');
            var opt = {
                margin: .25,
                filename: 'Income.pdf',
                image: {
                    type: 'jpeg',
                    quality: 0.98
                },
                html2canvas: {
                    scale: 2
                },
                jsPDF: {
                    unit: 'in',
                    format: 'letter',
                    orientation: 'portrait'
                }
            };

            // New Promise-based usage:
            html2pdf().set(opt).from(element).save();

            // Redirect to a page after generating PDF (uncomment the next line)
            // window.location.href = "{{ route('payslips-index.index') }}";
        };

        // Attach the generatePDF function to the button click event
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('generateButton').addEventListener('click', generatePDF);
        });
    </script>

</x-app-layout>
