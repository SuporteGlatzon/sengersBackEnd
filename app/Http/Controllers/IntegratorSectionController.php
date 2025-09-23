<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IntegratorSectionController extends Controller
{
    public function index()
    {
        $section = \App\Models\IntegratorSection::first();
        return response()->json($section);
    }
}
