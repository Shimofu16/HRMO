<?php

namespace App\Http\Controllers;

use App\Models\Deduction;
use Illuminate\Http\Request;

class DeductionController extends Controller
{
    public function index()
    {
        $deductions = Deduction::all();

        return view('settings.deductions.index', compact('deductions'));
    }

    public function create()
    {
        return view('settings.deductions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'deduction_code' => 'required',
            'deduction_name' => 'required',
            'deduction_amount' => 'required',
            'deduction_amount_type' => 'required',
            'deduction_type' => 'required',
            'deduction_range' => 'required',
        ]);

        Deduction::create($request->all());

        createActivity('Create Deduction', 'Deduction ' . $request->deduction_name . 'created successfully.', request()->getClientIp(true));

        return redirect()->back()->with('success', 'Deduction created successfully.');
    }

    public function edit(Deduction $deduction)
    {
        return view('settings.deductions.edit', compact('deduction'));
    }

    public function update(Request $request, Deduction $deduction)
    {
        $request->validate([
            'deduction_code' => 'required',
            'deduction_name' => 'required',
            'deduction_amount' => 'required',
            'deduction_amount_type' => 'required',
        ]);

        $deduction->update($request->all());

        createActivity('Update Deduction', 'Deduction '. $request->deduction_name.'updated successfully.', request()->getClientIp(true), $deduction, $request);

        return redirect()->back()->with('success', 'Deduction updated successfully.');
    }

    public function destroy(Deduction $deduction)
    {

        createActivity('Delete Deduction', 'Deduction '. $deduction->deduction_name.'deleted successfully.', request()->getClientIp(true));
        $deduction->delete();

        return redirect()->back()->with('success', 'Deduction deleted successfully.');
    }
}

