<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ $employee->full_name }} - {{ $employee->data->category->category_name }}
            </h2>

        </div>
    </x-slot>
    <div class="container mx-auto">
        <div class="flex items-center justify-center my-5">
            <div class="flex flex-col " style="width: 200px">
                <button type="button"
                    class="text-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-xs px-5 py-2.5 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"
                    onclick="generatePDF('{{ $employee->full_name }} - DTR')">
                    Download
                </button>
                <a href="{{ route('employees.index') }}"
                    class="text-center text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-xs px-5 py-2.5 mb-2 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700">
                    Back to Employee List
                </a>
            </div>
        </div>
        @livewire('employee.dtr.create', ['employee' => $employee])

    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"
        integrity="sha512-YcsIPGdhPK4P/uRW6/sruonlYj+Q7UHWeKfTAkBW+g83NKM+jMJFJ4iAPfSnVp7BKD4dKMHmVSvICUbE/V1sSw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        function generatePDF(filename) {
            console.log(filename);
            var element = document.getElementById('element-to-print');
            var opt = {
                margin: .2,
                filename: filename + '.pdf',
                image: {
                    type: 'jpeg',
                    quality: 0.98
                },
                html2canvas: {
                    scale: 2
                },
                jsPDF: {
                    unit: 'in',
                    format: [15, 9], // Custom format for long paper (14" x 8.5")
                    orientation: 'portrait'
                }
            };

            // New Promise-based usage:
            html2pdf().set(opt).from(element).save();
        }
    </script>
</x-app-layout>

