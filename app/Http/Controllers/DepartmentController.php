<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::orderBy('id', 'asc')->get();


        return view('departments.index', compact('departments'));
    }

    public function create()
    {
        return view('departments.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'dep_name' => 'required',
        ]);

        $request->merge(['dep_code' => toCode($request->dep_name)]);

        Department::create($request->all());

        createActivity('Create Department', 'Department '.$request->dep_name.' created successfully.', request()->getClientIp(true));

        return redirect()->route('departments.index')->with('success', 'Department created successfully.');
    }

    public function edit(Department $department)
    {
        return view('departments.edit', compact('department'));
    }

    public function update(Request $request, Department $department)
    {
        $request->validate([
            'dep_code' => 'required',
            'dep_name' => 'required',
        ]);

        $department->update($request->all());

        createActivity('Update Department', 'Department '.$department->dep_name.' updated successfully.', request()->getClientIp(true), $department, $request);

        return redirect()->route('departments.index')->with('success', 'Department updated successfully.');
    }

    public function destroy(Department $department)
    {
        createActivity('Delete Department', 'Department '.$department->dep_name.' deleted successfully.', request()->getClientIp(true));

        $department->delete();

        return redirect()->route('departments.index')->with('success', 'Department deleted successfully.');
    }
}
