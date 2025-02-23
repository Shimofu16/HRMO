<aside id="default-sidebar"
    class="fixed  left-0 z-40 w-64 h-screen transition-transform -translate-x-full sm:translate-x-0  border-r-gray-200"
    aria-label="Sidebar">
    <div class="h-full px-3 py-4 overflow-y-auto bg-gray-50">
        <ul class="space-y-2 font-medium pb-4">
            <li>
                <a href="{{ route('signatures.index') }}"
                    class="flex items-center p-2 text-gray-900 rounded-lg group {{ request()->routeIs('signatures.index') ? 'text-white bg-purple-700' : 'hover:bg-gray-100' }}">

                    <!-- Heroicon for Signature (Pencil Icon) -->
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        class="w-5 h-5 transition duration-75 {{ request()->routeIs('signatures.index') ? 'text-white' : 'text-gray-500 group-hover:text-gray-900' }}"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M16.862 3.487c.895-.895 2.395-.26 2.395 1.005V5.52a1.5 1.5 0 01-.44 1.06l-1.41 1.41m-2.121 2.121L6.45 19.291a1.5 1.5 0 01-.796.448l-2.25.451a.75.75 0 01-.883-.883l.451-2.25a1.5 1.5 0 01.448-.796l8.586-8.586a1.5 1.5 0 011.06-.44h1.027c1.265 0 1.9 1.5 1.005 2.395z" />
                    </svg>

                    <span class="ms-3">Signatures</span>
                </a>
            </li>

            <li>
                <a href="{{ route('departments.index') }}"
                    class="flex items-center p-2 text-gray-900 rounded-lg   group {{ request()->routeIs('departments.index') ? 'text-white bg-purple-700 ' : ' hover:bg-gray-100' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                        class="w-5 h-5 text-gray-500 transition duration-75   {{ request()->routeIs('departments.index') ? 'text-white' : 'group-hover:text-gray-900' }}">
                        <path fill-rule="evenodd"
                            d="M3 2.25a.75.75 0 0 0 0 1.5v16.5h-.75a.75.75 0 0 0 0 1.5H15v-18a.75.75 0 0 0 0-1.5H3ZM6.75 19.5v-2.25a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 .75.75v2.25a.75.75 0 0 1-.75.75h-3a.75.75 0 0 1-.75-.75ZM6 6.75A.75.75 0 0 1 6.75 6h.75a.75.75 0 0 1 0 1.5h-.75A.75.75 0 0 1 6 6.75ZM6.75 9a.75.75 0 0 0 0 1.5h.75a.75.75 0 0 0 0-1.5h-.75ZM6 12.75a.75.75 0 0 1 .75-.75h.75a.75.75 0 0 1 0 1.5h-.75a.75.75 0 0 1-.75-.75ZM10.5 6a.75.75 0 0 0 0 1.5h.75a.75.75 0 0 0 0-1.5h-.75Zm-.75 3.75A.75.75 0 0 1 10.5 9h.75a.75.75 0 0 1 0 1.5h-.75a.75.75 0 0 1-.75-.75ZM10.5 12a.75.75 0 0 0 0 1.5h.75a.75.75 0 0 0 0-1.5h-.75ZM16.5 6.75v15h5.25a.75.75 0 0 0 0-1.5H21v-12a.75.75 0 0 0 0-1.5h-4.5Zm1.5 4.5a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75h-.008a.75.75 0 0 1-.75-.75v-.008Zm.75 2.25a.75.75 0 0 0-.75.75v.008c0 .414.336.75.75.75h.008a.75.75 0 0 0 .75-.75v-.008a.75.75 0 0 0-.75-.75h-.008ZM18 17.25a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75h-.008a.75.75 0 0 1-.75-.75v-.008Z"
                            clip-rule="evenodd" />
                    </svg>

                    <span class="ms-3">Department</span>
                </a>
            </li>
            <li>
                <a href="{{ route('designations.index') }}"
                    class="flex items-center p-2 text-gray-900 rounded-lg   group {{ request()->routeIs('designations.index') ? 'text-white bg-purple-700 ' : ' hover:bg-gray-100' }}">
                    <svg class="w-5 h-5 text-gray-500 transition duration-75   {{ request()->routeIs('designations.index') ? 'text-white' : 'group-hover:text-gray-900' }}"
                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 21">
                        <path
                            d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z" />
                        <path
                            d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z" />
                    </svg>
                    <span class="ms-3">Position Title</span>
                </a>
            </li>
            <li>
                <a href="{{ route('categories.index') }}"
                    class="flex items-center p-2 text-gray-900 rounded-lg   group {{ request()->routeIs('categories.index') ? 'text-white bg-purple-700 ' : ' hover:bg-gray-100' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                        class="w-5 h-5 text-gray-500 transition duration-75   {{ request()->routeIs('categories.index') ? 'text-white' : 'group-hover:text-gray-900' }}"
                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M5.25 2.25a3 3 0 0 0-3 3v4.318a3 3 0 0 0 .879 2.121l9.58 9.581c.92.92 2.39 1.186 3.548.428a18.849 18.849 0 0 0 5.441-5.44c.758-1.16.492-2.629-.428-3.548l-9.58-9.581a3 3 0 0 0-2.122-.879H5.25ZM6.375 7.5a1.125 1.125 0 1 0 0-2.25 1.125 1.125 0 0 0 0 2.25Z"
                            clip-rule="evenodd" />
                    </svg>
                    <span class="ms-3">Type of Employment</span>
                </a>
            </li>
            {{-- <li>
             <a href="#" class="flex items-center p-2 text-gray-900 rounded-lg  group">
                <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                   <path d="m17.418 3.623-.018-.008a6.713 6.713 0 0 0-2.4-.569V2h1a1 1 0 1 0 0-2h-2a1 1 0 0 0-1 1v2H9.89A6.977 6.977 0 0 1 12 8v5h-2V8A5 5 0 1 0 0 8v6a1 1 0 0 0 1 1h8v4a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1v-4h6a1 1 0 0 0 1-1V8a5 5 0 0 0-2.582-4.377ZM6 12H4a1 1 0 0 1 0-2h2a1 1 0 0 1 0 2Z"/>
                </svg>
                <span class="flex-1 ms-3 whitespace-nowrap">Inbox</span>
                <span class="inline-flex items-center justify-center w-3 h-3 p-3 ms-3 text-sm font-medium text-blue-800 bg-blue-100 rounded-full dark:bg-blue-900 dark:text-blue-300">3</span>
             </a>
          </li> --}}


        </ul>
        <ul class="space-y-2 font-medium pt-4 border-t border-gray-200">
            <li>
                <a href="{{ route('allowances.index') }}"
                    class="flex items-center p-2 text-gray-900 rounded-lg   group {{ request()->routeIs('allowances.index') ? 'text-white bg-purple-700 ' : ' hover:bg-gray-100' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                        class="w-5 h-5 text-gray-500 transition duration-75   {{ request()->routeIs('allowances.index') ? 'text-white' : 'group-hover:text-gray-900' }}">
                        <path d="M12 7.5a2.25 2.25 0 1 0 0 4.5 2.25 2.25 0 0 0 0-4.5Z" />
                        <path fill-rule="evenodd"
                            d="M1.5 4.875C1.5 3.839 2.34 3 3.375 3h17.25c1.035 0 1.875.84 1.875 1.875v9.75c0 1.036-.84 1.875-1.875 1.875H3.375A1.875 1.875 0 0 1 1.5 14.625v-9.75ZM8.25 9.75a3.75 3.75 0 1 1 7.5 0 3.75 3.75 0 0 1-7.5 0ZM18.75 9a.75.75 0 0 0-.75.75v.008c0 .414.336.75.75.75h.008a.75.75 0 0 0 .75-.75V9.75a.75.75 0 0 0-.75-.75h-.008ZM4.5 9.75A.75.75 0 0 1 5.25 9h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75H5.25a.75.75 0 0 1-.75-.75V9.75Z"
                            clip-rule="evenodd" />
                        <path
                            d="M2.25 18a.75.75 0 0 0 0 1.5c5.4 0 10.63.722 15.6 2.075 1.19.324 2.4-.558 2.4-1.82V18.75a.75.75 0 0 0-.75-.75H2.25Z" />
                    </svg>

                    <span class="ms-3">Allowance</span>
                </a>
            </li>
            <li>
                <a href="{{ route('hazards.index') }}"
                    class="flex items-center p-2 text-gray-900 rounded-lg   group {{ request()->routeIs('hazards.index') ? 'text-white bg-purple-700 ' : ' hover:bg-gray-100' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                        class="w-5 h-5 text-gray-500 transition duration-75   {{ request()->routeIs('hazards.index') ? 'text-white' : 'group-hover:text-gray-900' }}">
                        <path d="M12 7.5a2.25 2.25 0 1 0 0 4.5 2.25 2.25 0 0 0 0-4.5Z" />
                        <path fill-rule="evenodd"
                            d="M1.5 4.875C1.5 3.839 2.34 3 3.375 3h17.25c1.035 0 1.875.84 1.875 1.875v9.75c0 1.036-.84 1.875-1.875 1.875H3.375A1.875 1.875 0 0 1 1.5 14.625v-9.75ZM8.25 9.75a3.75 3.75 0 1 1 7.5 0 3.75 3.75 0 0 1-7.5 0ZM18.75 9a.75.75 0 0 0-.75.75v.008c0 .414.336.75.75.75h.008a.75.75 0 0 0 .75-.75V9.75a.75.75 0 0 0-.75-.75h-.008ZM4.5 9.75A.75.75 0 0 1 5.25 9h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75H5.25a.75.75 0 0 1-.75-.75V9.75Z"
                            clip-rule="evenodd" />
                        <path
                            d="M2.25 18a.75.75 0 0 0 0 1.5c5.4 0 10.63.722 15.6 2.075 1.19.324 2.4-.558 2.4-1.82V18.75a.75.75 0 0 0-.75-.75H2.25Z" />
                    </svg>

                    <span class="ms-3">Hazard</span>
                </a>
            </li>
            <li>
                <a href="{{ route('ratas.index') }}"
                    class="flex items-center p-2 text-gray-900 rounded-lg   group {{ request()->routeIs('ratas.index') ? 'text-white bg-purple-700 ' : ' hover:bg-gray-100' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                        class="w-5 h-5 text-gray-500 transition duration-75   {{ request()->routeIs('ratas.index') ? 'text-white' : 'group-hover:text-gray-900' }}">
                        <path d="M12 7.5a2.25 2.25 0 1 0 0 4.5 2.25 2.25 0 0 0 0-4.5Z" />
                        <path fill-rule="evenodd"
                            d="M1.5 4.875C1.5 3.839 2.34 3 3.375 3h17.25c1.035 0 1.875.84 1.875 1.875v9.75c0 1.036-.84 1.875-1.875 1.875H3.375A1.875 1.875 0 0 1 1.5 14.625v-9.75ZM8.25 9.75a3.75 3.75 0 1 1 7.5 0 3.75 3.75 0 0 1-7.5 0ZM18.75 9a.75.75 0 0 0-.75.75v.008c0 .414.336.75.75.75h.008a.75.75 0 0 0 .75-.75V9.75a.75.75 0 0 0-.75-.75h-.008ZM4.5 9.75A.75.75 0 0 1 5.25 9h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75H5.25a.75.75 0 0 1-.75-.75V9.75Z"
                            clip-rule="evenodd" />
                        <path
                            d="M2.25 18a.75.75 0 0 0 0 1.5c5.4 0 10.63.722 15.6 2.075 1.19.324 2.4-.558 2.4-1.82V18.75a.75.75 0 0 0-.75-.75H2.25Z" />
                    </svg>

                    <span class="ms-3">Rata</span>
                </a>
            </li>
            <li>
                <a href="{{ route('deductions.index') }}"
                    class="flex items-center p-2 text-gray-900 rounded-lg   group {{ request()->routeIs('deductions.index') ? 'text-white bg-purple-700 ' : ' hover:bg-gray-100' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                        class="w-5 h-5 text-gray-500 transition duration-75   {{ request()->routeIs('deductions.index') ? 'text-white' : 'group-hover:text-gray-900' }}">
                        <path fill-rule="evenodd"
                            d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25Zm3 10.5a.75.75 0 0 0 0-1.5H9a.75.75 0 0 0 0 1.5h6Z"
                            clip-rule="evenodd" />
                    </svg>

                    <span class="ms-3">Contribution</span>
                </a>
            </li>
            <li>
                <a href="{{ route('loans.index') }}"
                    class="flex items-center p-2 text-gray-900 rounded-lg   group {{ request()->routeIs('loans.index') ? 'text-white bg-purple-700 ' : ' hover:bg-gray-100' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                        class="w-5 h-5 text-gray-500 transition duration-75   {{ request()->routeIs('loans.index') ? 'text-white' : 'group-hover:text-gray-900' }}">
                        <path d="M4.5 3.75a3 3 0 0 0-3 3v.75h21v-.75a3 3 0 0 0-3-3h-15Z" />
                        <path fill-rule="evenodd"
                            d="M22.5 9.75h-21v7.5a3 3 0 0 0 3 3h15a3 3 0 0 0 3-3v-7.5Zm-18 3.75a.75.75 0 0 1 .75-.75h6a.75.75 0 0 1 0 1.5h-6a.75.75 0 0 1-.75-.75Zm.75 2.25a.75.75 0 0 0 0 1.5h3a.75.75 0 0 0 0-1.5h-3Z"
                            clip-rule="evenodd" />
                    </svg>

                    <span class="ms-3">Loan</span>
                </a>
            </li>
            <li>
    <a href="{{ route('with-holding-taxes.index') }}"
        class="flex items-center p-2 text-gray-900 rounded-lg group {{ request()->routeIs('with-holding-taxes.index') ? 'text-white bg-purple-700' : 'hover:bg-gray-100' }}">

        <!-- Heroicon for Document Icon -->
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
            class="w-5 h-5 transition duration-75 {{ request()->routeIs('with-holding-taxes.index') ? 'text-white' : 'text-gray-500 group-hover:text-gray-900' }}">
            <path fill-rule="evenodd" d="M12 2c-.83 0-1.5.67-1.5 1.5v1H7.5C6.67 4.5 6 5.17 6 6v12c0 .83.67 1.5 1.5 1.5h9c.83 0 1.5-.67 1.5-1.5V8.5l-6-6H12zm1.5 1.5l6 6h-5.5a1 1 0 0 1-1-1V3.5zM7 7h10v10H7V7z" clip-rule="evenodd" />
        </svg>

        <span class="ml-3">With Holding Taxes</span>
    </a>
