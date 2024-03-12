<x-app-layout>

    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Add Employee
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="mt-5 md:mt-0 md:col-span-2">
                <livewire:employee.create />
            </div>
        </div>
    </div>
    @push('scripts')

        {{-- <script src="{{ asset('assets/select2/css/select2.min.css') }}"></script>
    <script>

        document.getElementById('sgrade_id').addEventListener('change', function() {
            var sgrade_id = this.value;
            var select = document.getElementById('salary_grade_step_id');


            if (sgrade_id) {
                // Send an AJAX request to fetch allowances based on the selected category
                var xhr = new XMLHttpRequest();
                xhr.open('GET', '/getSteps?sgrade_id=' + sgrade_id, true);

                xhr.onload = function() {
                    if (xhr.status >= 200 && xhr.status < 400) {
                        // Parse the JSON response
                        var steps = JSON.parse(xhr.responseText);

                        // Populate the allowance container with select
                        select.innerHTML = '';
                        select.innerHTML += '<option value="" selected>--Please select here--</option>';
                        steps.forEach(function(step) {
                            select.innerHTML += '<option value="' + step.id + '">' + step.step +
                                '</option>';
                            // console.log(step.id);
                        });
                    }
                };

                xhr.send();
            }
        });
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
                            checkbox.classList.add('mr-2');

                            var label = document.createElement('label');
                            label.htmlFor = 'allowance_' + allowance.id;
                            label.classList.add('me-2');
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
        document.getElementById('loan_id').addEventListener('change', function() {
            var loanId = this.value;
            var loanAmount = document.getElementById('amount');
            if (loanId) {
                var xhr = new XMLHttpRequest();
                xhr.open('GET', '/getLoan?loan_id=' + loanId, true);
                xhr.onload = function() {
                    if (xhr.status >= 200 && xhr.status < 400) {
                        var amount = xhr.responseText;
                        loanAmount.value = amount;
                    }
                };

                xhr.send();
            }
        });
         // Trigger the change event if a default value is present
         var defaultSalaryGradeId = document.getElementById('sgrade_id').value;
        if (defaultSalaryGradeId) {
            document.getElementById('sgrade_id').dispatchEvent(new Event('change'));
        }
    </script> --}}
    @endpush
</x-app-layout>
