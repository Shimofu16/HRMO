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
                </div>

            </div>
            {{-- second column --}}
            <div class="">
                <div class="flex flex-col items-center justify-center h-full p-4">
                    @php
                        $isTimeIn = 1;
                        // set the 10am
                        $time = date('H:i:s', strtotime('10:00:00'));
                        // check if the current time is > 10am
                        if (date('H:i:s') > $time) {
                            $isTimeIn = 0;
                        }
                    @endphp
                    <form action="{{ route('employee.attendance.store', ['isTimeIn' => $isTimeIn]) }}" method="post"
                        id="attendance">
                        @csrf
                        <div id="my_camera"></div>
                        <div id="results"></div>
                        <input type="hidden" name="image" class="image-tag">
                        <div class="grid grid-cols-6 gap-6">
                            <div class="col-span-6 sm:col-span-6">
                                <label for="employee_no" class="block font-medium text-gray-700">Employee
                                    Name/Number</label>
                                <input list="employees" type="text" name="employee_no" id="employee_no"
                                    class="block w-full mt-1 rounded-md shadow-sm form-input" autofocus required>
                                <datalist id="employees">
                                    @foreach ($employees as $employee)
                                        <option value="{{ $employee->emp_no }}">
                                            {{ $employee->name }}
                                        </option>
                                    @endforeach
                                </datalist>
                            </div>
                        </div>
                        <div class="mt-4 text-center">
                            <button class="px-4 py-2 font-bold text-white bg-blue-500 rounded hover:bg-blue-700"
                                type="button" onclick="take_snapshot()">Time
                                {{ $isTimeIn == 1 ? 'In' : 'Out' }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
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
