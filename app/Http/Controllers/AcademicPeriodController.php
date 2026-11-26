<?php

namespace App\Http\Controllers;

use App\Models\Academic_Period;
use App\Models\Academic_Year;
use Illuminate\Http\Request;

class AcademicPeriodController extends Controller
{
    public function index(){
        $academicPeriods=Academic_Period::all();
        return response()->json($academicPeriods);

    }
    
    public function store(Request $request){
        $academicPeriods = Academic_Period::create($request->all());
        return response()->json($academicPeriods);
    }
    
    public function show ($id){
        $academicPeriods=Academic_Period::find($id);
        return response()->json($academicPeriods);
    }

    public function update(Request $request, Academic_Period $academicPeriod)
    {
        $academicPeriod->update($request->all());
        return response()->json($academicPeriod);
    }

    public function destroy(Academic_Period $academicPeriod)
    {
        $academicPeriod->delete();
        return response()->json($academicPeriod);
    }

}