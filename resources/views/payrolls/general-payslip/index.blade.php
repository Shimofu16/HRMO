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

        table.table-bordered thead>tr.btlr-2 th {
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

        .border-t {
            border-top: 1px solid #1a1a1a !important;
        }

        /* .px-30{
            padding: 0 30px;
        } */
    </style>
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="overflow-auto font-sans antialiased">
    <livewire:payroll.general :filename="$filename" :dateTitle="$dateTitle" :payroll="$payroll" :from="$from" :to="$to"
        :department="$department" :loans="$loans" :deductions="$deductions" :signatures="$signatures" :dbemployees="$employees" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"
        integrity="sha512-YcsIPGdhPK4P/uRW6/sruonlYj+Q7UHWeKfTAkBW+g83NKM+jMJFJ4iAPfSnVp7BKD4dKMHmVSvICUbE/V1sSw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        function generatePDF(filename) {
            console.log(filename);
            var element = document.getElementById('element-to-print');
            var opt = {
                margin: .1,
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
                    format: [30, 8.5], // Custom format for long paper (14" x 8.5")
                    orientation: 'landscape'
                }
            };

            // New Promise-based usage:
            html2pdf().set(opt).from(element).save();
        }
    </script>
</body>

</html>
