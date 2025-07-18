<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TreeAssessmentController extends Controller
{
    public function index()
    {
        return view('assessments.index', [
            'title' => 'Tree Assessments'
        ]);
    }
}
