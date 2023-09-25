<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Add Employee
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="mt-5 md:mt-0 md:col-span-2">
                <form action="{{ route('employees.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="overflow-hidden shadow sm:rounded-md">
                        <div class="px-4 py-5 bg-white sm:p-6">
                            <div class="grid grid-cols-6 gap-6">
                                <div class="col-span-6 sm:col-span-2">
                                    <label for="name" class="block font-medium text-gray-700">Name</label>
                                    <input type="text" name="name" id="name"
                                        class="block w-full mt-1 form-input" required>
                                </div>

                                <div class="col-span-6 sm:col-span-2">
                                    <label for="oinumber" class="block font-medium text-gray-700">Ordinance Item
                                        Number</label>
                                    <input type="text" name="oinumber" id="oinumber"
                                        class="block w-full mt-1 form-input" required>
                                </div>
                                <div class="col-span-6 sm:col-span-2">
                                    <label for="sick_leave" class="block font-medium text-gray-700">Sick Leave</label>
                                    <input type="number" step="0.01" name="sick_leave" id="sick_leave"
                                        class="block w-full mt-1 form-input" required>
                                </div>
                                <div class="col-span-6 sm:col-span-2">
                                    <label for="sgrade_id" class="block font-medium text-gray-700">Salary Grade</label>
                                    <select name="sgrade_id" id="sgrade_id" class="block w-full mt-1 form-select"
                                        required>
                                        <option value="" disabled selected>--Please select here--</option>
                                        @foreach ($sgrades as $sgrade)
                                            <option value="{{ $sgrade->id }}">{{ $sgrade->sg_code }}</option>
                                        @endforeach
                                    </select>
                                </div>


                                <div class="col-span-6 sm:col-span-2">
                                    <label for="department_id"
                                        class="block font-medium text-gray-700">Department</label>
                                    <select name="department_id" id="department_id"
                                        class="block w-full mt-1 form-select" required>
                                        <option value="" disabled selected>--Please select here--</option>
                                        @foreach ($departments as $department)
                                            <option value="{{ $department->id }}">{{ $department->dep_code }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-span-6 sm:col-span-2">
                                    <label for="designation_id"
                                        class="block font-medium text-gray-700">Designation</label>
                                    <select name="designation_id" id="designation_id"
                                        class="block w-full mt-1 form-select" required>
                                        <option value="" disabled selected>--Please select here--</option>
                                        @foreach ($designations as $designation)
                                            <option value="{{ $designation->id }}">{{ $designation->designation_code }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-span-6 sm:col-span-2">
                                    <label for="category_id" class="block font-medium text-gray-700">Category</label>
                                    <select name="category_id" id="category_id" class="block w-full mt-1 form-select"
                                        required>
                                        <option value="" selected>--Please select here--</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->category_code }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-span-6 sm:col-span-2">
                                    <label class="block font-medium text-gray-700">Allowance</label>
                                    <div id="allowanceContainer">
                                        <!-- Allowances will be loaded here -->
                                    </div>
                                </div>

                                <script>
                                    document.getElementById('category_id').addEventListener('change', function() {
                                        var categoryId = this.value;
                                        var allowanceContainer = document.getElementById('allowanceContainer');

                                        // Clear the allowance container
                                        allowanceContainer.innerHTML = '';

                                        if (categoryId) {
                                            // Send an AJAX request to fetch allowances based on the selected category
                                            var xhr = new XMLHttpRequest();
                                            xhr.open('GET', '/getAllowances?category_id=' + categoryId, true);

                                            xhr.onload = function() {
                                                if (xhr.status >= 200 && xhr.status < 400) {
                                                    // Parse the JSON response
                                                    var allowances = JSON.parse(xhr.responseText);

                                                    // Populate the allowance container with checkboxes
                                                    allowances.forEach(function(allowance) {
                                                        var checkbox = document.createElement('input');
                                                        checkbox.type = 'checkbox';
                                                        checkbox.name = 'allowance[]';
                                                        checkbox.value = allowance.id;
                                                        checkbox.id = 'allowance_' + allowance.id;

                                                        var label = document.createElement('label');
                                                        label.htmlFor = 'allowance_' + allowance.id;
                                                        label.appendChild(document.createTextNode(allowance.allowance_code));

                                                        var div = document.createElement('div');
                                                        div.classList.add('flex', 'items-center', 'mt-1');
                                                        div.appendChild(checkbox);
                                                        div.appendChild(label);

                                                        allowanceContainer.appendChild(div);
                                                    });
                                                }
                                            };

                                            xhr.send();
                                        }
                                    });
                                </script>


                                {{-- <div class="col-span-6 sm:col-span-2">
                                    <label for="deduction" class="block font-medium text-gray-700">Deduction</label>
                                    <select name="deduction" id="deduction" class="block w-full mt-1 form-select"
                                        required>
                                        <option value="" disabled selected>--Please select here--</option>
                                        @foreach ($deductions as $id => $deduction_code)
                                            <option value="{{ $deduction_code }}">{{ $deduction_code }}</option>
                                        @endforeach
                                    </select>
                                </div> --}}

                                <div class="col-span-6 sm:col-span-2">
                                    <label class="block font-medium text-gray-700">Deduction</label>
                                    <div class="flex flex-wrap -mx-2">
                                        <div class="w-full">
                                            <h2 class="text-xm">Mandatory Deductions</h2>
                                        </div>
                                        @forelse ($deductions as $deduction)
                                            @if ($deduction->deduction_type === 'Mandatory')
                                                <div class="w-1/2 px-2">
                                                    <input type="checkbox" name="deduction[]"
                                                        value="{{ $deduction->id }}" class="mr-2 form-checkbox hidden"
                                                        checked>
                                                    <input type="checkbox" 
                                                        id="deduction_{{ $deduction->id }}"
                                                        value="{{ $deduction->id }}" class="mr-2 form-checkbox"
                                                        checked disabled>
                                                    <label for="deduction_{{ $deduction->id }}"
                                                        class="text-gray-900">{{ $deduction->deduction_code }}</label>
                                                </div>
                                            @endif
                                        @empty
                                            <p>No deduction found.</p>
                                        @endforelse
                                    </div>

                                    <div class="flex flex-wrap -mx-2 mt-4">
                                        <div class="w-full">
                                            <h2 class="text-xm">Non Mandatory Deductions</h2>
                                        </div>
                                        @forelse ($deductions as $deduction)
                                            @if ($deduction->deduction_type === 'Non Mandatory')
                                                <div class="w-1/2 px-2">
                                                    <input type="checkbox" name="deduction[]"
                                                        id="deduction_{{ $deduction->id }}"
                                                        value="{{ $deduction->id }}" class="mr-2 form-checkbox">
                                                    <label for="deduction_{{ $deduction->id }}"
                                                        class="text-gray-900">{{ $deduction->deduction_code }}</label>
                                                </div>z
                                            @endif
                                        @empty
                                            <p>No deduction found.</p>
                                        @endforelse
                                    </div>


                                </div>
                            </div>
                        </div>
                        <div class="px-4 py-3 text-right bg-gray-50 sm:px-6">
                            <x-primary-button class="ml-3">
                                {{ __('Create') }}
                            </x-primary-button>
                            <a href="{{ route('employees.index') }}"
                                class="px-4 py-2 font-bold text-gray-500 rounded hover:text-gray-700">Back</a>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>

</x-app-layout>
