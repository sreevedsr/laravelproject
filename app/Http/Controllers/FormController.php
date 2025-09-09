<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Form;
use Illuminate\Support\Facades\DB;



class FormController extends Controller
{
    public function showForm(Request $request)
    {
        $query = DB::table('forms');

        $isFiltered = $request->filled('search') || $request->filled('from_date') || $request->filled('to_date');
        // Search by first_name, last_name or email
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('id', 'like', "%$search")
                    ->orWhere('first_name', 'like', "%$search%")
                    ->orWhere('last_name', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%")
                    ->orWhere('phone', 'like', "%$search");
            });
        }

        // Filter by date range
        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->input('from_date'));
        }
        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->input('to_date'));
        }

        $forms = $query->orderBy('created_at', 'desc')->get();
        return view('form', [
            'forms' => $forms,
            'isFiltered' => $isFiltered
        ]);
    }


    public function handleForm(Request $request)
    {
        //  dd($request->all());
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => ['required', 'string', 'regex:/^[0-9+\- ]{7,10}$/'],
        ], [
            'first_name.required' => 'Please enter your first name.',
            'last_name.required' => 'Please enter your last name.',
            'email.required' => 'Email is mandatory.',
            'email.email' => 'Please enter a valid email address.',
            'phone.digits' => 'Phone number must be 10 digits.'
        ]);
        if ($request->id) {
            $form = Form::find($request->id);
            if ($form) {
                $form->update($validated);
                return back()->with('success', 'Form updated successfully!');
            } else {
                return back()->with('error', 'Form not found.');
            }
        } else {
            Form::create($validated);
            return back()->with('success', 'Form submitted successfully!');
        }
    }
    public function delete($id)
    {
        $form = Form::find($id);

        if ($form) {
            $form->delete();
            return back()->with('success', 'Form deleted successfully!');
        } else {
            return back()->with('error', 'Form not found.');
        }
    }
    public function search(Request $request)
{
    $query = DB::table('forms');

    if ($request->filled('search')) {
        $search = $request->input('search');
        $query->where(function($q) use ($search) {
            $q->where('first_name', 'like', "%$search%")
              ->orWhere('last_name', 'like', "%$search%")
              ->orWhere('email', 'like', "%$search%");
        });
    }

    $forms = $query->orderBy('created_at', 'desc')->get();

       $isFiltered = $request->filled('search');

    return view('partials.forms_table', compact('forms', 'isFiltered'));
}


}