</li>

<li>
    <a href="{{ route('levels.index') }}"
        class="flex items-center p-2 text-gray-900 rounded-lg group {{ request()->routeIs('levels.index') ? 'text-white bg-purple-700' : 'hover:bg-gray-100' }}">

        <!-- Heroicon for Bars Icon -->
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
            class="w-5 h-5 transition duration-75 {{ request()->routeIs('levels.index') ? 'text-white' : 'text-gray-500 group-hover:text-gray-900' }}">
            <path fill-rule="evenodd" d="M4 6h16a1 1 0 1 1 0 2H4a1 1 0 1 1 0-2zm0 5h16a1 1 0 1 1 0 2H4a1 1 0 1 1 0-2zm0 5h16a1 1 0 1 1 0 2H4a1 1 0 1 1 0-2z" clip-rule="evenodd"/>
        </svg>

        <span class="ml-3">Classification</span>
    </a>
</li>

<li>
    <a href="{{ route('holidays.index') }}"
        class="flex items-center p-2 text-gray-900 rounded-lg group {{ request()->routeIs('holidays.index') ? 'text-white bg-purple-700' : 'hover:bg-gray-100' }}">

        <!-- Calendar Icon -->
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
            class="w-5 h-5 transition duration-75 {{ request()->routeIs('holidays.index') ? 'text-white' : 'text-gray-500 group-hover:text-gray-900' }}">
            <path d="M3 3h18a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2zm0 2v14h18V5H3z" />
            <path d="M7 7h2v2H7V7zm4 0h2v2h-2V7zm4 0h2v2h-2V7z" />
        </svg>

        <span class="ml-3">Holiday</span>
    </a>
