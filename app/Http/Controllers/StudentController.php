<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;

class StudentController extends Controller
{
    // ✅ This method was missing
    public function index()
    {
        $students = Student::all();
        return view('student', compact('students'));
    }

    // Show the create student form (not currently used separately)
    public function create()
    {
        $students = Student::all();
        return view('student', compact('students'));
    }

    // Handle form submission and save to database
    public function store(Request $request)
    {
        $request->validate([
            'firstname' => 'required|string|max:255',
            'middlename' => 'nullable|string|max:255',
            'lastname'  => 'required|string|max:255',
            'age'       => 'required|integer|min:0',
            'birthdate' => 'required|date',
        ]);

        Student::create([
            'firstname' => $request->firstname,
            'middlename' => $request->middlename,
            'lastname'  => $request->lastname,
            'age'       => $request->age,
            'birthdate' => $request->birthdate,
        ]);

        return redirect()->route('student.index')->with('success', 'Student created successfully!');
    }

    public function edit($id)
    {
        $student = Student::findOrFail($id);
        $students = Student::all();
        return view('student', compact('student', 'students'));
    }

    public function update(Request $request, $id)
    {
        $student = Student::findOrFail($id);
        $student->update($request->only(['firstname', 'middlename', 'lastname', 'age', 'birthdate']));

        return redirect()->route('student.index')->with('success', 'Student updated successfully.');
    }

    public function destroy($id)
    {
        $student = Student::findOrFail($id);
        $student->delete();

        return redirect()->route('student.index')->with('success', 'Student deleted successfully.');
    }
}
