@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-1 py-1 border-b-4 border-gray-200 text-sm font-medium leading-5 text-white focus:outline-none focus:border-gray-700 transition duration-150 ease-in-out'
            : 'inline-flex items-center px-1 py-1 border-b-4 border-transparent text-sm font-medium leading-5 text-white hover:text-gray-300 hover:border-gray-200 focus:outline-none focus:text-gray-300 focus:border-gray-200 transition duration-150 ease-in-out';
/* $classes = ($active ?? false)
            ? 'inline-flex items-center px-1 pt-1 border-b-4 border-indigo-400 text-sm font-medium leading-5 text-white focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out'
            : 'inline-flex items-center px-1 pt-1 border-b-4 border-transparent text-sm font-medium leading-5 text-white hover:text-gray-300 hover:border-gray-200 focus:outline-none focus:text-gray-300 focus:border-gray-200 transition duration-150 ease-in-out'; */
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
