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
   

    public function update(Request $request, Academic_Period $academicPeriods)
    {
    //metodo mas sencillo sin nesecidad de poner todo lo que pertenece a esa tabla
        $academicPeriods->update($request->all());

        return response()->json($academicPeriods);
    }
    //Destroy se encuentra el registro para luego eliminarlo..
    public function destroy(Academic_Period $academicPeriods)
    {
        $academicPeriods->delete();
        return response()->json($academicPeriods);
    }

}