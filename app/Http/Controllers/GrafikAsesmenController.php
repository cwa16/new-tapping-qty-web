<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GrafikAsesmenController extends Controller
{
    public function index(Request $request)
    {
        // Define division mapping
        $divisions = [
            '1' => ['A', 'B', 'C'],
            '2' => ['D', 'E', 'F']
        ];

        // Define all assessment items with their labels
        $items = [
            'item1_1' => '1.1 - Luka kayu kecil (BO) / Tidak Mengunakan Gagang Panjang (HO)',
            'item1_2' => '1.2 - Luka kayu sedang (BO)/Tidak Menggunakan Pisau sodhok(HO)',
            'item1_3' => '1.3 - Luka kayu besar (BO)/Sadapan Tidak Disodhok (HO)',
            'item2_1' => '2.1 - Kedalaman sadap (normatif)',
            'item2_2' => '2.2 - Kedalaman sadap (kurang)',
            'item2_3' => '2.3 - Kedalaman sadap (terlalu dalam)',
            'item3_1' => '3.1 - Irisan melampaui batas depan',
            'item3_2' => '3.2 - Irisan melampaui batas belakang',
            'item3_3' => '3.3 - Tidak ada sodokan',
            'item3_4' => '3.4 - Tidak ada pethikan (V)',
            'item3_5' => '3.5 - Tebal Tatal > 2mm (BO)/ >3mm(HO)',
            'item3_6' => '3.6 - Bergelombang',
            'item3_7' => '3.7 - Tidak ada tanda bulan',
            'item4_1' => '4.1 - Sudut sadap > 30°(BO)/45° (HO)',
            'item4_2' => '4.2 - Sudut sadap < 30°(BO)/45° (HO)',
            'item5_1' => '5.1 - Pengambilan scrap Diambil',
            'item5_2' => '5.2 - Pengambilan scrap Tidak Diambil',
            'item6_1' => '6.1 - Peralatan tidak lengkap Talang',
            'item6_2' => '6.2 - Peralatan tidak lengkap mangkok',
            'item6_3' => '6.3 - Peralatan tidak lengkap Hanger',
            'item7_1' => '7.1 - Kebersihan alat Talang',
            'item7_2' => '7.2 - Kebersihan alat Mangkok',
            'item7_3' => '7.3 - Kebersihan alat Ember',
            'item8' => '8 - Pohon sehat tidak disadap',
            'item9' => '9 - Hasil tidak dipungut',
            'item10' => '10 - Talang sadap mepet'
        ];

        // Define item labels for display (cleaner format)
        $itemLabels = [
            'item1_1' => '1.1',
            'item1_2' => '1.2',
            'item1_3' => '1.3',
            'item2_1' => '2.1',
            'item2_2' => '2.2',
            'item2_3' => '2.3',
            'item3_1' => '3.1',
            'item3_2' => '3.2',
            'item3_3' => '3.3',
            'item3_4' => '3.4',
            'item3_5' => '3.5',
            'item3_6' => '3.6',
            'item3_7' => '3.7',
            'item4_1' => '4.1',
            'item4_2' => '4.2',
            'item5_1' => '5.1',
            'item5_2' => '5.2',
            'item6_1' => '6.1',
            'item6_2' => '6.2',
            'item6_3' => '6.3',
            'item7_1' => '7.1',
            'item7_2' => '7.2',
            'item7_3' => '7.3',
            'item8' => '8',
            'item9' => '9',
            'item10' => '10'
        ];

        // Get the count of non-zero values for each item
        $itemCounts = [];
        foreach ($items as $itemColumn => $itemDescription) {
            // Build query with filters
            $query = DB::table('assessments')
                ->where($itemColumn, '>', 0);

            // Apply filters
            if ($request->filled('division') && $request->division !== '') {
                // Filter by division (which includes multiple departments)
                $divisionDepts = $divisions[$request->division] ?? [];
                if (!empty($divisionDepts)) {
                    $query->whereIn('dept', $divisionDepts);
                }
            } elseif ($request->filled('dept') && $request->dept !== '') {
                // Filter by specific department (only if no division filter)
                $query->where('dept', $request->dept);
            }

            if ($request->filled('panel_sadap') && $request->panel_sadap !== '') {
                $query->where('panel_sadap', $request->panel_sadap);
            }

            if ($request->filled('kemandoran') && $request->kemandoran !== '') {
                $query->where('kemandoran', 'LIKE', '%' . $request->kemandoran . '%');
            }

            // Date range filter
            if ($request->filled('date_from') && $request->date_from !== '') {
                $query->whereDate('tgl_inspeksi', '>=', $request->date_from);
            }

            if ($request->filled('date_to') && $request->date_to !== '') {
                $query->whereDate('tgl_inspeksi', '<=', $request->date_to);
            }

            // Status filter (FL/Reg)
            if ($request->filled('status') && $request->status !== '') {
                $query->where('status', $request->status);
            }

            $count = $query->count();

            $itemCounts[] = [
                'item' => $itemColumn,
                'label' => $itemLabels[$itemColumn],
                'description' => $itemDescription,
                'count' => $count
            ];
        }

        // Get filter options
        $departments = DB::table('assessments')
            ->select('dept')
            ->distinct()
            ->whereNotNull('dept')
            ->orderBy('dept')
            ->get();

        $panelSadaps = DB::table('assessments')
            ->select('panel_sadap')
            ->distinct()
            ->whereNotNull('panel_sadap')
            ->orderBy('panel_sadap')
            ->get();

        $kemandorans = DB::table('assessments')
            ->select('kemandoran')
            ->distinct()
            ->whereNotNull('kemandoran')
            ->orderBy('kemandoran')
            ->get();

        $statuses = DB::table('assessments')
            ->select('status')
            ->distinct()
            ->whereNotNull('status')
            ->orderBy('status')
            ->get();

        return view('grafik-asesmen.index', [
            'title' => 'Grafik Asesmen',
            'itemCounts' => $itemCounts,
            'items' => $items,
            'departments' => $departments,
            'panelSadaps' => $panelSadaps,
            'kemandorans' => $kemandorans,
            'statuses' => $statuses,
            'divisions' => $divisions,
            'filters' => $request->only(['division', 'dept', 'panel_sadap', 'kemandoran', 'date_from', 'date_to', 'status'])
        ]);
    }

    public function sumChart(Request $request)
    {
        // Define division mapping
        $divisions = [
            '1' => ['A', 'B', 'C'],
            '2' => ['D', 'E', 'F']
        ];

        // Define all assessment items with their labels
        $items = [
            'item1_1' => '1.1 - Luka kayu kecil (BO) / Tidak Mengunakan Gagang Panjang (HO)',
            'item1_2' => '1.2 - Luka kayu sedang (BO)/Tidak Menggunakan Pisau sodhok(HO)',
            'item1_3' => '1.3 - Luka kayu besar (BO)/Sadapan Tidak Disodhok (HO)',
            'item2_1' => '2.1 - Kedalaman sadap (normatif)',
            'item2_2' => '2.2 - Kedalaman sadap (kurang)',
            'item2_3' => '2.3 - Kedalaman sadap (terlalu dalam)',
            'item3_1' => '3.1 - Irisan melampaui batas depan',
            'item3_2' => '3.2 - Irisan melampaui batas belakang',
            'item3_3' => '3.3 - Tidak ada sodokan',
            'item3_4' => '3.4 - Tidak ada pethikan (V)',
            'item3_5' => '3.5 - Tebal Tatal > 2mm (BO)/ >3mm(HO)',
            'item3_6' => '3.6 - Bergelombang',
            'item3_7' => '3.7 - Tidak ada tanda bulan',
            'item4_1' => '4.1 - Sudut sadap > 30°(BO)/45° (HO)',
            'item4_2' => '4.2 - Sudut sadap < 30°(BO)/45° (HO)',
            'item5_1' => '5.1 - Pengambilan scrap Diambil',
            'item5_2' => '5.2 - Pengambilan scrap Tidak Diambil',
            'item6_1' => '6.1 - Peralatan tidak lengkap Talang',
            'item6_2' => '6.2 - Peralatan tidak lengkap mangkok',
            'item6_3' => '6.3 - Peralatan tidak lengkap Hanger',
            'item7_1' => '7.1 - Kebersihan alat Talang',
            'item7_2' => '7.2 - Kebersihan alat Mangkok',
            'item7_3' => '7.3 - Kebersihan alat Ember',
            'item8' => '8 - Pohon sehat tidak disadap',
            'item9' => '9 - Hasil tidak dipungut',
            'item10' => '10 - Talang sadap mepet'
        ];

        // Define item labels for display (cleaner format)
        $itemLabels = [
            'item1_1' => '1.1',
            'item1_2' => '1.2',
            'item1_3' => '1.3',
            'item2_1' => '2.1',
            'item2_2' => '2.2',
            'item2_3' => '2.3',
            'item3_1' => '3.1',
            'item3_2' => '3.2',
            'item3_3' => '3.3',
            'item3_4' => '3.4',
            'item3_5' => '3.5',
            'item3_6' => '3.6',
            'item3_7' => '3.7',
            'item4_1' => '4.1',
            'item4_2' => '4.2',
            'item5_1' => '5.1',
            'item5_2' => '5.2',
            'item6_1' => '6.1',
            'item6_2' => '6.2',
            'item6_3' => '6.3',
            'item7_1' => '7.1',
            'item7_2' => '7.2',
            'item7_3' => '7.3',
            'item8' => '8',
            'item9' => '9',
            'item10' => '10'
        ];

        // Get the sum of values for each item (instead of count)
        $itemSums = [];
        foreach ($items as $itemColumn => $itemDescription) {
            // Build query with filters
            $query = DB::table('assessments');

            // Apply filters
            if ($request->filled('division') && $request->division !== '') {
                // Filter by division (which includes multiple departments)
                $divisionDepts = $divisions[$request->division] ?? [];
                if (!empty($divisionDepts)) {
                    $query->whereIn('dept', $divisionDepts);
                }
            } elseif ($request->filled('dept') && $request->dept !== '') {
                // Filter by specific department (only if no division filter)
                $query->where('dept', $request->dept);
            }

            if ($request->filled('panel_sadap') && $request->panel_sadap !== '') {
                $query->where('panel_sadap', $request->panel_sadap);
            }

            if ($request->filled('kemandoran') && $request->kemandoran !== '') {
                $query->where('kemandoran', 'LIKE', '%' . $request->kemandoran . '%');
            }

            // Date range filter
            if ($request->filled('date_from') && $request->date_from !== '') {
                $query->whereDate('tgl_inspeksi', '>=', $request->date_from);
            }

            if ($request->filled('date_to') && $request->date_to !== '') {
                $query->whereDate('tgl_inspeksi', '<=', $request->date_to);
            }

            // Status filter (FL/Reg)
            if ($request->filled('status') && $request->status !== '') {
                $query->where('status', $request->status);
            }

            // Calculate sum instead of count
            $sum = $query->average($itemColumn) ?? 0;

            $itemSums[] = [
                'item' => $itemColumn,
                'label' => $itemLabels[$itemColumn],
                'description' => $itemDescription,
                'sum' => $sum
            ];
        }

        // Get filter options
        $departments = DB::table('assessments')
            ->select('dept')
            ->distinct()
            ->whereNotNull('dept')
            ->orderBy('dept')
            ->get();

        $panelSadaps = DB::table('assessments')
            ->select('panel_sadap')
            ->distinct()
            ->whereNotNull('panel_sadap')
            ->orderBy('panel_sadap')
            ->get();

        $kemandorans = DB::table('assessments')
            ->select('kemandoran')
            ->distinct()
            ->whereNotNull('kemandoran')
            ->orderBy('kemandoran')
            ->get();

        $statuses = DB::table('assessments')
            ->select('status')
            ->distinct()
            ->whereNotNull('status')
            ->orderBy('status')
            ->get();

        return view('grafik-asesmen.sum-chart', [
            'title' => 'Grafik Asesmen - Sum Chart',
            'itemSums' => $itemSums,
            'items' => $items,
            'departments' => $departments,
            'panelSadaps' => $panelSadaps,
            'kemandorans' => $kemandorans,
            'statuses' => $statuses,
            'divisions' => $divisions,
            'filters' => $request->only(['division', 'dept', 'panel_sadap', 'kemandoran', 'date_from', 'date_to', 'status'])
        ]);
    }
}
