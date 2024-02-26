<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Sgrade;
use Illuminate\Http\Request;

class SgradeController extends Controller
{
    public function index()
    {
        $sgrades = Sgrade::all();

        return view('settings.salary_grades.index', compact('sgrades'));
    }

    public function create()
    {
        return view('settings.salary_grades.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'sg_code' => 'required',
            'sg_name' => 'required',
        ]);

        Sgrade::create($request->all());

        createActivity('Create Salary Grade', 'Salary grade '. $request->sg_name. ' created successfully');

        return redirect()->back()->with('success', 'Salary Grade created successfully.');
    }

    public function edit(Sgrade $sgrade)
    {
        return view('settings.salary_grades.edit', compact('sgrade'));
    }

    public function update(Request $request, Sgrade $sgrade)
    {
        $request->validate([
            'sg_code' => 'required',
            'sg_name' => 'required',
        ]);

        $sgrade->update($request->all());

        return redirect()->back()->with('success', 'Salary Grade updated successfully.');
    }

    public function destroy(Sgrade $sgrade)
    {
        $sgrade->delete();

        return redirect()->back()->with('success', 'Salary Grade deleted successfully.');
    }
}
