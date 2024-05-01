<?php

namespace App\Http\Controllers;

use App\Models\AdminPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PasswordController extends Controller
{
    public function index()
    {
        return view('password.index');
    }

    public function update(Request $request)
    {

        try {
            $request->validate([
                'current_password' => 'required',
                'password' => 'required|min:8',
                'password_confirmation' => 'required|same:password',
            ]);
            $password = AdminPassword::first();
            if (!Hash::check($request->current_password, $password->password)) {
                return redirect()->back()->with('error', 'Current password does not match!');
            }

            $password->update([
                'password' => Hash::make($request->password),
            ]);

            return back()->with('success', 'Password Updated Successfully');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
