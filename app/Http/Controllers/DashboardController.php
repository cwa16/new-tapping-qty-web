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

        // dd($highestAssessmentScoreLastWeek);

        return view('dashboard.index', [
            'title' => 'Dashboard',
            'tapperCount' => $tapperCount,
            'thisMonthAssessments' => $thisMonthAssessments,
            'highestAssessmentScoreThisMonth' => $highestAssessmentScoreThisMonth
        ]);
    }
}
