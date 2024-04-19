<?php

namespace App\Http\Controllers;

use App\Models\Holiday;
use Illuminate\Http\Request;

class HolidayController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('settings.holidays.index', ['holidays' => Holiday::all()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required'],
            'date' => ['required', 'date'],
        ]);
        Holiday::create([
            'name' => $request->name,
            'date' => $request->date,
        ]);
        createActivity('Create Holiday', 'Holiday ' . $request->name . ' created successfully.', request()->getClientIp(true));
        return redirect()->back()->with('success', 'Holiday created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Holiday $holiday)
    {
        return view('settings.holidays.edit', ['holiday' => $holiday]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Holiday $holiday)
    {
        $request->validate([
            'name' => ['required'],
            'date' => ['required', 'date'],
        ]);
        $holiday->update([
            'name' => $request->name,
            'date' => $request->date,
        ]);

        createActivity('Update Holiday', 'Holiday ' . $request->name . ' update successfully.', request()->getClientIp(true));
        return redirect()->back()->with('success', 'Holiday update successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Holiday $holiday)
    {

        createActivity('Delete Holiday', 'Holiday ' . $holiday->name . ' delete successfully.', request()->getClientIp(true));
        $holiday->delete;
        return redirect()->back()->with('success', 'Holiday delete successfully.');
    }
}
