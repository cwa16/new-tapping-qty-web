<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Show the dashboard view.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $tapperCount = DB::table('tappers')
            ->where('is_active', true)
            ->count();

        $thisMonthAssessments = DB::table('assessments')
            ->whereBetween('tgl_inspeksi', [now()->startOfMonth(), now()->endOfMonth()])
            ->count();

        $highestAssessmentScoreThisMonth = DB::table('assessments')
            ->whereBetween('tgl_inspeksi', [now()->startOfMonth(), now()->endOfMonth()])
            ->max('nilai');

         // Mendefinisikan semua sub divisi yang akan ditampilkan.
        $subDivisions = ['A', 'B', 'C', 'D', 'E', 'F'];
        $tappingClassesData = [];

        foreach ($subDivisions as $subDiv) {
            // Mengambil data untuk setiap sub divisi.
            // Sesuaikan kolom 'dept' atau 'kemandoran' jika perlu.
            $dataForSubDiv =  DB::table('assessments')->where('dept', $subDiv)
                // ->whereBetween('tgl_inspeksi', [now()->startOfMonth(), now()->endOfMonth()])
                ->get();

            // Mengelompokkan data berdasarkan 'kelas_perawan', 'kelas_pulihan', dsb.
            $groupedData = [
                'Class 1' => $dataForSubDiv->where('kelas_perawan', '1'),
                'Class 2' => $dataForSubDiv->where('kelas_pulihan', '2'),
                'Class 3' => $dataForSubDiv->where('kelas_nta', '3'),
                'Class 4' => $dataForSubDiv->where('kelas_nta', '4'),
                'Non'     => $dataForSubDiv->whereNull('kelas_perawan')
                                        ->whereNull('kelas_pulihan')
                                        ->whereNull('kelas_nta')
            ];

            $tappingClassesData['Sub Div ' . $subDiv] = $groupedData;
        }

        return view('dashboard.index', [
            'title' => 'Dashboard',
            'tapperCount' => $tapperCount,
            'thisMonthAssessments' => $thisMonthAssessments,
            'highestAssessmentScoreThisMonth' => $highestAssessmentScoreThisMonth,
            'allData' => $tappingClassesData
        ]);
    }
}
