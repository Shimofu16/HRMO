<x-app-layout>
    <x-slot name="header">
        <h1 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Attendance
        </h1>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('attendances.update', $attendance) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="employee_id">Employee</label>
                            <select name="employee_id" id="employee_id" class="form-control">
                                @foreach($employees as $employee)
                                    <option value="{{ $employee->id }}" {{ $employee->id === $attendance->employee_id ? 'selected' : '' }}>{{ $employee->full_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="status">Status</label>
                            <select name="status" id="status" class="form-control">
                                <option value="present" {{ $attendance->status === 'present' ? 'selected' : '' }}>Present</option>
                                <option value="absent" {{ $attendance->status === 'absent' ? 'selected' : '' }}>Absent</option>
                                <option value="late" {{ $attendance->status === 'late' ? 'selected' : '' }}>Late</option>
                                <option value="undertime" {{ $attendance->status === 'undertime' ? 'selected' : '' }}>Undertime</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="date">Date</label>
                            <input type="date" name="date" id="date" class="form-control" value="{{ $attendance->date }}">
                        </div>

                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
