<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use App\Models\Scan;
use Carbon\Carbon;

class BarcodeController extends Controller
{
    public function index()
    {
        $scans = Scan::orderBy('created_at', 'asc')->get();

        $formattedScans = $scans->map(function ($scan) {
            $date = Carbon::parse($scan->date)->format('F j, Y');
            $time = Carbon::parse($scan->time)->format('h:i A');

            // Retrieve the corresponding student based on the barcode
            $student = Student::where('id_number', $scan->barcode)->first();

            // Retrieve the student information if it exists
            $firstName = $student ? $student->first_name : '-';
            $lastName = $student ? $student->last_name : '-';
            $section = $student ? $student->section : '-';
            $yearLevel = $student ? $student->year_level : '-';
            $address = $student ? $student->address : '-';
            $studentImage = $student ? $student->student_image : null;

            return [
                'barcode' => $scan->barcode,
                'date' => $date,
                'time' => $time,
                'firstName' => $firstName,
                'lastName' => $lastName,
                'section' => $section,
                'yearLevel' => $yearLevel,
                'address' => $address,
                'studentImage' => $studentImage,
            ];
        });

        return view('scan-form', ['scans' => $formattedScans]);
    }
    public function todaysResult()
    {
        // Replace this with your actual data retrieval logic for today's results
        $scans = Scan::orderBy('created_at', 'asc')->get();

        $formattedScans = $scans->map(function ($scan) {
            $date = Carbon::parse($scan->date)->format('F j, Y');
            $time = Carbon::parse($scan->time)->format('h:i A');

            // Retrieve the corresponding student based on the barcode
            $student = Student::where('id_number', $scan->barcode)->first();

            // Retrieve the student information if it exists
            $firstName = $student ? $student->first_name : '-';
            $lastName = $student ? $student->last_name : '-';
            $section = $student ? $student->section : '-';
            $yearLevel = $student ? $student->year_level : '-';
            $address = $student ? $student->address : '-';
            $studentImage = $student ? $student->student_image : null;

            return [
                'barcode' => $scan->barcode,
                'date' => $date,
                'time' => $time,
                'firstName' => $firstName,
                'lastName' => $lastName,
                'section' => $section,
                'yearLevel' => $yearLevel,
                'address' => $address,
                'studentImage' => $studentImage,
            ];
        });
       
        return view('result-today', ['scans' => $formattedScans]);
    }

    public function scan(Request $request)
    {
        $validatedData = $request->validate([
            'barcode' => 'required|string|max:255',
        ]);

        $barcode = $validatedData['barcode'];

        $student = Student::where('id_number', $barcode)->first();

        if ($student) {
            $scan = new Scan();
            $scan->barcode = $barcode;
            $scan->date = now()->toDateString();
            $scan->time = now()->toTimeString();
            $scan->save();

            $message = 'Scan success!';

            return redirect()->back()->with('scan_success', $message);
        }

        $message = 'Invalid barcode or unregistered student!';

        return redirect()->back()->withErrors([
            'barcode' => $message,
        ]);
    }
}