</li>

<li>
    <a href="{{ route('salary-grades.index') }}"
        class="flex items-center p-2 text-gray-900 rounded-lg group {{ request()->routeIs('salary-grades.index') ? 'text-white bg-purple-700' : 'hover:bg-gray-100' }}">

        <!-- Dollar Icon -->
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
            class="w-5 h-5 transition duration-75 {{ request()->routeIs('salary-grades.index') ? 'text-white' : 'text-gray-500 group-hover:text-gray-900' }}">
            <path fill-rule="evenodd"
                d="M12 1.5a.75.75 0 0 1 .75.75V3h1.5a.75.75 0 0 1 0 1.5h-1.56a4.8 4.8 0 0 1 .878 2.04c1.002.159 2.005.578 2.76 1.304C17.797 9.643 18 10.778 18 12c0 1.222-.203 2.357-.672 3.156-.755.726-1.758 1.145-2.76 1.304a4.8 4.8 0 0 1-.878 2.04H14.25a.75.75 0 0 1 0 1.5h-1.5v.75a.75.75 0 0 1-1.5 0v-.75h-1.5a.75.75 0 0 1 0-1.5h1.56a4.8 4.8 0 0 1-.878-2.04c-1.002-.159-2.005-.578-2.76-1.304C6.203 14.357 6 13.222 6 12c0-1.222.203-2.357.672-3.156.755-.726 1.758-1.145 2.76-1.304a4.8 4.8 0 0 1 .878-2.04H9.75A.75.75 0 0 1 9.75 3h1.5V2.25A.75.75 0 0 1 12 1.5Zm-2.79 12.117a3.29 3.29 0 0 0 1.788.743v-4.62c-.654.144-1.276.405-1.788.857-.38.352-.663.879-.663 1.62 0 .742.283 1.27.663 1.62Zm3.58-5.535v4.62c.654-.144 1.276-.405 1.788-.857.38-.352.663-.879.663-1.62 0-.742-.283-1.27-.663-1.62a3.29 3.29 0 0 0-1.788-.743Z"
                clip-rule="evenodd" />
        </svg>

        <span class="ml-3">Salary Grade</span>
    </a>
