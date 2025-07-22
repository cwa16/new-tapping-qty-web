<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AssessmentDetailController extends Controller
{
    public function index()
    {
        $class1 = DB::table('assessments')
            ->select('kemandoran', 'panel_sadap', DB::raw('COUNT(*) AS penyadap'))
            ->where('nilai', '>=', 0)
            ->where('nilai', '<=', 10.9)
            ->groupBy('kemandoran', 'panel_sadap')
            ->get();
        $class2 = DB::table('assessments')
            ->select('kemandoran', 'panel_sadap', DB::raw('COUNT(*) AS penyadap'))
            ->where('nilai', '>', 10.9)
            ->where('nilai', '<=', 20.9)
            ->groupBy('kemandoran', 'panel_sadap')
            ->get();
        $class3 = DB::table('assessments')
            ->select('kemandoran', 'panel_sadap', DB::raw('COUNT(*) AS penyadap'))
            ->where('nilai', '>', 20.9)
            ->where('nilai', '<=', 26.9)
            ->groupBy('kemandoran', 'panel_sadap')
            ->get();
        $class4 = DB::table('assessments')
            ->select('kemandoran', 'panel_sadap', DB::raw('COUNT(*) AS penyadap'))
            ->where('nilai', '>', 26.9)
            ->where('nilai', '<=', 32.9)
            ->groupBy('kemandoran', 'panel_sadap')
            ->get();
        $noClass = DB::table('assessments')
            ->select('kemandoran', 'panel_sadap', DB::raw('COUNT(*) AS penyadap'))
            ->where('nilai', '>', 32.9)
            ->groupBy('kemandoran', 'panel_sadap')
            ->get();

        // dd($class1, $class2, $class3, $class4, $noClass);

        // Group all data by kemandoran and panel_sadap for easier display
        $summaryByKemandoranPanel = [];

        // Process each class data
        foreach ($class1 as $item) {
            $key = $item->kemandoran . ' - ' . $item->panel_sadap;
            $summaryByKemandoranPanel[$key]['kemandoran'] = $item->kemandoran;
            $summaryByKemandoranPanel[$key]['panel_sadap'] = $item->panel_sadap;
            $summaryByKemandoranPanel[$key]['class_1'] = $item->penyadap;
        }

        foreach ($class2 as $item) {
            $key = $item->kemandoran . ' - ' . $item->panel_sadap;
            $summaryByKemandoranPanel[$key]['kemandoran'] = $item->kemandoran;
            $summaryByKemandoranPanel[$key]['panel_sadap'] = $item->panel_sadap;
            $summaryByKemandoranPanel[$key]['class_2'] = $item->penyadap;
        }

        foreach ($class3 as $item) {
            $key = $item->kemandoran . ' - ' . $item->panel_sadap;
            $summaryByKemandoranPanel[$key]['kemandoran'] = $item->kemandoran;
            $summaryByKemandoranPanel[$key]['panel_sadap'] = $item->panel_sadap;
            $summaryByKemandoranPanel[$key]['class_3'] = $item->penyadap;
        }

        foreach ($class4 as $item) {
            $key = $item->kemandoran . ' - ' . $item->panel_sadap;
            $summaryByKemandoranPanel[$key]['kemandoran'] = $item->kemandoran;
            $summaryByKemandoranPanel[$key]['panel_sadap'] = $item->panel_sadap;
            $summaryByKemandoranPanel[$key]['class_4'] = $item->penyadap;
        }

        foreach ($noClass as $item) {
            $key = $item->kemandoran . ' - ' . $item->panel_sadap;
            $summaryByKemandoranPanel[$key]['kemandoran'] = $item->kemandoran;
            $summaryByKemandoranPanel[$key]['panel_sadap'] = $item->panel_sadap;
            $summaryByKemandoranPanel[$key]['no_class'] = $item->penyadap;
        }

        // Fill missing values with 0 and calculate totals
        foreach ($summaryByKemandoranPanel as $key => &$data) {
            $data['class_1'] = $data['class_1'] ?? 0;
            $data['class_2'] = $data['class_2'] ?? 0;
            $data['class_3'] = $data['class_3'] ?? 0;
            $data['class_4'] = $data['class_4'] ?? 0;
            $data['no_class'] = $data['no_class'] ?? 0;
            $data['total'] = $data['class_1'] + $data['class_2'] + $data['class_3'] + $data['class_4'] + $data['no_class'];
        }

        // Sort by kemandoran then by panel_sadap
        ksort($summaryByKemandoranPanel);
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
            'class1' => $class1,
            'class2' => $class2,
            'class3' => $class3,
            'class4' => $class4,
            'noClass' => $noClass,
            'departments' => $departments,
            'bloks' => $bloks,
            'kemandoran' => $kemandoran,
            'panelSadap' => $panelSadap,
            'filters' => request()->only(['search', 'department', 'blok', 'kemandoran'])
        ]);
    }
}
