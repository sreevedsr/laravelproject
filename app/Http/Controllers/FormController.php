<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Form;
use Illuminate\Support\Facades\DB;



class FormController extends Controller
{
    public function showForm()
    {
        $forms = DB::table('forms')->get();
        return view('form', compact('forms'));
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

        Form::create($validated);
        return back()->with('success', 'Form submitted successfully!');
    }

}


