@extends('settings.index')
@section('header')
    Employees - W/ Holding Taxes
@endsection
@section('contents')
    <div class="bg-white  mt-5 p-5 shadow rounded-md">
        <div class="flex items-center justify-end mb-3">
            
        </div>
        <table class="min-w-full border data-table">
            <thead>
                <tr>
                    <th class="border-b px-4 py-2 text-left">#</th>
                    <th class="border-b px-4 py-2 text-left">Employee</th>
                    {{-- <th class="border-b px-4 py-2 text-left">Monthly</th> --}}
                    <th class="border-b px-4 py-2 text-left">Annual Taxable Compensation</th>
                    <th class="border-b px-4 py-2 text-left">Annual Tax Due</th>
                    <th class="border-b px-4 py-2 text-left">Monthly Tax</th>
                    <th class="border-b px-4 py-2 text-left">Tax Per Cut off (15days)</th>
                   
                </tr>
            </thead>
            <tbody>
                @foreach ($employees as $employee)
                    @php
                        $annualTaxableCompensation =  computeAnnualTaxableCompensation($employee->data->monthly_salary, $employee->computeDeduction());
                        $annualTaxDue =  computeTaxableCompensation($annualTaxableCompensation);
                        $mothlyTax =  $annualTaxDue / 12;
                        $taxPerCut =  $mothlyTax / 2;
                    @endphp
                    <tr>
                        <td class="border-b px-4 py-2">{{ $loop->iteration }}</td>
                        <td class="border-b px-4 py-2">{{ $employee->full_name }}</td>
                        {{-- <td class="border-b px-4 py-2">{{ number_format($employee->data->monthly_salary, 2) }}</td> --}}
                        <td class="border-b px-4 py-2">{{ number_format($annualTaxableCompensation, 2) }}</td>
                        <td class="border-b px-4 py-2">{{ number_format($annualTaxDue, 2) }}</td>
                        <td class="border-b px-4 py-2">{{ number_format($mothlyTax, 2) }}</td>
                        <td class="border-b px-4 py-2">{{ number_format($taxPerCut, 2) }}</td>
                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>
@endsection
