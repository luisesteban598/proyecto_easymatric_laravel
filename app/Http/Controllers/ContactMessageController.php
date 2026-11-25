<?php

namespace App\Http\Controllers;

use App\Models\Contact_Message;
use App\Models\UserSystem;
use Illuminate\Http\Request;

class ContactMessageController extends Controller
{
    public function index()
    {
        $contactMessages = Contact_Message::all();
        return response()->json($contactMessages);
    }

    public function store(Request $request)
    {
        $contactMessages = Contact_Message::create($request->all());
        return response()->json($contactMessages);
    }

    public function show($id)
    {
        $contactMessages = Contact_Message::find($id);
        return response()->json($contactMessages);
    }


    public function update(Request $request, Contact_Message $contactMessages)
    {
        $contactMessages->update($request->all());
        return response()->json($contactMessages);
    }

    public function destroy(Contact_Message $contactMessages)
    {
        $contactMessages->delete();
        return response()->json($contactMessages);
    }
}