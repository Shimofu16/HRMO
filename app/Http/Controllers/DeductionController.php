<?php

namespace App\Http\Controllers;

use App\Models\Deduction;
use Illuminate\Http\Request;

class DeductionController extends Controller
{
    public function index()
    {
        $deductions = Deduction::all();

        return view('deductions.index', compact('deductions'));
    }

    public function create()
    {
        return view('deductions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'deduction_code' => 'required',
            'deduction_name' => 'required',
            'deduction_amount' => 'required',
            'deduction_type' => 'required',
            'deduction_range' => 'required',
        ]);

        Deduction::create($request->all());

        return redirect()->route('deductions.index')->with('success', 'Deduction created successfully.');
    }

    public function edit(Deduction $deduction)
    {
        return view('deductions.edit', compact('deduction'));
    }

    public function update(Request $request, Deduction $deduction)
    {
        $request->validate([
            'deduction_code' => 'required',
            'deduction_name' => 'required',
            'deduction_amount' => 'required',
        ]);

        $deduction->update($request->all());

        return redirect()->route('deductions.index')->with('success', 'Deduction updated successfully.');
    }

    public function destroy(Deduction $deduction)
    {
        $deduction->delete();

        return redirect()->route('deductions.index')->with('success', 'Deduction deleted successfully.');
    }
}

