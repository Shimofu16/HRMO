<?php

namespace App\Http\Controllers;

use App\Models\Signature;
use Illuminate\Http\Request;

class SignatureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view(
            'settings.signatures.index',
            [
                'signatures' => Signature::all()
            ]
        );
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
    try {
        // Validate the input
        $request->validate([
            'name' => 'required',
            'position' => 'required',
        ]);

        // Check if the position is 'Municipal Mayor' and if one already exists
        if ($request->position === 'Municipal Mayor' && Signature::where('position', 'Municipal Mayor')->exists()) {
            return back()->with('error', 'A Municipal Mayor already exists.');
        }

        // Check if the signatures count is at or exceeds the limit
        // if (Signature::count() >= 4) {
        //     return back()->with('error', 'You can only add up to 4 signatures.');
        // }

        // Create the new signature
        Signature::create([
            'name' => $request->name,
            'position' => $request->position,
        ]);

        return back()->with('success', 'Successfully Created');
    } catch (\Throwable $th) {
        return back()->with('error', $th->getMessage());
    }
}


    /**
     * Display the specified resource.
     */
    public function show(Signature $signature)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Signature $signature)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Signature $signature)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Signature $signature)
    {
        try {
            $signature->delete();
            return back()->with('success', 'Successfully Deleted');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
            //throw $th;
        }
    }
}