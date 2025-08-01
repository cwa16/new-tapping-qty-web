<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Exception;

class AssessmentApiController extends Controller
{
    public function store(Request $request)
    {
        try {
            // // Validate the incoming request
            // $validator = Validator::make($request->all(), [
            //     'tgl_inspeksi' => 'required|date',
            //     'dept' => 'required|string|max:255',
            //     'nama_inspektur' => 'required|string|max:255',
            //     'nik_penyadap' => 'required|string|max:255',
            //     'nama_penyadap' => 'required|string|max:255',
            //     'status' => 'required|string|max:255',
            //     'kemandoran' => 'required|string|max:255',
            //     'blok' => 'required|string|max:255',
            //     'task' => 'required|string|max:255',
            //     'tahun_tanam' => 'required|integer',
            //     'clone' => 'required|string|max:255',
            //     'panel_sadap' => 'required|string|max:255',
            //     'jenis_kulit_pohon' => 'required|string|max:255',
            //     // Item scores - all optional as they depend on criteria
            //     'item1_1' => 'nullable|numeric',
            //     'item1_2' => 'nullable|numeric',
            //     'item1_3' => 'nullable|numeric',
            //     'item2_1' => 'nullable|numeric',
            //     'item2_2' => 'nullable|numeric',
            //     'item2_3' => 'nullable|numeric',
            //     'item3_1' => 'nullable|numeric',
            //     'item3_2' => 'nullable|numeric',
            //     'item3_3' => 'nullable|numeric',
            //     'item3_4' => 'nullable|numeric',
            //     'item3_5' => 'nullable|numeric',
            //     'item3_6' => 'nullable|numeric',
            //     'item3_7' => 'nullable|numeric',
            //     'item4_1' => 'nullable|numeric',
            //     'item4_2' => 'nullable|numeric',
            //     'item5_1' => 'nullable|numeric',
            //     'item5_2' => 'nullable|numeric',
            //     'item6_1' => 'nullable|numeric',
            //     'item6_2' => 'nullable|numeric',
            //     'item6_3' => 'nullable|numeric',
            //     'item7_1' => 'nullable|numeric',
            //     'item7_2' => 'nullable|numeric',
            //     'item7_3' => 'nullable|numeric',
            //     'item8' => 'nullable|numeric',
            //     'item9' => 'nullable|numeric',
            //     'item10' => 'nullable|numeric',
            // ]);

            // if ($validator->fails()) {
            //     return response()->json([
            //         'success' => false,
            //         'message' => 'Validation failed',
            //         'errors' => $validator->errors()
            //     ], 422);
            // }

            // Prepare data for insertion
            $assessmentData = $request->all();

            // Convert date format if needed
            $assessmentData['tgl_inspeksi'] = date('Y-m-d', strtotime($request->tgl_inspeksi));

            // Calculate total score
            $totalScore = 0;
            $itemColumns = [
                'item1_1',
                'item1_2',
                'item1_3',
                'item2_1',
                'item2_2',
                'item2_3',
                'item3_1',
                'item3_2',
                'item3_3',
                'item3_4',
                'item3_5',
                'item3_6',
                'item3_7',
                'item4_1',
                'item4_2',
                'item5_1',
                'item5_2',
                'item6_1',
                'item6_2',
                'item6_3',
                'item7_1',
                'item7_2',
                'item7_3',
                'item8',
                'item9',
                'item10'
            ];

            foreach ($itemColumns as $column) {
                if (isset($assessmentData[$column]) && is_numeric($assessmentData[$column])) {
                    $totalScore += (float) $assessmentData[$column];
                }
            }

            $assessmentData['total_score'] = $totalScore;

            // Add timestamps
            $assessmentData['created_at'] = now();
            $assessmentData['updated_at'] = now();

            // Insert into database
            $assessmentId = DB::table('assessments')->insertGetId($assessmentData);

            return response()->json([
                'success' => true,
                'message' => 'Assessment created successfully',
                'data' => [
                    'id' => $assessmentId,
                    'nilai' => $totalScore,
                    'tgl_inspeksi' => $assessmentData['tgl_inspeksi'],
                    'nik_penyadap' => $assessmentData['nik_penyadap'],
                    'nama_penyadap' => $assessmentData['nama_penyadap']
                ]
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create assessment',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function index(Request $request)
    {
        try {
            $query = DB::table('assessments');

            // Add filters if provided
            if ($request->filled('nik_penyadap')) {
                $query->where('nik_penyadap', $request->nik_penyadap);
            }

            if ($request->filled('dept')) {
                $query->where('dept', $request->dept);
            }

            if ($request->filled('date_from')) {
                $query->whereDate('tgl_inspeksi', '>=', $request->date_from);
            }

            if ($request->filled('date_to')) {
                $query->whereDate('tgl_inspeksi', '<=', $request->date_to);
            }

            $assessments = $query->orderBy('tgl_inspeksi', 'desc')
                ->paginate(20);

            return response()->json([
                'success' => true,
                'data' => $assessments
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch assessments',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $assessment = DB::table('assessments')->where('id', $id)->first();

            if (!$assessment) {
                return response()->json([
                    'success' => false,
                    'message' => 'Assessment not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $assessment
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch assessment',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
