<?php

namespace App\Http\Controllers;

use App\Models\Academic_Year;
use App\Models\Institution;
use Illuminate\Http\Request;

class AcademicYearController extends Controller
{
    public function index()
    {
        $academicYears = Academic_Year::with('institution')->get();
        return view('academic_years.index', compact('academicYears'));
    }

    public function create()
    {
        $institutions = Institution::all();
        return view('academic_years.create', compact('institutions'));
    }

    public function store(Request $request)
    {
        return redirect()->route('academic_years.index');
    }

    public function show($id)
    {
        $academicYear = Academic_Year::with(['institution', 'periods', 'classGroups', 'enrollments'])
            ->findOrFail($id);

        return view('academic_years.show', compact('academicYear'));
    }

    public function edit($id)
    {
        $academicYear = Academic_Year::findOrFail($id);
        $institutions = Institution::all();

        return view('academic_years.edit', compact('academicYear', 'institutions'));
    }

    public function update(Request $request, $id)
    {
        $academicYear = Academic_Year::findOrFail($id);
        return redirect()->route('academic_years.index');
    }

    public function destroy($id)
    {
        $academicYear = Academic_Year::findOrFail($id);
        $academicYear->delete();

        return redirect()->route('academic_years.index');
    }
}