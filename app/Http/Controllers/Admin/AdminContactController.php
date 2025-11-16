<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class AdminContactController extends Controller
{
    // LIST
    public function index()
    {
        $contacts = Contact::latest()->paginate(10);
        return view('admin.contacts.index', compact('contacts'));
    }

    // SHOW
    public function show($id)
    {
        $contact = Contact::findOrFail($id);
        return view('admin.contacts.show', compact('contact'));
    }

    // DELETE
    public function destroy($id)
    {
        Contact::findOrFail($id)->delete();
        return redirect()->route('admin.contacts.index')
            ->with('success', 'Message deleted successfully.');
    }
}

