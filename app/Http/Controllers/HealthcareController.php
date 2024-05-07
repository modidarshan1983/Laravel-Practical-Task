<?php

namespace App\Http\Controllers;

use App\Models\Healthcare;
use Illuminate\Http\Request;

class HealthcareController extends Controller
{
    public function index()
    {
        $healthcareProfessionals = Healthcare::all();
        return response()->json($healthcareProfessionals);
    }
}
