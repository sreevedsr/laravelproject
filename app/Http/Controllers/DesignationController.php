<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Designation;

class DesignationController extends Controller
{
    // Show the add-designation form and list all designations
    public function index()
    {
        $designations = Designation::orderBy('created_at', 'desc')->get();
        return view('designations.create', compact('designations')); // use create.blade.php
    }

    // Store a new designation
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:designations,name|max:255',
        ]);

        Designation::create([
            'name' => $request->name
        ]);

        return redirect()->back()->with('success', 'Designation added successfully!');
    }

    // Delete a designation
    public function destroy($id)
    {
        $designation = Designation::find($id);
        if ($designation) {
            $designation->delete();
            return back()->with('success', 'Designation deleted successfully!');
        }
        return back()->with('error', 'Designation not found.');
    }

    public function create()
    {
        // if you need to pass data (like list of designations), do it here
        $designations = Designation::all();

        return view('designations.create', compact('designations'));
    }
}
