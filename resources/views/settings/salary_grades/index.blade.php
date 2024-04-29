@extends('settings.index')
@section('header')
    Salary Grade
@endsection
@section('contents')
    <div class="bg-white  mt-5 p-5 shadow rounded-md">
        <div class="flex items-center justify-end mb-3">
            <a href="{{ route('salary-grades.create') }}"
                class="'inline-flex items-center px-4 py-2 bg-purple-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-purple-700 focus:bg-gray-700 active:bg-purple-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                Create Salary Grade
            </a>
        </div>
        <table class="min-w-full border data-table">
            <thead>
                <tr>
                    <th class="border-b px-4 py-2 text-left">Salary Grade</th>
                    @for ($i = 0; $i < getSalaryGradesTotalSteps(); $i++)
                        <th class="border-b px-4 py-2 text-left">Step {{ $i + 1 }}</th>
                    @endfor
                    <th class="border-b px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($salary_grades as $salary_grade)
                    <tr>
                        <td class="border-b px-4 py-2">{{ $loop->iteration }}</td>
                        @foreach ($salary_grade->steps as $step)
                            <td class="border-b px-4 py-2">{{ number_format($step['amount'], 2) }}</td>
                        @endforeach
                        @if (getSalaryGradesTotalSteps() > count($salary_grade->steps))
                            @for ($i = 0; $i < getSalaryGradesTotalSteps() - count($salary_grade->steps); $i++)
                                <td class="border-b px-4 py-2">
                                    <strong>--</strong>
                                </td>
                            @endfor
                        @endif
                        <td class="border-b px-4 py-2">
                            <a href="{{ route('salary-grades.edit', ['salary_grade' => $salary_grade]) }}"
                                class="text-blue-500 hover:text-blue-700">Edit</a>
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>
@endsection
