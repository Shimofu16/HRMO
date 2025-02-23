<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Department;
use App\Models\Hazard;
use App\Models\SalaryGrade;
use Illuminate\Http\Request;

class HazardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $hazards = Hazard::all();
        $categories = Category::all();
        $departments = Department::all();
        $salary_grades = SalaryGrade::all();
        return view('settings.hazards.index', compact('hazards', 'categories', 'departments', 'salary_grades'));
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
        // dd($request->all());
        $request->validate([
            'category_id' => 'required|integer',
            'department_id' => 'required|integer',
            'name' => 'required|string',
            'amount' => 'required|numeric',
            'amount_type' => 'required|string',
            'ranges' => 'required|array',
            'salary_grades' => 'required|array',
        ]);

        $hazard = new Hazard();
        $hazard->category_id = $request->category_id;
        $hazard->department_id = $request->department_id;
        $hazard->name = $request->name;
        $hazard->amount = $request->amount;
        $hazard->amount_type = $request->amount_type;
        $hazard->ranges = $request->ranges;
        $hazard->save();
        foreach ($request->salary_grades as $salary_grade) {
            $hazard->salaryGrades()->create(['salary_grade_id' => $salary_grade]);
        }

        createActivity('Create Hazard', 'Hazard ' . $hazard->name . ' Created successfully.', $request->getClientIp(true), $hazard, $request);

        return redirect()->back()->with('success', 'Hazard created successfully.');
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
    public function edit(Hazard $hazard)
    {
        // dd($hazard, $hazard->salaryGrades);
        return view('settings.hazards.edit', [
            'hazard' => $hazard,
            'categories' => Category::all(),
            'departments' => Department::all(),
            'salary_grades' => SalaryGrade::all(),
        ]);
    }
 

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Hazard $hazard)
    {
        $request->validate([
            'category_id' => 'required|integer',
            'department_id' => 'required|integer',
            'name' => 'required|string',
            'amount' => 'required|numeric',
            'amount_type' => 'required|string',
            'ranges' => 'required|array',
            'salary_grades' => 'required|array',
        ]);

        $hazard->category_id = $request->category_id;
        $hazard->department_id = $request->department_id;
        $hazard->name = $request->name;
        $hazard->amount = $request->amount;
        $hazard->amount_type = $request->amount_type;
        $hazard->ranges = $request->ranges;
        $hazard->save();
        $hazard->salaryGrades()->delete();
        foreach ($request->salary_grades as $salary_grade) {
            $hazard->salaryGrades()->create(['salary_grade_id' => $salary_grade]);
        }

        createActivity('Update Hazard', 'Hazard ' . $hazard->name . ' Updated successfully.', $request->getClientIp(true), $hazard, $request);
        return redirect()->back()->with('success', 'Hazard updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
