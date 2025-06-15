<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;

class StudentController extends Controller
{
    // Show the create student form
    public function create()
    {
        $students = Student::all();
        return view('student', compact('students'));
    }


    // Handle form submission and save to database
    public function store(Request $request)
    {
        // Validate input data
        $request->validate([
            'firstname' => 'required|string|max:255',
            'middlename' => 'nullable|string|max:255',
            'lastname' => 'required|string|max:255',
            'age' => 'required|integer|min:0',
            'birthdate' => 'required|date',
        ]);

        // Save the data to the database
        Student::create([
            'firstname' => $request->firstname,
            'middlename' => $request->middlename,
            'lastname'  => $request->lastname,
            'age'       => $request->age,
            'birthdate' => $request->birthdate,
        ]);

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Student created successfully!');
    }
}
