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
        <main class="px-5">
            {{ $slot }}
        </main>
    </div>
</body>
@include('sweetalert::alert')
<script src="{{ asset('assets/apexcharts/apexcharts.min.js') }}"></script>
<script src="{{ asset('assets/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('assets/datatables/jquery.datatables.min.js') }}"></script>
<script>
    $('.data-table').DataTable({
        info: false,
        ordering: false,

    });
</script>
<Style>
    /* paginate_button design
    .dataTables_paginate .paginate_button {
        padding: 0.5rem 0.75rem;
        margin-left: 0.5rem;
        border-radius: 0.25rem;
        border: 1px solid #d2d6dc;
        background-color: #fff;
        color: #718096;
        cursor: pointer;
    }

    align show etries and paginate button to one row
    .dataTables_length,
    .dataTables_paginate {
        display: flex;
        align-items: center;
    } */
</Style>
@yield('scripts')

</html>
