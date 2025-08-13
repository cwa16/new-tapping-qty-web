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
                'assessment_counts.last_assessment',
            ])
            ->where('tappers.is_active', true);

        // Apply filters
        if (! empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('tappers.name', 'LIKE', '%' . $filters['search'] . '%')
                    ->orWhere('tappers.nik', 'LIKE', '%' . $filters['search'] . '%');
            });
        }

        if (! empty($filters['departemen'])) {
            $query->where('tappers.departemen', $filters['departemen']);
        }

        if (! empty($filters['kemandoran'])) {
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
            'title'       => 'Tapper Report',
            'tappers'     => $tappers,
            'departments' => $departments,
            // 'kemandorans' => $kemandorans,
            'filters'     => $filters,
        ]);
    }

    public function detail(Request $request, $nik)
    {
        // Get tapper info from assessments table
        $tapperInfo = DB::table('assessments')
            ->where('nik_penyadap', $nik)
        // ->where('is_active', true)
            ->first();

        if (! $tapperInfo) {
            return view('components.404-page');
            // abort(404, 'Tapper not found');
        }

        // Build query for assessment history using nik_penyadap from assessments table
        $query = DB::table('assessments')
            ->where('nik_penyadap', $nik);

        $assessments = $query->orderBy('tgl_inspeksi', 'desc')->paginate(10);

        // Get chart data for score history (all assessments for chart)
        $chartDataQuery = DB::table('assessments')
            ->select(['tgl_inspeksi', 'nilai', 'kelas_perawan', 'kelas_pulihan', 'kelas_nta'])
            ->where('nik_penyadap', $nik)
            ->whereNotNull('nilai')
            ->orderBy('tgl_inspeksi', 'asc');

        $chartDataQueryRank = DB::table('assessments')
            ->selectRaw("
                COUNT(CASE WHEN kelas_perawan = 1 THEN 1 END) as kelas_perawan_rank1,
                COUNT(CASE WHEN kelas_perawan = 2 THEN 1 END) as kelas_perawan_rank2,
                COUNT(CASE WHEN kelas_perawan = 3 THEN 1 END) as kelas_perawan_rank3,

                COUNT(CASE WHEN kelas_pulihan = 1 THEN 1 END) as kelas_pulihan_rank1,
                COUNT(CASE WHEN kelas_pulihan = 2 THEN 1 END) as kelas_pulihan_rank2,
                COUNT(CASE WHEN kelas_pulihan = 3 THEN 1 END) as kelas_pulihan_rank3,

                COUNT(CASE WHEN kelas_nta = 1 THEN 1 END) as kelas_nta_rank1,
                COUNT(CASE WHEN kelas_nta = 2 THEN 1 END) as kelas_nta_rank2,
                COUNT(CASE WHEN kelas_nta = 3 THEN 1 END) as kelas_nta_rank3
            ")
            ->where('nik_penyadap', $nik)->first();

        if ($request->filled('date_from')) {
            $chartDataQuery->whereDate('tgl_inspeksi', '>=', $request->input('date_from'));
        }

        if ($request->filled('date_to')) {
            $chartDataQuery->whereDate('tgl_inspeksi', '<=', $request->input('date_to'));
        }

        $chartData = $chartDataQuery->get()
            ->map(function ($item) {
                return [
                    'date'          => $item->tgl_inspeksi,
                    'score'         => (float) $item->nilai,
                    'kelas_perawan' => (int) $item->kelas_perawan,
                ];
            });

        return view('tapper-report.detail', [
            'title'              => 'Assessment History - ' . $tapperInfo->nama_penyadap,
            'tapperInfo'         => $tapperInfo,
            'assessments'        => $assessments,
            'chartData'          => $chartData,
            'chartDataQueryRank' => $chartDataQueryRank,
            'filters'            => $request->only(['date_from', 'date_to']),
        ]);
    }

    public function chart(Request $request, $nik)
    {
        $title = 'Tapper Report Chart - ' . $nik;

        // Define division mapping
        $divisions = [
            '1' => ['A', 'B', 'C'],
            '2' => ['D', 'E', 'F'],
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
            'item8'   => '8 - Pohon sehat tidak disadap',
            'item9'   => '9 - Hasil tidak dipungut',
            'item10'  => '10 - Talang sadap mepet',
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
            'item8'   => '8',
            'item9'   => '9',
            'item10'  => '10',
        ];

        // Get the sum of values for each item (instead of count)
        $itemSums = [];
        foreach ($items as $itemColumn => $itemDescription) {
            // Build query with filters
            $query = DB::table('assessments')->where('nik_penyadap', $nik);

            // Calculate sum instead of count
            $sum = $query->average($itemColumn) ?? 0;

            $itemSums[] = [
                'item'        => $itemColumn,
                'label'       => $itemLabels[$itemColumn],
                'description' => $itemDescription,
                'sum'         => $sum,
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

        // Get tapper info from assessments table
        $tapperInfo = DB::table('assessments')
            ->where('nik_penyadap', $nik)
        // ->where('is_active', true)
            ->first();

        return view('tapper-report.chart', [
            'title'      => $title,
            'nik'        => $nik,
            'tapperInfo' => $tapperInfo,
            'itemSums'   => $itemSums,
            'filters'    => $request->only(['date_from', 'date_to']),
        ]);
    }

    public function single_chart(Request $request, $nik, $tgl)
    {
        $title = 'Tapper Report Chart - ' . $nik;

        // Define division mapping
        $divisions = [
            '1' => ['A', 'B', 'C'],
            '2' => ['D', 'E', 'F'],
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
            'item8'   => '8 - Pohon sehat tidak disadap',
            'item9'   => '9 - Hasil tidak dipungut',
            'item10'  => '10 - Talang sadap mepet',
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
            'item8'   => '8',
            'item9'   => '9',
            'item10'  => '10',
        ];

        // Get the sum of values for each item (instead of count)
        $itemSums = [];
        foreach ($items as $itemColumn => $itemDescription) {
            // Build query with filters
            $query = DB::table('assessments')->where('nik_penyadap', $nik)->where('tgl_inspeksi', $tgl);

            // Calculate sum instead of count
            $sum = $query->average($itemColumn) ?? 0;

            $itemSums[] = [
                'item'        => $itemColumn,
                'label'       => $itemLabels[$itemColumn],
                'description' => $itemDescription,
                'sum'         => $sum,
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

        // Get tapper info from assessments table
        $tapperInfo = DB::table('assessments')
            ->where('nik_penyadap', $nik)
        // ->where('is_active', true)
            ->first();

        return view('tapper-report.chart', [
            'title'    => $title,
            'nik'      => $nik,
            'tapperInfo' => $tapperInfo,
            'itemSums' => $itemSums,
            'filters'  => $request->only(['date_from', 'date_to']),
        ]);
    }
}
