<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TreeAssessmentController extends Controller
{
    public function index(Request $request)
    {
        // Build the query with filters
        $query = DB::table('assessments');
        $search = $request->input('search', '');
        $department = $request->input('department', '');
        $blok = $request->input('blok', '');
        $kemandoran = $request->input('kemandoran', '');
        $dateFrom = $request->input('date_from', '');
        $dateTo = $request->input('date_to', '');

        // Search by nama penyadap
        if ($request->filled('search')) {
            $query->where('nama_penyadap', 'LIKE', '%' . $search . '%');
        }

        // Filter by department
        if ($request->filled('department') && $department !== '') {
            $query->where('dept', $department);
        }

        // Filter by blok
        if ($request->filled('blok') && $blok !== '') {
            $query->where('blok', $blok);
        }

        // Filter by kemandoran
        if ($request->filled('kemandoran') && $kemandoran !== '') {
            $query->where('kemandoran', $kemandoran);
        }

        // Filter by date range
        if ($request->filled('date_from') && $dateFrom !== '') {
            $query->whereDate('tgl_inspeksi', '>=', $dateFrom);
        }

        if ($request->filled('date_to') && $dateTo !== '') {
            $query->whereDate('tgl_inspeksi', '<=', $dateTo);
        }

        // Get filtered assessments
        $assessments = $query->orderBy('tgl_inspeksi', 'desc')->paginate(20);

        // Get filter options
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

        return view('assessments.index', [
            'title' => 'Assessments List',
            'assessments' => $assessments,
            'departments' => $departments,
            'bloks' => $bloks,
            'kemandoran' => $kemandoran,
            'filters' => $request->only(['search', 'department', 'blok', 'kemandoran', 'date_from', 'date_to'])
        ]);
    }
}
