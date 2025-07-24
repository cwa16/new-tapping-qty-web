<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BlokController extends Controller
{
    public function index()
    {
        return view('master-blok.index', [
            'title' => 'Blok List',
        ]);
    }
}
