<?php

namespace App\Http\Controllers;

use App\Models\Academic_Year;
use App\Models\Institution;
use Illuminate\Http\Request;

class AcademicYearController extends Controller
{
    public function index(){

        $academic_years=Academic_Year::all();

        return response()->json($academic_years);
    }

    public function store(Request $request){
         $academic_years = Academic_Year::create($request->all());
         return response()->json($academic_years);
    }
    
    public function show ($id){

        $academic_years=Academic_Year::find($id);
        return response()->json($academic_years);


    }

    public function update(Request $request, Academic_Year $academic_years)
    {
    //metodo mas sencillo sin nesecidad de poner todo lo que pertenece a esa tabla
        $academic_years->update($request->all());

        return response()->json($academic_years);
    }
    //Destroy se encuentra el registro para luego eliminarlo..
    public function destroy(Academic_Year $academic_years)
    {
        $academic_years->delete();
        return response()->json($academic_years);
    }
}