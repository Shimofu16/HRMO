<x-guest-layout>

    <div class="overflow-hidden rounded w-aito">
        {{-- generate a two columns --}}
        <div class="flex justify-between">
            {{-- first column --}}
            <div class="">
                {{-- display a title of Employee Attendance and underneath it is a time and date --}}
                <div class="flex flex-col items-center justify-center h-full p-4">
                    <h1 class="text-4xl font-bold text-center">Employee Attendance</h1>
                    <h2 class="text-2xl text-center" id="time">00:00:00</h2>
                    <p class="text-xl text-center" id="date">Monday, April 19, 2023</p>
                    @if ($isTodayHoliday)
                        <h1 class="text-4xl font-bold text-center mt-3">Its Holiday today.</h1>
                    @endif
                </div>

            </div>
            @if (!$isTodayHoliday)
                {{-- second column --}}
                <div class="">
                    <div class="flex flex-col items-center justify-center h-full p-4">
                        <form action="{{ route('employee.attendance.store') }}" method="post" id="attendance">
                            @csrf
                            {{-- <div id="my_camera"></div>
                            <div id="results"></div>
                            <input type="hidden" name="image" class="image-tag"> --}}
                            <div class="grid grid-cols-6 gap-6">
                                <div class="col-span-6 sm:col-span-6">
                                    <label for="employee_number" class="block font-medium text-gray-700">Employee
                                        Number</label>
                                    <input list="employees" type="text" name="employee_number" id="employee_number"
                                        class="block w-full mt-1 rounded shadow-sm form-input" autofocus required>
                                    <datalist id="employees">
                                        @foreach ($employees as $employee)
                                            <option value="{{ $employee->employee_number }}">
                                                {{ $employee->employee_number }}
                                            </option>
                                        @endforeach
                                    </datalist>
                                </div>
                            </div>
                            <div class="grid grid-cols-6 gap-6">
                                <div class="col-span-6 sm:col-span-6">
                                    {{-- generate a select for time in and time out --}}
                                    <label for="type" class="block font-medium text-gray-700">Type</label>
                                    <select name="type" id="type"
                                        class="block w-full mt-1 rounded shadow-sm form-input" required>
                                        <option value="1">Time In</option>
                                        <option value="0">Time Out</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mt-4 text-center">
                                <button class="px-4 py-2 font-bold text-white bg-blue-500 rounded hover:bg-blue-700"
                                    type="button" onclick="take_snapshot()">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            @endif
        </div>

    </div>
    {{-- @if (!$isTodayHoliday)
        <script src="{{ asset('assets/webcam/webcam.min.js') }}"></script>
        <script language="JavaScript">
            Webcam.set({
                width: 300,
                height: 300,
                image_format: 'jpeg',
                jpeg_quality: 90
            });

            Webcam.attach('#my_camera');

            function take_snapshot() {
                Webcam.snap(function(data_uri) {
                    // Update all image tags with the same image URI
                    const imageInput = document.querySelector('.image-tag');
                    imageInput.value = data_uri;
                    console.log(imageInput);
                    document.getElementById('results').innerHTML = '<img src="' + data_uri + '"/>';
                    //hide camera
                    Webcam.reset();
                    document.querySelector('#my_camera').style.display = 'none';
                    // submit form
                    document.getElementById('attendance').submit();
                });
            }
        </script>
    @endif --}}
    <script>
        function updateTime() {
            const date = new Date();

            // Get hours, minutes, and seconds
            let hours = date.getHours() % 12 || 12;
            let minutes = date.getMinutes();
            let seconds = date.getSeconds();

            // Add leading zeros if needed
            hours = hours < 10 ? '0' + hours : hours;
            minutes = minutes < 10 ? '0' + minutes : minutes;
            seconds = seconds < 10 ? '0' + seconds : seconds;

            // Determine AM or PM
            const ampm = date.getHours() >= 12 ? 'PM' : 'AM';

            // Display the time
            document.getElementById('time').textContent = `${hours}:${minutes}:${seconds} ${ampm}`;

            // Get day, month, date, and year
            const days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
            const months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September',
                'October', 'November', 'December'
            ];

            let day = days[date.getDay()];
            let month = months[date.getMonth()];
            let dateNum = date.getDate();
            let year = date.getFullYear();

            // Display the date
            document.getElementById('date').textContent = `${day}, ${month} ${dateNum}, ${year}`;
        }

        // Call updateTime every second
        setInterval(updateTime, 1000);
    </script>
</x-guest-layout>
