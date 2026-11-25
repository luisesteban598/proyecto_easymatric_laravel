<?php

namespace App\Http\Controllers;

use App\Models\Academic_Period;
use App\Models\Academic_Year;
use Illuminate\Http\Request;

class AcademicPeriodController extends Controller
{
    public function index()
    {
        $periods = Academic_Period::with('academicYear')
            ->orderBy('sort_orden', 'asc')
            ->get();

        return view('academic_periods.index', compact('periods'));
    }

    public function create()
    {
        $academicYears = Academic_Year::all();
        return view('academic_periods.create', compact('academicYears'));
    }

    public function store(Request $request)
    {
        return redirect()->route('academic_periods.index')
            ->with('success', 'Periodo académico creado correctamente.');
    }

    public function show($id)
    {
        $period = Academic_Period::with(['academicYear', 'modules', 'grades'])
            ->findOrFail($id);

        return view('academic_periods.show', compact('period'));
    }

    public function edit($id)
    {
        $period = Academic_Period::findOrFail($id);
        $academicYears = Academic_Year::all();

        return view('academic_periods.edit', compact('period', 'academicYears'));
    }

    public function update(Request $request, $id)
    {
        return redirect()->route('academic_periods.index')
            ->with('success', 'Periodo académico actualizado correctamente.');
    }

    public function destroy($id)
    {
        $period = Academic_Period::findOrFail($id);
        $period->delete();

        return redirect()->route('academic_periods.index')
            ->with('success', 'Periodo académico eliminado correctamente.');
    }
}