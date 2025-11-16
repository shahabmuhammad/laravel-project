<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Publisher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class PublisherController extends Controller
{
    public function index()
    {
        $publishers = Publisher::latest()->paginate(10);
        return view('admin.publishers.index', compact('publishers'));
    }

    public function create()
    {
        return view('admin.publishers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:publishers',
            'website' => 'nullable|url',
            'address' => 'nullable|string',
        ]);

        Publisher::create($validated);
        return redirect()->route('admin.publishers.index')->with('success', 'Publisher added successfully!');
    }

    public function edit($id)
    {
        $id = Crypt::decrypt($id);
        $publisher=Publisher::findOrFail($id);
        return view('admin.publishers.edit', compact('publisher'));
    }
public function show($id)
{
    $id = Crypt::decrypt($id);
    $publisher=Publisher::findOrFail($id);
    return view('admin.publishers.show', compact('publisher'));
}

    public function update(Request $request,$id)
    {
        $id = Crypt::decrypt($id);
        $publisher=Publisher::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:publishers,name,' . $publisher->id,
            'website' => 'nullable|url',
            'address' => 'nullable|string',
        ]);

        $publisher->update($validated);
        return redirect()->route('admin.publishers.index')->with('success', 'Publisher updated successfully!');
    }

    public function destroy($id)
    {
        $id = Crypt::decrypt($id);
        $publisher=Publisher::findOrFail($id);
        $publisher->delete();
        return back()->with('success', 'Publisher deleted successfully!');
    }
}
