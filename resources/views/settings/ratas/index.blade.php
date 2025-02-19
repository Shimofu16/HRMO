@extends('settings.index')
@section('header')
    Rata
@endsection
@section('contents')
    <div class="p-5 mx-8 mt-8 bg-white rounded-md shadow">
        <form action="{{ route('ratas.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-6 gap-6 mb-3">
                <div class="col-span-6 sm:col-span-2">
                    <label for="type" class="block font-medium text-gray-700">Type</label>
                    <input type="text" name="type" id="type" class="block w-full mt-1 rounded" required>
                </div>
                <div class="col-span-6 sm:col-span-2">
                    <label for="amount" class="block font-medium text-gray-700">Amount</label>
                    <input type="number" name="amount" id="amount" class="block w-full mt-1 rounded"
                        required>
                </div>
            </div>
      
            <div class="py-3 text-right sm:px-6">
                <x-primary-button class="mr-1">
                    {{ __('Create') }}
                </x-primary-button>
            </div>
        </form>
    </div>

    <div class="p-5 mt-5 bg-white rounded-md shadow">

        <table class="min-w-full bg-white border">
            <thead>
                <tr>
                    <th class="px-4 py-2 text-left border-b">#</th>
                    <th class="px-4 py-2 text-left border-b">Type</th>
                    <th class="px-4 py-2 text-left border-b">Amount</th>
                    <th class="px-4 py-2 border-b">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($rata_types as $rata_type)
                    <tr>
                        <td class="px-4 py-2 border-b">{{ $loop->iteration }}</td>
                        <td class="px-4 py-2 border-b">{{ $rata_type->type }}</td>
                        <td class="px-4 py-2 border-b">{{ $rata_type->amount }}</td>

                        <td class="px-4 py-2 border-b">
                            <a href="{{ route('ratas.edit', $rata_type) }}"
                                class="text-blue-500 hover:text-blue-700">Edit</a>

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

@endsection