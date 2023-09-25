<?php

namespace App\Http\Controllers;

use App\Models\SalaryGradeStep;
use App\Models\Sgrade;
use Illuminate\Http\Request;

class SalaryGradeStepController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(Request $request, $salary_grade_id)
    {
        $salary_grade = Sgrade::findOrFail($salary_grade_id);
       
        if ($salary_grade->steps()->count() > 0) {
            foreach ($request->step as $key => $value) {
                $salary_grade->steps()->create([
                    'step' => 'Step ' . ($salary_grade->steps()->count() + 1),
                    'amount' => $request->amount[$key],
                ]);
            }
        }else{
            foreach ($request->step as $key => $value) {
                $salary_grade->steps()->create([
                    'step' => $value,
                    'amount' => $request->amount[$key],
                ]);
            }
        }

        return back()->with('success', 'Salary Grade Steps successfully added.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return view('sgrades.steps.show', [
            'salary_grade' => Sgrade::findOrFail($id),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SalaryGradeStep $salaryGradeStep)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $step_id)
    {
        $step = SalaryGradeStep::findOrFail($step_id);
        $step->update(['amount' => $request->amount]);
        return back()->with('success', 'Salary Grade Step successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SalaryGradeStep $salaryGradeStep)
    {
        //
    }
}
