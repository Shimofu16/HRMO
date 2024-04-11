<?php

namespace App\Http\Controllers;

use App\Models\Level;
use Illuminate\Http\Request;

class LevelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('settings.levels.index', [
            'levels' => Level::all()
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
            'name' => 'required',
            'amount' => 'required',
        ]);

        Level::create($request->all());

        createActivity('Create Level', 'Level ' . $request->name . ' created successfully.', request()->getClientIp(true));

        return redirect()->back()->with('success', 'Level created successfully.');
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
    public function edit(Level $level)
    {
        return view('settings.levels.edit', [
            'level' => $level
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Level $level)
    {
        $request->validate([
            'name' => 'required',
            'amount' => 'required',
        ]);

        $level->update($request->all());

        createActivity('Update Level', 'Level ' . $request->name . ' updated successfully.', request()->getClientIp(true), $level, $request);

        return redirect()->back()->with('success', 'Level updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Level $level)
    {
        createActivity('Delete Level', 'Level ' . $level->name . ' deleted successfully.', request()->getClientIp(true));
        $level->delete();
        return redirect()->back()->with('success', 'Level deleted successfully.');
    }
}
