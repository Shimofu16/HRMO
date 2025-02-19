
    <div class="grid grid-cols-6 gap-3 mt-4 px-3">
        @if (!Request::routeIs('attendances.index'))
            <a href="{{ route('attendances.index') }}">
                <div class="bg-white px-2 py-5 rounded-md text-center">
                    <h2 class="font-semibold">
                        Attendance List
                    </h2>
                </div>
            </a>
        @endif
        @if (!Request::routeIs('attendances-history.index'))
            <a href="{{ route('attendances-history.index') }}">
                <div class="bg-white px-2 py-5 rounded-md text-center">
                    <h2 class="font-semibold">
                        Attendance History List
                    </h2>
                </div>
            </a>
        @endif
        @if (!Request::routeIs('create.attendances.manually'))
            <a href="{{ route('create.attendances.manually') }}">
                <div class="bg-white px-2 py-5 rounded-md text-center">
                    <h2 class="font-semibold">
                        Create Attendance
                    </h2>
                </div>
            </a>
        @endif
        @if (!Request::routeIs('seminars.index'))
            <a href="{{ route('seminars.index') }}">
                <div class="bg-white px-2 py-5 rounded-md text-center">
                    <h2 class="font-semibold">
                        Official Business List
                    </h2>
                </div>
            </a>
        @endif
   

    </div>
