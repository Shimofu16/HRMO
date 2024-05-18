<nav x-data="{ open: false }" class="bg-purple-700 border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="px-4 mx-auto max-w-9xl sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="flex items-center shrink-0">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block w-auto text-gray-800 fill-current h-9" />
                    </a>
                </div>
            </div>
            <!-- Navigation Links -->
            <ul class="space-x-8 flex p-4 items-center">
                <li>
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                </li>
                <x-nav-link :href="route('attendances.index')" :active="request()->routeIs('attendances.index')">
                    {{ __('Attendance') }}
                </x-nav-link>
                {{-- <li class="relative group">
                    <div id="suppliers-dropdown"
                        class="hidden group-hover:block  mt-1 max-h-64 w-100 overflow-auto absolute">
                        <div class="z-10 bg-white divide-y divide-gray-100 rounded-lg shadow w-44">
                            <ul class="py-2 text-sm text-gray-900" aria-labelledby="dropdownLargeButton">
                                <li>
                                    <a href="{{ route('attendances-history.index') }}"
                                        class="block px-4 py-2 hover:bg-gray-300 ">History</a>
                                </li>
                                <li>
                                    <a href="{{ route('seminars.index') }}"
                                        class="block px-4 py-2 hover:bg-gray-300 ">Travel Order
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('leave-requests.index', ['status' => 'pending']) }}"
                                        class="block px-4 py-2 hover:bg-gray-300 ">Leave Requests
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </li> --}}
                <li class="relative group">
                    <x-nav-link :href="route('employees.index')" :active="request()->routeIs('employees.index')">
                        {{ __('Employees') }}
                    </x-nav-link>
                    {{-- <div id="suppliers-dropdown"
                        class="hidden group-hover:block  mt-1 max-h-64 w-100 overflow-auto absolute ">
                        <div class="z-10 bg-white divide-y divide-gray-100 rounded-lg shadow w-44">
                            <ul class="py-2 text-sm text-gray-900" aria-labelledby="dropdownLargeButton">
                                <li>
                                  <a href="#" class="block px-4 py-2 hover:bg-gray-300 ">Dashboard</a>
                                </li>
                                <li>
                                  <a href="#" class="block px-4 py-2 hover:bg-gray-300 ">Settings</a>
                                </li>
                                <li>
                                  <a href="#" class="block px-4 py-2 hover:bg-gray-300 ">Earnings</a>
                                </li>
                              </ul>
                        </div>
                    </div> --}}
                </li>
                <li>
                    <x-nav-link :href="route('payrolls.index')" :active="request()->routeIs('payrolls.index')">
                        {{ __('Payroll') }}
                    </x-nav-link>
                </li>
                <li>
                    <x-nav-link :href="route('departments.index')" :active="request()->routeIs('departments.index')">
                        {{ __('Settings') }}
                    </x-nav-link>
                </li>
            </ul>

            <!-- Settings Dropdown -->
            <div class=" sm:flex sm:items-center sm:ml-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center px-3 py-2 text-sm font-medium leading-4 text-white transition duration-150 ease-in-out bg-purple-700 border border-transparent rounded-md hover:text-gray-300 focus:outline-none">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ml-1">
                                <svg class="w-4 h-4 fill-current" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>
                        <x-dropdown-link :href="route('activity-logs.index')">
                            {{ __('Activity Logs') }}
                        </x-dropdown-link>
                        <x-dropdown-link :href="route('password-code.index')">
                            {{ __('Password') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="flex items-center -mr-2 sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 text-gray-400 transition duration-150 ease-in-out rounded-md hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500">
                    <svg class="w-6 h-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="text-base font-medium text-gray-800">{{ Auth::user()->name }}</div>
                <div class="text-sm font-medium text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
