<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use Picqer\Barcode\BarcodeGeneratorSVG;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\StudentExport;
use App\Http\Controllers\BarcodeController;

class StudentController extends Controller
{
    public function export()
    {
        return Excel::download(new StudentExport, 'Students_data.xlsx');
    }

    public function index(Request $request)
    {
        $students = Student::all();
        $barcodeGenerator = new BarcodeGeneratorSVG();
        $search = $request->input('search');

        $students = Student::when($search, function ($query, $search) {
            return $query->where('id_number', 'LIKE', "%$search%");
        })->get();

        return view('student.index', compact('students', 'barcodeGenerator'));
    }

    public function create()
    {
        return view('student.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'middle_name' => 'required',
            'id_number' => 'required',
            'section' => 'required',
            'year_level' => 'required',
            'address' => 'required',
            'student_image' => 'required|image|mimes:jpeg,png,jpg,gif',
        ]);

        $student = new Student([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'middle_name' => $request->input('middle_name'),
            'id_number' => $request->input('id_number'),
            'section' => $request->input('section'),
            'year_level' => $request->input('year_level'),
            'address' => $request->input('address'),
        ]);

        if ($request->hasFile('student_image')) {
            $image = $request->file('student_image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);
            $student->student_image = $imageName;
        }

        $student->save();

        return redirect()->back()->with('success', 'Student information stored successfully.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'middle_name' => 'required',
            'id_number' => 'required',
            'section' => 'required',
            'year_level' => 'required',
            'address' => 'required',
            'student_image' => 'image|mimes:jpeg,png,jpg,gif',
        ]);

        $student = Student::findOrFail($id);
        $student->first_name = $request->input('first_name');
        $student->last_name = $request->input('last_name');
        $student->middle_name = $request->input('middle_name');
        $student->id_number = $request->input('id_number');
        $student->section = $request->input('section');
        $student->year_level = $request->input('year_level');
        $student->address = $request->input('address');

        if ($request->hasFile('student_image')) {
            $image = $request->file('student_image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);
            $student->student_image = $imageName;
        }

        $student->save();

        return redirect()->route('student.update')->with('success', 'Student record updated successfully.');
    }

    public function edit($id)
    {
        $student = Student::findOrFail($id);

        return view('student.edit', compact('student'));
    }

    public function destroy($id)
    {
        $student = Student::findOrFail($id);
        $student->delete();

        return redirect()->route('student.index')->with('success', 'Student record deleted successfully.');
    }
}
