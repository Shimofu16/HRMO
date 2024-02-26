<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Designation;

class DesignationController extends Controller
{
    public function index()
    {
        $designations = Designation::orderBy('designation_name', 'asc')
            ->get();

        return view('settings.designations.index', compact('designations'));
    }

    public function create()
    {
        return view('settings.designations.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'designation_code' => 'required',
            'designation_name' => 'required',
        ]);

        Designation::create($request->all());

        createActivity('Create Designation', 'Designation ' . $request->designation_name . ' created successfully.', request()->getClientIp(true));

        return redirect()->back()->with('success', 'Designation created successfully.');
    }

    public function edit(Designation $designation)
    {
        return view('settings.designations.edit', compact('designation'));
    }

    public function update(Request $request, Designation $designation)
    {
        $request->validate([
            'designation_code' => 'required',
            'designation_name' => 'required',
        ]);

        $designation->update($request->all());

        createActivity('Update Designation', 'Designation ' . $request->designation_name . ' updated successfully.', request()->getClientIp(true), $designation, $request);;

        return redirect()->back()->with('success', 'Designation updated successfully.');
    }

    public function destroy(Designation $designation)
    {
        $designation->delete();

        return redirect()->back()->with('success', 'Designation deleted successfully.');
    }
}
