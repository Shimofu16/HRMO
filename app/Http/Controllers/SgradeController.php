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
        $sgrades = Sgrade::orderBy('sg_name', 'asc')
        ->paginate(10);

        return view('sgrades.index', compact('sgrades'));
    }

    public function create()
    {
        return view('sgrades.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'sg_code' => 'required',
            'sg_name' => 'required',
            'sg_amount' => 'required',
        ]);

        Sgrade::create($request->all());

        return redirect()->route('sgrades.index')->with('success', 'Salary Grade created successfully.');
    }

    public function edit(Sgrade $sgrade)
    {
        return view('sgrades.edit', compact('sgrade'));
    }

    public function update(Request $request, Sgrade $sgrade)
    {
        $request->validate([
            'sg_code' => 'required',
            'sg_name' => 'required',
            'sg_amount' => 'required',
        ]);

        $sgrade->update($request->all());

        return redirect()->route('sgrades.index')->with('success', 'Salary Grade updated successfully.');
    }

    public function destroy(Sgrade $sgrade)
    {
        $sgrade->delete();

        return redirect()->route('sgrades.index')->with('success', 'Salary Grade deleted successfully.');
    }
}