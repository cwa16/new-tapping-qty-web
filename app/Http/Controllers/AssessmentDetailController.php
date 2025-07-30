<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AssessmentDetailController extends Controller
{
    public function index(Request $request)
    {
        // Get filter values
        $filters = $request->only(['kemandoran', 'panel_sadap', 'dept', 'date_from', 'date_to']);

        // Get all assessment data grouped by kemandoran, panel_sadap, and individual kelas values
        $summaryByKemandoranPanel = [];

        // Build base query with filters
        $baseQuery = DB::table('assessments');

        // Apply filters if provided
        if (!empty($filters['kemandoran'])) {
            $baseQuery->where('kemandoran', 'LIKE', '%' . $filters['kemandoran'] . '%');
        }

        if (!empty($filters['panel_sadap'])) {
            $baseQuery->where('panel_sadap', $filters['panel_sadap']);
        }

        if (!empty($filters['dept'])) {
            $baseQuery->where('dept', $filters['dept']);
        }

        // Date range filter
        if ($request->filled('date_from') && $request->date_from !== '') {
            $baseQuery->whereDate('tgl_inspeksi', '>=', $request->date_from);
        }

        if ($request->filled('date_to') && $request->date_to !== '') {
            $baseQuery->whereDate('tgl_inspeksi', '<=', $request->date_to);
        }

        // dd($baseQuery->toSql());
        // Get data for kelas perawan (1, 2, 3, 4, NC)
        $kelasPerawanData = (clone $baseQuery)
            ->select('kemandoran', 'panel_sadap', 'dept', 'kelas_perawan', DB::raw('COUNT(*) AS penyadap'))
            ->whereNotNull('kelas_perawan')
            ->where('kelas_perawan', '!=', '')
            ->groupBy('kemandoran', 'panel_sadap', 'dept', 'kelas_perawan')
            ->get();

        // Get data for kelas pulihan (1, 2, 3, 4, NC)
        $kelasPulihanData = (clone $baseQuery)
            ->select('kemandoran', 'panel_sadap', 'dept', 'kelas_pulihan', DB::raw('COUNT(*) AS penyadap'))
            ->whereNotNull('kelas_pulihan')
            ->where('kelas_pulihan', '!=', '')
            ->groupBy('kemandoran', 'panel_sadap', 'dept', 'kelas_pulihan')
            ->get();

        // Get data for kelas nta (1, 2, 3, 4, NC)
        $kelasNtaData = (clone $baseQuery)
            ->select('kemandoran', 'panel_sadap', 'dept', 'kelas_nta', DB::raw('COUNT(*) AS penyadap'))
            ->whereNotNull('kelas_nta')
            ->where('kelas_nta', '!=', '')
            ->groupBy('kemandoran', 'panel_sadap', 'dept', 'kelas_nta')
            ->get();

        // Process kelas perawan data - group by individual kelas values
        foreach ($kelasPerawanData as $item) {
            // Normalize case only for kemandoran, keep panel_sadap as-is
            $normalizedKemandoran = trim(ucwords(strtolower($item->kemandoran)));

            $key = $normalizedKemandoran . ' - ' . $item->panel_sadap;
            $summaryByKemandoranPanel[$key]['kemandoran'] = $normalizedKemandoran;
            $summaryByKemandoranPanel[$key]['panel_sadap'] = $item->panel_sadap;
            $summaryByKemandoranPanel[$key]['dept'] = $item->dept;

            // Store as "perawan_1", "perawan_2", etc.
            $kelasKey = 'perawan_' . $item->kelas_perawan;
            $summaryByKemandoranPanel[$key][$kelasKey] = ($summaryByKemandoranPanel[$key][$kelasKey] ?? 0) + $item->penyadap;
        }

        // Process kelas pulihan data - group by individual kelas values
        foreach ($kelasPulihanData as $item) {
            // Normalize case only for kemandoran, keep panel_sadap as-is
            $normalizedKemandoran = trim(ucwords(strtolower($item->kemandoran)));

            $key = $normalizedKemandoran . ' - ' . $item->panel_sadap;
            $summaryByKemandoranPanel[$key]['kemandoran'] = $normalizedKemandoran;
            $summaryByKemandoranPanel[$key]['panel_sadap'] = $item->panel_sadap;
            $summaryByKemandoranPanel[$key]['dept'] = $item->dept;

            // Store as "pulihan_1", "pulihan_2", etc.
            $kelasKey = 'pulihan_' . $item->kelas_pulihan;
            $summaryByKemandoranPanel[$key][$kelasKey] = ($summaryByKemandoranPanel[$key][$kelasKey] ?? 0) + $item->penyadap;
        }

        // Process kelas nta data - group by individual kelas values
        foreach ($kelasNtaData as $item) {
            // Normalize case only for kemandoran, keep panel_sadap as-is
            $normalizedKemandoran = trim(ucwords(strtolower($item->kemandoran)));

            $key = $normalizedKemandoran . ' - ' . $item->panel_sadap;
            $summaryByKemandoranPanel[$key]['kemandoran'] = $normalizedKemandoran;
            $summaryByKemandoranPanel[$key]['panel_sadap'] = $item->panel_sadap;
            $summaryByKemandoranPanel[$key]['dept'] = $item->dept;

            // Store as "nta_1", "nta_2", etc.
            $kelasKey = 'nta_' . $item->kelas_nta;
            $summaryByKemandoranPanel[$key][$kelasKey] = ($summaryByKemandoranPanel[$key][$kelasKey] ?? 0) + $item->penyadap;
        }

        // Calculate totals for each kemandoran-panel combination
        foreach ($summaryByKemandoranPanel as $key => &$data) {
            $data['grand_total'] = 0;

            // Sum all individual kelas counts
            foreach (
                [
                    'perawan_1',
                    'perawan_2',
                    'perawan_3',
                    'perawan_4',
                    'perawan_NC',
                    'pulihan_1',
                    'pulihan_2',
                    'pulihan_3',
                    'pulihan_4',
                    'pulihan_NC',
                    'nta_1',
                    'nta_2',
                    'nta_3',
                    'nta_4',
                    'nta_NC'
                ] as $kelasKey
            ) {
                if (isset($data[$kelasKey])) {
                    $data['grand_total'] += $data[$kelasKey];
                }
            }
        }

        // Sort by kemandoran then by panel_sadap
        ksort($summaryByKemandoranPanel);

        // Uncomment the line below to see the data structure
        // dd($summaryByKemandoranPanel);

        $departments = DB::table('assessments')
            ->select('dept')
            ->distinct()
            ->orderBy('dept')
            ->get();

        $bloks = DB::table('assessments')
            ->select('blok')
            ->distinct()
            ->orderBy('blok')
            ->get();

        $kemandoran = DB::table('assessments')
            ->select('kemandoran')
            ->distinct()
            ->orderBy('kemandoran')
            ->get();

        $panelSadap = DB::table('assessments')
            ->select('panel_sadap')
            ->distinct()
            ->orderBy('panel_sadap')
            ->get();

        return view('assessment-details.index', [
            'title' => 'Assessment Details',
            'summaryByKemandoranPanel' => $summaryByKemandoranPanel,
            'kelasPerawanData' => $kelasPerawanData,
            'kelasPulihanData' => $kelasPulihanData,
            'kelasNtaData' => $kelasNtaData,
            'departments' => $departments,
            'bloks' => $bloks,
            'kemandoran' => $kemandoran,
            'panelSadap' => $panelSadap,
            'filters' => $filters
        ]);
    }

    public function detail(Request $request)
    {
        $kemandoran = $request->get('kemandoran');
        $panelSadap = $request->get('panel_sadap');
        $kelasType = $request->get('kelas_type'); // perawan, pulihan, nta
        $kelasValue = $request->get('kelas_value'); // 1, 2, 3, 4, NC
        $dateFrom = $request->get('date_from');
        $dateTo = $request->get('date_to');

        // Normalize kemandoran for consistent filtering
        $normalizedKemandoran = trim(ucwords(strtolower($kemandoran)));

        // Build the query based on kelas type
        $query = DB::table('assessments')
            ->where('kemandoran', 'LIKE', '%' . $kemandoran . '%')
            ->where('panel_sadap', $panelSadap);

        if ($dateFrom) {
            $query->whereDate('tgl_inspeksi', '>=', $dateFrom);
        }
        if ($dateTo) {
            $query->whereDate('tgl_inspeksi', '<=', $dateTo);
        }

        // Date range filter
        // if ($request->filled('date_from') && $request->date_from !== '') {
        //     $query->whereDate('tgl_inspeksi', '>=', $request->date_from);
        // }

        // if ($request->filled('date_to') && $request->date_to !== '') {
        //     $query->whereDate('tgl_inspeksi', '<=', $request->date_to);
        // }

        // Add the specific kelas filter
        switch ($kelasType) {
            case 'perawan':
                $query->where('kelas_perawan', $kelasValue);
                break;
            case 'pulihan':
                $query->where('kelas_pulihan', $kelasValue);
                break;
            case 'nta':
                $query->where('kelas_nta', $kelasValue);
                break;
        }

        $assessments = $query->orderBy('tgl_inspeksi', 'desc')->get();
        // dd($assessments);
        // dd($kelasValue);

        return view('assessment-details.detail', [
            'title' => 'Assessment Detail - ' . ucfirst($kelasType) . ' Kelas ' . $kelasValue,
            'assessments' => $assessments,
            'kemandoran' => $normalizedKemandoran,
            'panel_sadap' => $panelSadap,
            'kelas_type' => $kelasType,
            'kelas_value' => $kelasValue,
        ]);
    }
}
