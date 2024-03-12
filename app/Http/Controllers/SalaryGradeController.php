<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\SalaryGrade;
use Illuminate\Http\Request;

class SalaryGradeController extends Controller
{
    public function index()
    {
        $salary_grades = SalaryGrade::all();

        return view('settings.salary_grades.index', compact('salary_grades'));
    }

    public function create()
    {
        return view('settings.salary_grades.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'step' => 'required',
            'amount' => 'required',
        ]);
        foreach ($request->step as $key => $value) {
            $steps[] =
                [
                    'step' => 'Step ' . ($key + 1),
                    'amount' => $request->amount[$key],
                ];
        }
        SalaryGrade::create([
            'steps' => $steps
        ]);

        createActivity('Create Salary Grade', 'Salary grade created successfully');

        return redirect()->route('salary-grades.index')->with('success', 'Salary Grade created successfully.');
    }

    public function edit(SalaryGrade $salary_grade)
    {
        return view('settings.salary_grades.edit', compact('salary_grade'));
    }

    public function update(Request $request, SalaryGrade $salary_grade)
    {
        $request->validate([
            'sg_code' => 'required',
            'sg_name' => 'required',
        ]);

        $salary_grade->update($request->all());

        return redirect()->back()->with('success', 'Salary Grade updated successfully.');
    }

    public function destroy(SalaryGrade $salary_grade)
    {
        $salary_grade->delete();

        return redirect()->back()->with('success', 'Salary Grade deleted successfully.');
    }
}
