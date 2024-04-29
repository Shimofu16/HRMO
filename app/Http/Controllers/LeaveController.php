<?php

namespace App\Http\Controllers;

use App\Models\EmployeeLeaveRequest;
use Illuminate\Http\Request;

class LeaveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(string $status)
    {
        return view('leaves.index', [
            'leave_requests' => EmployeeLeaveRequest::where('status', $status)->get(),
            'status' => $status
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $types = [
            'vacation',
            'sick',
            'force',
        ];
       
        return view('leaves.create', [
            'types' => $types
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $status)
    {
        return view('leaves.index', [
            'leave_requests' => EmployeeLeaveRequest::where('status', $status)->get(),
            'status' => $status
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EmployeeLeaveRequest $leave_request)
    {
        $statuses = [
            'accepted',
            'rejected',
        ];
        return view('leaves.edit', ['statuses' => $statuses, 'leave_request' => $leave_request]);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EmployeeLeaveRequest $leave_request)
    {
        try {
            $request->validate(['status' => 'required']);
            $leave_request->update(['status'=> $request->status]);
            return redirect()->route('leave-requests.index', ['status' => $request->status])->with('success', 'Successfully updated leave request.');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
