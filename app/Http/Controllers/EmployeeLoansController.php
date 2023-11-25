<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use Illuminate\Http\Request;

class EmployeeLoansController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $loans = Loan::all();
        return view('loans.index', compact('loans'));
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
        Loan::create([
            'name' => $request->name,
            'description' => $request->description,
            'amount' => $request->amount,
        ]);

        createActivity('Create Loan', 'Loan '. $request->name . ' created successfully.', request()->getClientIp(true));
        return redirect()->back()->with('success', 'Loan created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Loan $loan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Loan $loan)
    {
        return view('loans.edit', compact('loan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Loan $loan)
    {
        $loan->update([
            'name' => $request->name,
            'description' => $request->description,
            'amount' => $request->amount,
        ]);

        createActivity('Update Loan', 'Loan '. $request->name .'updated successfully.', request()->getClientIp(true));
        return redirect()->route('loans.index')->with('success', 'Loan updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Loan $loan)
    {
        createActivity('Delete Loan', 'Loan '. $loan->name .'deleted successfully.', request()->getClientIp(true));
        $loan->delete();
        return redirect()->route('loans.index')->with('success', 'Loan deleted successfully');
    }
}
