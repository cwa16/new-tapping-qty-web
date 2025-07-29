<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TapperReportController extends Controller
{
    public function index(Request $request)
    {
        // Get filter values
        $filters = $request->only(['search', 'departemen', 'kemandoran']);

        // Get tappers from tappers table with assessment counts
        $query = DB::table('tappers')
            ->leftJoin(DB::raw('(SELECT nik_penyadap, COUNT(*) as total_assessments, MAX(tgl_inspeksi) as last_assessment FROM assessments GROUP BY nik_penyadap) as assessment_counts'), 'tappers.nik', '=', 'assessment_counts.nik_penyadap')
            ->select([
                'tappers.nik',
                'tappers.name',
                'tappers.departemen',
                'tappers.kemandoran',
                'tappers.jabatan',
                'tappers.status',
                'tappers.is_active',
                DB::raw('COALESCE(assessment_counts.total_assessments, 0) as total_assessments'),
                'assessment_counts.last_assessment'
            ])
            ->where('tappers.is_active', true);

        // Apply filters
        if (!empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('tappers.name', 'LIKE', '%' . $filters['search'] . '%')
                    ->orWhere('tappers.nik', 'LIKE', '%' . $filters['search'] . '%');
            });
        }

        if (!empty($filters['departemen'])) {
            $query->where('tappers.departemen', $filters['departemen']);
        }

        if (!empty($filters['kemandoran'])) {
            $query->where('tappers.kemandoran', 'LIKE', '%' . $filters['kemandoran'] . '%');
        }

        $tappers = $query->orderBy('tappers.name')
            ->paginate(15);

        // Get filter options from tappers table
        $departments = DB::table('tappers')
            ->select('departemen')
            ->distinct()
            ->whereNotNull('departemen')
            ->where('is_active', true)
            ->orderBy('departemen')
            ->get();

        // $kemandorans = DB::table('tappers')
        //     ->select('kemandoran')
        //     ->distinct()
        //     ->whereNotNull('kemandoran')
        //     ->where('is_active', true)
        //     ->orderBy('kemandoran')
        //     ->get();

        return view('tapper-report.index', [
            'title' => 'Tapper Report',
            'tappers' => $tappers,
            'departments' => $departments,
            // 'kemandorans' => $kemandorans,
            'filters' => $filters
        ]);
    }

    public function detail(Request $request, $nik)
    {
        // Get tapper info from assessments table
        $tapperInfo = DB::table('assessments')
            ->where('nik_penyadap', $nik)
            // ->where('is_active', true)
            ->first();

        if (!$tapperInfo) {
            abort(404, 'Tapper not found');
        }

        // Build query for assessment history using nik_penyadap from assessments table
        $query = DB::table('assessments')
            ->where('nik_penyadap', $nik);

        $assessments = $query->orderBy('tgl_inspeksi', 'desc')->paginate(10);

        // Get chart data for score history (all assessments for chart)
        $chartData = DB::table('assessments')
            ->select(['tgl_inspeksi', 'nilai'])
            ->where('nik_penyadap', $nik)
            ->whereNotNull('nilai')
            ->orderBy('tgl_inspeksi', 'asc')
            ->get()
            ->map(function ($item) {
                return [
                    'date' => $item->tgl_inspeksi,
                    'score' => (float) $item->nilai
                ];
            });

        return view('tapper-report.detail', [
            'title' => 'Assessment History - ' . $tapperInfo->nama_penyadap,
            'tapperInfo' => $tapperInfo,
            'assessments' => $assessments,
            'chartData' => $chartData,
            'filters' => $request->only(['date_from', 'date_to'])
        ]);
    }
}
