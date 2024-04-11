<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('assets/apexcharts/apexcharts.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/datatables/dataTables.tailwindcss.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/jquery/jquery.dataTables.min.css') }}">

    @stack('styles')
    @livewireStyles
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        @include('layouts.navigation')

        <!-- Page Heading -->
        @if (isset($header))
            <header class="bg-white shadow">
                <div class="px-4 py-6 mx-auto max-w-8xl sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>

    </div>
</body>
@include('sweetalert::alert')
<script src="{{ asset('assets/apexcharts/apexcharts.min.js') }}"></script>
<script src="{{ asset('assets/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('assets/datatables/jquery.datatables.min.js') }}"></script>
@livewireScripts
@stack('scripts')
<script>
    $(document).ready(function() {
        const dataTableOptions = {
            info: false,
            scrollX: {!! json_encode(Route::is('salary-grades.index')) !!},
            ordering: false,
            lengthMenu: {!! json_encode(
                Route::is('attendances.index') ? [[50, 75, 100, -1], [50, 75, 100, 'All']] : [5, 10, 25, 50, 75, 100],
            ) !!},
        };

        $('.data-table').DataTable(dataTableOptions);
    });
</script>

</html>
