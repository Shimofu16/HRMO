<?php

namespace App\Http\Controllers;

use App\Models\Rata;
use Illuminate\Http\Request;

class RataController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        return view('settings.ratas.index', [
            'rata_types' => Rata::all()
        ]);
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
            'type' => 'required|string',
            'amount' => 'required|integer',
            'ranges' => 'required|array',
        ]);

        $rata = new Rata();
        $rata->type = $request->input('type');
        $rata->amount = $request->input('amount');
        $rata->ranges = $request->input('ranges');
        $rata->save();

        createActivity('Create Rata', 'Rata type ' . $request->type . ' created successfully.', request()->getClientIp(true));
        return redirect()->back()->with('success', 'Rata created successfully.');
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
    public function edit(Rata $rata)
    {
        return view('settings.ratas.edit', [
            'rata_type' => $rata
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Rata $rata)
    {
        $request->validate([
            'type' => 'required|string',
            'amount' => 'required|integer',
            'ranges' => 'required|array',
        ]);

        $rata->type = $request->input('type');
        $rata->amount = $request->input('amount');
        $rata->ranges = $request->input('ranges');
        $rata->save();

        createActivity('Update Rata', 'Rata type ' . $request->type . ' updated successfully.', request()->getClientIp(true));
        return redirect()->back()->with('success', 'Rata updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Rata $rata)
    {
        //
    }
}
