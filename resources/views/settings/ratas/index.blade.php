@extends('settings.index')
@section('header')
    Rata
@endsection
@section('contents')
    <div class="mx-8 mt-8 rounded-md bg-white p-5 shadow">
        <form action="{{ route('ratas.store') }}" method="POST">
            @csrf
            <div class="mb-3 grid grid-cols-9 gap-6">
                <div class="col-span-3">
                    <label for="type" class="block font-medium text-gray-700">Type</label>
                    <input type="text" name="type" id="type" class="mt-1 block w-full rounded" required>
                </div>
                <div class="col-span-3">
                    <label for="amount" class="block font-medium text-gray-700">Amount</label>
                    <input type="number" name="amount" id="amount" class="mt-1 block w-full rounded" required>
                </div>
                <div class="col-span-3">
                    <label for="ranges" class="block font-medium text-gray-700">Range</label>
                    <select name="ranges[]" id="ranges" class="form-select mt-1 block w-full rounded" multiple="multiple"
                        required>
                        <option value="1-15">1-15</option>
                        <option value="16-31">16-31</option>
                    </select>
                </div>
            </div>

            <div class="py-3 text-right sm:px-6">
                <x-primary-button class="mr-1">
                    {{ __('Create') }}
                </x-primary-button>
            </div>
        </form>
    </div>

    <div class="mt-5 rounded-md bg-white p-5 shadow">

        <table class="min-w-full border bg-white data-table">
            <thead>
                <tr>
                    <th class="border-b px-4 py-2 text-left">#</th>
                    <th class="border-b px-4 py-2 text-left">Type</th>
                    <th class="border-b px-4 py-2 text-left">Amount</th>
                    <th class="border-b px-4 py-2 text-left">Ranges</th>
                    <th class="border-b px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($rata_types as $rata_type)
                    <tr>
                        <td class="border-b px-4 py-2">{{ $loop->iteration }}</td>
                        <td class="border-b px-4 py-2">{{ $rata_type->type }}</td>
                        <td class="border-b px-4 py-2">{{ $rata_type->amount }}</td>
                        <td class="border-b px-4 py-2">
                            @if ($rata_type->ranges)
                                {{ implode(' and ', $rata_type->ranges) }}
                            @endif
                        </td>

                        <td class="border-b px-4 py-2">
                            <a href="{{ route('ratas.edit', $rata_type) }}"
                                class="text-blue-500 hover:text-blue-700">Edit</a>

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @push('styles')
        <link rel="stylesheet" href="{{ asset('assets/select2-4.1.0-rc.0/css/select2.min.css') }}">
    @endpush
    @push('scripts')
        <script src="{{ asset('assets/select2-4.1.0-rc.0/js/select2.min.js') }}"></script>
        <script>
            $(document).ready(function() {
                $('#ranges').select2();
            });
        </script>
    @endpush
@endsection
