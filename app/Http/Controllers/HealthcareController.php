<?php

namespace App\Http\Controllers;

use App\Models\Healthcare;
use Illuminate\Http\Request;
use Auth;

class HealthcareController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if(!$user){
            return response()->json(['message' => 'Unauthorized user'], 400);
        }
        $healthcareProfessionals = Healthcare::all();
        return response()->json($healthcareProfessionals);
    }
}
