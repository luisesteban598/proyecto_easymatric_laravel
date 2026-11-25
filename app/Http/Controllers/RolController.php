<?php

namespace App\Http\Controllers;

use App\Models\Rol;
use Illuminate\Http\Request;

class RolController extends Controller
{
    public function index(){
        $rols = Rol::all();
        return response()->json($rols);
    }

    public function store(Request $request){
        $rols = Rol::create($request->all());
        return response()->json($rols);
    }

    public function show ($id){

        $rols = Rol::findOrFail($id);
        return response()->json($rols);
        
    }

    public function update(Request $request, Rol $rol){
        $rol->update($request->all());
        return response()->json($rol);
    }

    public function destroy(Rol $rol)
    {
        $rol->delete();
        return $rol;
    }
}
