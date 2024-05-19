<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- <link rel="stylesheet" href="{{ asset('assets/bootstrap/bootstrap.min.css') }}"> --}}
    {{-- <link rel="stylesheet" href="./assets/bootstrap/bootstrap.min.css" type="text/css" /> --}}
    <style>
        table.table-bordered,
        table.table-bordered tr,
        table.table-bordered thead th,
        table.table-bordered tbody td {
            border-color: rgb(31 41 55 / 1)
        }
        table.table-bordered thead > tr.btlr-2 th{
            border-top: 2px;
            border-left: 2px;
            border-right: 2px;
            border-color: rgb(31 41 55 / 1)
        }

        td,
        tr {
            /* padding: 0;
            margin: 0; */
            height: auto;
        }

        .page-break {
            page-break-before: always;
        }

        .border-2 {
            border-width: 2px;
            border-color: rgb(31 41 55 / 1)
        }
        .border-top-2 {
            border-top-width: 2px;
            border-color: rgb(31 41 55 / 1)
        }
        .border-bottom-2 {
            border-bottom-width: 2px;
            border-color: rgb(31 41 55 / 1)
        }
        .border-left-2 {
            border-left-width: 2px;
            border-color: rgb(31 41 55 / 1)
        }
        .border-right-2 {
            border-right-width: 2px;
            border-color: rgb(31 41 55 / 1)
        }
        .border-x-2 {
            border-left-width: 2px;
            border-right-width: 2px;
            border-color: rgb(31 41 55 / 1)
        }
        .border-y-2 {
            border-top-width: 2px;
            border-bottom-width: 2px;
            border-color: rgb(31 41 55 / 1)
        }
        /* .px-30{
            padding: 0 30px;
        } */
    </style>
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">

    <div class="container mx-auto">
        <div class="flex items-center justify-center my-5">
            <div class="flex flex-col " style="width: 200px">
                <button type="button"
                    class="text-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-xs px-5 py-2.5 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"
                    onclick="generatePDF('{{ $filename }}')">
                    Download
                </button>
                <a href="{{ route('payrolls.index') }}"
                    class="text-center text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-xs px-5 py-2.5 mb-2 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700">
                    Back to Payroll
                </a>
            </div>
        </div>
        <div id="element-to-print" class="">
            <div class="border-2 rounded">
                <div class="header flex justify-between items-center">
                    <div></div>
                    <div>
                        <h1 class="text-center text-xl font-semibold  mb-2">General Payroll</h1>
                        <h3 class="text-center text-md font-semibold mb-0">Municipal of CALAUAN</h3>
                        <h5 class="text-center font-semibold mb-0">Province of LAGUNA</h5>
                        <h3 class="text-center text-md font-semibold mb-0">{{ $department->dep_name }}</h3>
                        <h5 class="text-center font-semibold mb-0">{{ $dateTitle }}</h5>
                    </div>
                    <div></div>
                </div>
                <div class="body">
                    <table class="table table-bordered" style='border-collapse:collapse; table-layout:auto; width:100%'>
                        <thead>
                            <tr style="height: 20px;" class="border-top-2">
                                <th>
                                    
                                </th>
                                <th>

                                </th>
                                <th>

                                </th>
                            </tr>
                            <tr style="height: 20px;" class="btlr-2">
                                <th>No.</th>
                                <th class="py-5 px-30">
                                    <h1 class="text-center text-md">Name</h1>
                                </th>
                                <th class="p-3">
                                    <h1 class="text-center text-md">Position</h1>
                                </th>
                                <th class="p-3">
                                    <h1 class="text-center text-md">Position</h1>
                                </th>
                                <th class="p-3">
                                    <h1 class="text-center text-md">Position</h1>
                                </th>
                                <th class="p-3">
                                    <h1 class="text-center text-md">Position</h1>
                                </th>
                                <th class="p-3">
                                    <h1 class="text-center text-md">Position</h1>
                                </th>
                            </tr>
                            <tr style="height: 20px;" class="btlr-2">
                                <th>

                                </th>
                                <th>

                                </th>
                                <th>

                                </th>
                            </tr>
                        </thead>
                    </table>
                    <tbody>
                        @foreach ($employees as $employee)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $employee->full_name }}</td>
                            </tr>
                            {{-- @dd($employee) --}}
                            
                        @endforeach
                    </tbody>

                </div>
            </div>

        </div>
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
                    unit: 'in', // Maintain inches for compatibility
                    format: [14, 8.5], // Custom format for long paper (14" x 8.5")
                    orientation: 'landscape'
                }
            };

            // New Promise-based usage:
            html2pdf().set(opt).from(element).save();
        }
    </script>
</body>

</html>