</li>




        </ul>
        <ul class="space-y-2 font-medium pt-4 border-t border-gray-200">
            <li>
                <a href="{{ route('backup.index') }}"
                    class="flex items-center p-2 text-gray-900 rounded-lg   group {{ request()->routeIs('backup.index') ? 'text-white bg-purple-700 ' : ' hover:bg-gray-100' }}">

                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                        class="w-5 h-5 text-gray-500 transition duration-75   {{ request()->routeIs('backup.index') ? 'text-white' : 'group-hover:text-gray-900' }}">
                        <path
                            d="M21 6.375c0 2.692-4.03 4.875-9 4.875S3 9.067 3 6.375 7.03 1.5 12 1.5s9 2.183 9 4.875Z" />
                        <path
                            d="M12 12.75c2.685 0 5.19-.586 7.078-1.609a8.283 8.283 0 0 0 1.897-1.384c.016.121.025.244.025.368C21 12.817 16.97 15 12 15s-9-2.183-9-4.875c0-.124.009-.247.025-.368a8.285 8.285 0 0 0 1.897 1.384C6.809 12.164 9.315 12.75 12 12.75Z" />
                        <path
                            d="M12 16.5c2.685 0 5.19-.586 7.078-1.609a8.282 8.282 0 0 0 1.897-1.384c.016.121.025.244.025.368 0 2.692-4.03 4.875-9 4.875s-9-2.183-9-4.875c0-.124.009-.247.025-.368a8.284 8.284 0 0 0 1.897 1.384C6.809 15.914 9.315 16.5 12 16.5Z" />
                        <path
                            d="M12 20.25c2.685 0 5.19-.586 7.078-1.609a8.282 8.282 0 0 0 1.897-1.384c.016.121.025.244.025.368 0 2.692-4.03 4.875-9 4.875s-9-2.183-9-4.875c0-.124.009-.247.025-.368a8.284 8.284 0 0 0 1.897 1.384C6.809 19.664 9.315 20.25 12 20.25Z" />
                    </svg>

                    <span class="ms-3">Backup</span>
                </a>
            </li>
        </ul>
    </div>
</aside>
