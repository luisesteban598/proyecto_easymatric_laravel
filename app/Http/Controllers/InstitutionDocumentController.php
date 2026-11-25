<?php

namespace App\Http\Controllers;

use App\Models\Institution_Document;
use App\Models\Institution;
use App\Models\Campuse;
use Illuminate\Http\Request;

class InstitutionDocumentController extends Controller
{
    public function index()
    {
        $institutionDocuments = Institution_Document::all();
        return response()->json($institutionDocuments);
    }

    public function create()
    {
        $institutions = Institution::all();
        $campuses = Campuse::all();

        return view('institution_documents.create', compact('institutions', 'campuses'));
    }

    public function store(Request $request)
    {
        $institutionDocuments = Institution_Document::create($request->all());
        return response()->json($institutionDocuments);
    }

    public function show($id)
    {
        $institutionDocuments = Institution_Document::find($id);
        return response()->json($institutionDocuments);
    }

    public function edit(Institution_Document $institutionDocuments)
    {
        $institutions = Institution::all();
        $campuses = Campuse::all();

        return response()->json(compact('institutionDocuments', 'institutions', 'campuses'));
    }

    public function update(Request $request, Institution_Document $institutionDocuments)
    {
        $institutionDocuments->update($request->all());
        return response()->json($institutionDocuments);
    }

    public function destroy(Institution_Document $institutionDocuments)
    {
        $institutionDocuments->delete();
        return response()->json($institutionDocuments);
    }
}