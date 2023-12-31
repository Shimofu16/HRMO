<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Salary Grade
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mt-5 md:mt-0 md:col-span-2">
                <form action="{{ route('sgrades.store') }}" method="POST">
                    @csrf
                    <div class="shadow overflow-hidden sm:rounded-md">
                        <div class="px-4 py-5 bg-white sm:p-6">
                            <div class="grid grid-cols-6 gap-6">
                                <div class="col-span-6 sm:col-span-2">
                                    <label for="sg_code" class="block font-medium text-gray-700">Code</label>
                                    <input type="text" name="sg_code" id="sg_code"
                                        class="block w-full mt-1 rounded" required>
                                </div>
                                <div class="col-span-6 sm:col-span-2">
                                    <label for="sg_name" class="block font-medium text-gray-700">Name</label>
                                    <input type="text" name="sg_name" id="sg_name"
                                        class="block w-full mt-1 rounded" required>
                                </div>
                            </div>
                        </div>
                        <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                            <x-primary-button class="ml-3">
                                {{ __('Create') }}
                            </x-primary-button>
                            <a href="{{ route('employees.index') }}"
                                class="text-gray-500 hover:text-gray-700 font-bold py-2 px-4 rounded">Back</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl bg-white mx-auto sm:p-6 lg:p-8 ">
            <table class="min-w-full  border data-table">
                <thead>
                    <tr>
                        <th class="border-b px-4 py-2 text-left">#</th>
                        <th class="border-b px-4 py-2 text-left">Code</th>
                        <th class="border-b px-4 py-2 text-left">Name</th>
                        <th class="border-b px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sgrades as $sgrade)
                        <tr>
                            <td class="border-b px-4 py-2">{{ $loop->iteration }}</td>
                            <td class="border-b px-4 py-2">{{ $sgrade->sg_code }}</td>
                            <td class="border-b px-4 py-2">{{ $sgrade->sg_name }}</td>
                            <td class="border-b px-4 py-2">
                                <a href="{{ route('sgrades.edit', $sgrade) }}"
                                    class="text-blue-500 hover:text-blue-700">Edit</a>
                                <a href="{{ route('salary.grade.show', $sgrade->id) }}"
                                    class="text-teal-500 hover:text-teal-700">View</a>
                                <form class="inline-block" action="{{ route('sgrades.destroy', $sgrade) }}"
                                    method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>


</x-app-layout>
