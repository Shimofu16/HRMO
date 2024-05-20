<?php

namespace App\Http\Controllers;

use App\Models\Allowance;
use App\Models\Category;
use App\Models\Department;
use Illuminate\Http\Request;

class AllowanceController extends Controller
{
    public function index()
    {
        $allowances = Allowance::all();
        $categories = Category::all();
        $departments = Department::all();
        $rataTypes  = [
            [
                'type' => 'OFFICER',
                'amount' => 6375,
            ],
            [
                'type' => 'HEAD',
                'amount' => 6375,
            ],
            [
                'type' => 'SB',
                'amount' => 6375,
            ],
            [
                'type' => 'MAYOR',
                'amount' => 7650,
            ],
            [
                'type' => 'VICE MAYOR',
                'amount' => 7650,
            ],
        ];
        return view('settings.allowances.index', compact('allowances', 'categories', 'departments', 'rataTypes'));
    }

    public function create()
    {
        return view('settings.allowances.create');
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $rataTypes  = [
            [
                'type' => 'OFFICER',
                'amount' => 6375,
            ],
            [
                'type' => 'HEAD',
                'amount' => 6375,
            ],
            [
                'type' => 'SB',
                'amount' => 6375,
            ],
            [
                'type' => 'MAYOR',
                'amount' => 7650,
            ],
            [
                'type' => 'VICE MAYOR',
                'amount' => 7650,
            ],
        ];
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
        $departments = $request->department_id;
        $rata_types = $request->rata_types;
        if ($categories) {
            foreach ($categories as $key => $category) {
                $allowance->categories()->create(['category_id' => $category]);
            }
        }
        if ($departments) {
            foreach ($departments as $key => $department) {
                $allowance->categories()->create(['department_id' => $department]);
            }
        }
        if ($rata_types) {
            foreach ($rata_types as $key => $rata_type) {
                $allowance->categories()->create([
                    'type' => $rataTypes[$rata_type]['type'],
                    'amount' => $rataTypes[$rata_type]['amount'],
                ]);
            }
        }

        createActivity('Create Allowance', 'Allowance ' . $request->allowance_name . ' created successfully.', request()->getClientIp(true));
        return redirect()->back()->with('success', 'Allowance created successfully.');
    }

    public function edit(Allowance $allowance)
    {
        $allowances = Allowance::all();
        $categories = Category::all();
        $departments = Department::all();
        $rataTypes  = [
            [
                'type' => 'OFFICER',
                'amount' => 6375,
            ],
            [
                'type' => 'HEAD',
                'amount' => 6375,
            ],
            [
                'type' => 'SB',
                'amount' => 6375,
            ],
            [
                'type' => 'MAYOR',
                'amount' => 7650,
            ],
            [
                'type' => 'VICE MAYOR',
                'amount' => 7650,
            ],
        ];
        return view('settings.allowances.edit', compact('allowance', 'categories', 'departments', 'rataTypes'));
    }

    public function update(Request $request, Allowance $allowance)
    {
        $request->validate([
            'allowance_code' => 'required',
            'allowance_name' => 'required',
            'allowance_amount' => 'required',
            'allowance_ranges' => 'required',
            'category_id' => 'required',
        ]);
        $rataTypes  = [
            [
                'type' => 'OFFICER',
                'amount' => 6375,
            ],
            [
                'type' => 'HEAD',
                'amount' => 6375,
            ],
            [
                'type' => 'SB',
                'amount' => 6375,
            ],
            [
                'type' => 'MAYOR',
                'amount' => 7650,
            ],
            [
                'type' => 'VICE MAYOR',
                'amount' => 7650,
            ],
        ];
        $allowance->update([
            'allowance_code' => $request->allowance_code,
            'allowance_name' => $request->allowance_name,
            'allowance_amount' => $request->allowance_amount,
            'allowance_ranges' => $request->allowance_ranges,
        ]);
        $allowance->categories()->delete();
        $categories = $request->category_id;
        $departments = $request->department_id;
        $rata_types = $request->rata_types;
        if ($categories) {
            foreach ($categories as $key => $category) {
                $allowance->categories()->create(['category_id' => $category]);
            }
        }
        if ($departments) {
            foreach ($departments as $key => $department) {
                $allowance->categories()->create(['department_id' => $department]);
            }
        }
        if ($rata_types) {
            foreach ($rata_types as $key => $rata_type) {
                $allowance->categories()->create([
                    'type' => $rataTypes[$rata_type]['type'],
                    'amount' => $rataTypes[$rata_type]['amount'],
                ]);
            }
        }

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
