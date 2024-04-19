<?php

namespace App\Http\Controllers;

use App\Models\Allowance;
use App\Models\Category;
use Illuminate\Http\Request;

class AllowanceController extends Controller
{
    public function index()
    {
        $allowances = Allowance::all();
        $categories = Category::all();
        return view('settings.allowances.index', compact('allowances', 'categories'));
    }

    public function create()
    {
        return view('settings.allowances.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'allowance_code' => 'required',
            'allowance_name' => 'required',
            'allowance_amount' => 'required',
            'allowance_ranges' => 'required',
            'category_id' => 'required',
        ]);

        $allowance =  Allowance::create([
            'allowance_code' => $request->allowance_code,
            'allowance_name' => $request->allowance_name,
            'allowance_amount' => $request->allowance_amount,
            'allowance_ranges' => $request->allowance_ranges,
        ]);
        $categories = $request->category_id;
        foreach ($categories as $key => $category) {
            $allowance->categories()->create(['category_id' => $category]);
        }

        createActivity('Create Allowance', 'Allowance ' . $request->allowance_name . ' created successfully.', request()->getClientIp(true));
        return redirect()->back()->with('success', 'Allowance created successfully.');
    }

    public function edit(Allowance $allowance)
    {
        $categories = Category::all();
        return view('settings.allowances.edit', compact('allowance', 'categories'));
    }

    public function update(Request $request, Allowance $allowance)
    {
        $request->validate([
            'allowance_code' => 'required',
            'allowance_name' => 'required',
            'allowance_amount' => 'required',
            'allowance_range' => 'required',
            'category_id' => 'required',
        ]);

        $allowance->update($request->all());

        createActivity('Update Allowance', 'Allowance ' . $allowance->allowance_name . ' updated successfully.', request()->getClientIp(true), $allowance, $request);

        return redirect()->back()->with('success', 'Allowance updated successfully.');
    }

    public function destroy(Allowance $allowance)
    {
        createActivity('Delete Allowance', 'Allowance' . $allowance->allowance_code . ' deleted successfully.', request()->ip());
        $allowance->delete();

        return redirect()->back()->with('success', 'Allowance deleted successfully.');
    }
}
