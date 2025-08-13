<?php
namespace App\Http\Controllers;

use App\Imports\AssessmentImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class AssessmentController extends Controller
{
    public function import(Request $request)
    {
        // Validasi file yang diupload
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048',
        ]);

        // Proses import menggunakan Maatwebsite Excel
        try {
            Excel::import(new AssessmentImport, $request->file('file'));

            return redirect()->back()->with('success', 'Data assessments berhasil diimpor.');
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $errors = [];

            foreach ($e->failures() as $failure) {
                $errors[] = [
                    'row'    => $failure->row(),
                    'column' => $failure->attribute(),
                    'errors' => $failure->errors(),
                ];
            }

            return response()->json(['status' => 'error', 'data' => $errors]);
        }
    }

    public function downloadTemplate()
    {
        $path = public_path('assets/template.xlsx');
        return response()->download($path, 'Format_Assessment.xlsx');
    }
}
